<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'product_id'; // Update to match the primary key name in your database.

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'category',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'decimal:2',
        'status' => 'string',
    ];

    /**
     * Get the formatted price attribute.
     *
     * @param  float  $value
     * @return string
     */
    public function getPriceAttribute($value)
    {
        return number_format($value, 2);
    }

    /**
     * Set the price attribute.
     *
     * @param  float  $value
     * @return void
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = number_format($value, 2);
    }

    /**
     * Define a many-to-many relationship with the Cart model through the cart_items pivot table.
     */
    // public function carts()
    // {
    //     return $this->belongsToMany(Cart::class, 'cart_items')
    //         ->withPivot(['quantity']);
    // }

    /**
     * Define a one-to-many relationship with the OrderItem model.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
