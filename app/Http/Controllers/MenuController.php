<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
class MenuController extends Controller
{
    public function index(Request $request)
    {
        $tableNumber = $request->query('meja');
        if($tableNumber) {
            Session::put('table_number', $tableNumber);
        }

        $items = Item::where('is_available', 1)->orderBy('name', 'asc')->get();
        return view('customer.menu', compact('items', 'tableNumber'));
    }

    public function cart()
    {
        $cart = Session::get('cart');
        return view('customer.cart', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $menuId = $request->input('id');
        $menu = Item::find($menuId);

        if (!$menu) {
            return response()->json([
                'status' => 'error',
                'message' => 'Menu tidak ditemukan'
            ], 404);
        }
        $cart = Session::get('cart');
        if (isset($cart[$menuId])) {
            $cart[$menuId]['qty'] += 1;
        } else {
            $cart[$menuId] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'img' => $menu->img,
                'qty' => 1
            ];
        }
        Session::put('cart', $cart);
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menambahkan ke keranjang',
            'cart' => $cart
        ]);
    }

    public function updateCart(Request $request)
    {
        $itemId = $request->input('id');
        $newQty = $request->input('qty');

        if($newQty <= 0) {
            return response()->json([
                'success' => false,
            ]);
        }
        $cart = Session::get('cart');
        if(isset($cart[$itemId])) {
            $cart[$itemId]['qty'] = $newQty;
            Session::put('cart', $cart);
            // Session::flash('success', 'Jumlah item berhasil diperbarui');

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
    
    public function removeFromCart(Request $request)
    {
        $itemId = $request->input('id');
        $cart = Session::get('cart');

        if(isset($cart[$itemId])){
            unset($cart[$itemId]);
            session::put('cart', $cart);

            return response()->json(['success' => true]);
        }
    }

    public function clearCart()
    {
        Session::forget('cart');
        return redirect()->route('cart');
    }

    // checkout function will be implemented later

    public function checkout()
    {
        $cart = Session::get('cart');
        if(empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang Anda kosong');
        }
        $tableNumber = Session::get('table_number');
        return view('customer.checkout', compact('cart','tableNumber'));
    }

    public function storeOrder(Request $request)
    {
       $cart = Session::get('cart');
       $tableNumber = Session::get('table_number');
       if(empty($cart)) {
           return redirect()->route('cart')->with('error', 'Keranjang Anda kosong');
       }

       $validator = Validator::make($request->all(), [
              'fullname' => 'required|string|max:255',
              'phone' => 'required|string|max:15',
       ]);

       if ($validator->fails()) {
           return redirect()->route('checkout')->withErrors($validator)->withInput();
       }

       $total = 0;
       foreach($cart as $item) {
           $total += $item['price'] * $item['qty'];
       }
       $totalAmount = 0;
       foreach($cart as $item) {
           $totalAmount += $item['price'] * $item['qty'];

           $itemDetails[] = [
               'id' => $item['id'],
               'name' => substr($item['name'], 0, 50),
               'price' => (int) $item['price'] + ($item['price'] * 0.1),
               'quantity' => $item['qty'],
           ];
       }

       $user = User::firstOrCreate([
           'fullname' => $request->input('fullname'),
           'phone' => $request->input('phone'),
           'role_id' => 4
       ]);

       $order = Order::create([
        'order_code' => 'ORD-' . $tableNumber . '-' . time(),
        'user_id' => $user->id,
        'subtotal' => $totalAmount,
        'tax' => $totalAmount * 0.1,
        'grand_total' => $totalAmount + ($totalAmount * 0.1),
        'status' => 'pending',
        'table_number' => $tableNumber,
        'payment_method' => $request->input('payment_method'),
        'notes' => $request->input('notes'),
       ]);

       foreach ($cart as $itemId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $item['id'],
                'quantity' => $item['qty'],
                'price' => $item['price'] * $item['qty'],
                'tax' => $item['price'] * 0.1,
                'total_price' => ($item['price'] * $item['qty']) + ($item['price'] * $item['qty'] * 0.1),
            ]);
       }
       
       Session::forget('cart');

       return redirect()->route('menu')->with('success', 'Pesanan Anda telah diterima. Terima kasih!');
    }
}
