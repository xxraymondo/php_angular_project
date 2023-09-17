<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone', // Added the 'phone' column
        'address', // Added the 'address' column
        'role', // Added the 'role' column
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
        public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Define a one-to-one relationship with the Cart model.
     */

    public function hasCart()
    {
        return $this->cart()->exists();
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }




    /**
     * Define a one-to-many relationship with the Order model.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
