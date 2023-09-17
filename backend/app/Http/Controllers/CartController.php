<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function addToCart(Request $request, $productId)
    {
        // Check if the user is logged in
        if (auth()->user()) {
            // Get the current user
            $user = auth()->user();

            // Find the product by ID
            $product = Product::findOrFail($productId);

            // Validate the request
            // $validator = Validator::make($request->all(), [
            //     'quantity' => 'required|integer|min:1',
            // ]);

            // if ($validator->fails()) {
            //     return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
            // }

            // Add the product to the user's cart with the specified quantity
            // $request->input('quantity');
            $quantity = 1 ;
            $user->cart->cartItems()->create([
                'cart_id' => $user->cart->cart_id,
                'product_id' => $product->product_id,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'product_quantity' => $quantity,
                'product_subtotal' => $quantity * $product->price,
            ]);


            return response()->json(['message' => 'Product added to cart'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Please login to add product to cart'], Response::HTTP_UNAUTHORIZED);
        }
    }



public function viewCartItems()
{
    // Check if the user is logged in
    if (auth()->user()) {
        // Get the current user
        $user = auth()->user();

        // Check if the user has a cart
        if (!$user->cart) {
            return response()->json(['message' => 'Cart is empty'], Response::HTTP_OK);
        }

        // Retrieve the cart items for the user's cart
        $cartItems = $user->cart->cartItems;

        return response()->json(['data' => $cartItems], Response::HTTP_OK);
    } else {
        return response()->json(['message' => 'Please login to view cart items'], Response::HTTP_UNAUTHORIZED);
    }
}


public function removeCartItem($cartItemId)
{
    // Check if the user is logged in
    if (auth()->user()) {
        // Get the current user
        $user = auth()->user();

        // Find the cart item by ID
        $cartItem = CartItem::find($cartItemId);

        // Check if the cart item exists
        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found'], Response::HTTP_NOT_FOUND);
        }

        $cart = Cart::find($cartItem->cart_id);

        // Check if the user is authorized to remove the cart item
        if (!$cart || $cart->cart_id !== $cartItem->cart_id) {
            return response()->json(['message' => 'Unauthorized to remove this cart item'], Response::HTTP_UNAUTHORIZED);
        }
        // dd($cart->cart_id);
        // Delete the cart item
        $cartItem->delete();

        return response()->json(['message' => 'Cart item removed successfully'], Response::HTTP_OK);
    } else {
        return response()->json(['message' => 'Please login to remove cart items'], Response::HTTP_UNAUTHORIZED);
    }
}


public function increaseProductQuantity($cartItemId)
{
    // Check if the user is logged in
    if (auth()->user()) {
        // Find the cart item by ID
        $cartItem = CartItem::find($cartItemId);

        // Check if the cart item exists
        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found'], Response::HTTP_NOT_FOUND);
        }

        // Increment the quantity by 1
        $cartItem->update(['product_quantity' => $cartItem->product_quantity + 1]);

        // Update the subtotal based on the updated quantity
        $cartItem->update(['product_subtotal' => $cartItem->product_price * $cartItem->product_quantity]);

        return response()->json(['message' => 'Product quantity increased successfully'], Response::HTTP_OK);
    } else {
        return response()->json(['message' => 'Please login to modify cart items'], Response::HTTP_UNAUTHORIZED);
    }
}


public function decreaseProductQuantity($cartItemId)
{
    // Check if the user is logged in
    if (auth()->user()) {
        // Find the cart item by ID
        $cartItem = CartItem::find($cartItemId);

        // Check if the cart item exists
        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found'], Response::HTTP_NOT_FOUND);
        }

        // Ensure the quantity is greater than 1 before decreasing
        if ($cartItem->product_quantity > 1) {
            // Decrease the quantity by 1
            $cartItem->update(['product_quantity' => $cartItem->product_quantity - 1]);

            // Update the subtotal based on the updated quantity
            $cartItem->update(['product_subtotal' => $cartItem->product_price * $cartItem->product_quantity]);

            return response()->json(['message' => 'Product quantity decreased successfully'], Response::HTTP_OK);
        } else {
            // If the quantity is already 1, you can choose to remove the item or return an error message.
            // Example: $cartItem->delete();
            return response()->json(['message' => 'Product quantity cannot be less than 1'], Response::HTTP_BAD_REQUEST);
        }
    } else {
        return response()->json(['message' => 'Please login to modify cart items'], Response::HTTP_UNAUTHORIZED);
    }
}


public function emptyCart()
{
    // Check if the user is logged in
    if (auth()->user()) {
        // Get the current user
        $user = auth()->user();

        // Check if the user has a cart
        if (!$user->cart) {
            return response()->json(['message' => 'Cart is already empty'], Response::HTTP_OK);
        }

        // Delete all cart items associated with the user's cart
        $user->cart->cartItems()->delete();

        return response()->json(['message' => 'Cart emptied successfully'], Response::HTTP_OK);
    } else {
        return response()->json(['message' => 'Please login to empty the cart'], Response::HTTP_UNAUTHORIZED);
    }
}



}





