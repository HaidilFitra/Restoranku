<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Category extends Model
{
    use softDeletes ,HasFactory;
    protected $fillable = ['cat_name', 'description', 'created_at', 'updated_at'];
    protected $dates = ['deleted_at'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
