<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function createOrder(Request $request)
    {
        $user = auth()->user();

        // Retrieve the user's cart items
        $cartItems = CartItem::where('cart_id', $user->cart->cart_id)->get();

         // Check if the cart is empty
        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty'], Response::HTTP_BAD_REQUEST);
        }

        // Calculate the order total
        $orderTotal = $cartItems->sum('product_subtotal');

        // Validate the request
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|string|email|max:255',
            'customer_phone' => 'required|string|max:255',
            'customer_address' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }
            // dd($user->id);
        // Create a new order
        $order = Order::create([
            'order_number' => 'ORD-' . time(), // You can generate a unique order number here
            'user_id' => $user->id, // Add the user_id
            'customer_name' => $request->input('customer_name'),
            'customer_email' => $request->input('customer_email'),
            'customer_phone' => $request->input('customer_phone'),
            'customer_address' => $request->input('customer_address'),
            'order_status' => 'Pending', // You can set the initial status here
            'order_date' => now(),
            'order_total' => $orderTotal,
            'order_items' => $cartItems,
        ]);

        // Remove the cart items
        CartItem::where('cart_id', $user->cart->cart_id)->delete();

        return response()->json(['message' => 'Order placed successfully', 'order' => $order], Response::HTTP_CREATED);
    }

// public function createOrder(Request $request)
// {
//     $user = auth()->user();

//     // Retrieve the user's cart items
//     $cartItems = CartItem::where('cart_id', $user->cart->cart_id)->get();

//     // Calculate the order total
//     $orderTotal = $cartItems->sum('product_subtotal');

//     // Validate the request
//     $validator = Validator::make($request->all(), [
//         'customer_name' => 'required|string|max:255',
//         'customer_email' => 'required|string|email|max:255',
//         'customer_phone' => 'required|string|max:255',
//         'customer_address' => 'required|string|max:255',
//     ]);

//     if ($validator->fails()) {
//         return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
//     }

//     // Create an array to store order items
//     $orderItems = [];

//     foreach ($cartItems as $cartItem) {
//         $orderItems[] = [
//             'product_name' => $cartItem->product_name,
//             'product_quantity' => $cartItem->product_quantity,
//             'product_subtotal' => $cartItem->product_subtotal,
//         ];
//     }
//         // dd($orderItems);
//     // Create a new order with order items
//     $order = Order::create([
//         'order_number' => 'ORD-' . time(), // You can generate a unique order number here
//         'customer_name' => $request->input('customer_name'),
//         'customer_email' => $request->input('customer_email'),
//         'customer_phone' => $request->input('customer_phone'),
//         'customer_address' => $request->input('customer_address'),
//         'order_status' => 'Pending', // You can set the initial status here
//         'order_date' => now(),
//         'order_total' => $orderTotal,
//         'order_items' => $orderItems, // Store order items as JSON
//     ]);

//     // Remove the cart items
//     CartItem::where('cart_id', $user->cart->cart_id)->delete();

//     return response()->json(['message' => 'Order placed successfully', 'order' => $order], Response::HTTP_CREATED);
// }

    public function myListOrders()
    {
        $user = auth()->user();

        // Retrieve the user's orders
        $orders = Order::where('user_id', $user->id)->get();

        return response()->json(['data' => $orders], Response::HTTP_OK);
    }


    public function viewAllOrders()
{
    // Retrieve all orders
    $orders = Order::all();

    return response()->json(['data' => $orders], Response::HTTP_OK);
}


public function getOrderById($orderId)
{
    // Find the order by its ID
    $order = Order::find($orderId);

    if (!$order) {
        return response()->json(['message' => 'Order not found'], Response::HTTP_NOT_FOUND);
    }

    return response()->json(['data' => $order], Response::HTTP_OK);
}


public function updateOrderStatus(Request $request, $orderId)
{
    // Find the order by its ID
    $order = Order::find($orderId);

    if (!$order) {
        return response()->json(['message' => 'Order not found'], Response::HTTP_NOT_FOUND);
    }

    // Validate the request
    $validator = Validator::make($request->all(), [
        'order_status' => 'required|string|max:255', // You can add any validation rules you need
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
    }

    // Update the order status
    $order->order_status = $request->input('order_status');
    $order->save();

    return response()->json(['message' => 'Order status updated successfully', 'data' => $order], Response::HTTP_OK);
}

}

