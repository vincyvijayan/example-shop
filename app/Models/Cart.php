<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Cart extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cart';

    protected $fillable = ['user_id','price','product_id','quantity'];

    public function product()
	{
	   return $this->belongsTo(Product::class,'product_id');
	}

}
