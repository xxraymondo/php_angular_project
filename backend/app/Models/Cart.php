<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Product;
class Cart extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'carts';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'cart_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', // Add 'user_id' to the fillable array
        'created_at',
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    /**
     * Define a many-to-many relationship with the Product model.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_items')
        ->withTimestamps();
    }

    /**
     * Define a one-to-one relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
