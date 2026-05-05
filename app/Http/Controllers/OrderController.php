<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Your given code 
    // public function checkout(Request $request)
    // {
    //     $order = new Order();
    //     $order->user_id = Auth::id();
    //     $order->products()->attach($request->product_id, [
    //         'quantity' => $request->qty,
    //         'price' => Product::find($request->product_id)->price
    //     ]);
    //     DB::beginTransaction();
    //     try {
    //         $order->save();
    //         Payment::process($order->id, $request->payment_method); // Non-existent static method
    //         DB::commit();
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         return back()->with('error', 'Checkout failed');
    //     }
    //     return redirect()->route('orders.show', $order->id)
    //         ->with('success', 'Order placed successfully');
    // }

    // My code
    public function checkout(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'payment_method' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $order = new Order();
            $order->user_id = Auth::id();
            $order->save(); 

            $product = Product::findOrFail($request->product_id);
            $order->products()->attach($product->id, [
                'quantity' => $request->qty,
                'price' => $product->price
            ]);

            $paymentService = new PaymentService();
            $paymentService->process($order, $request->payment_method);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Checkout failed: ' . $e->getMessage());
        }

        return redirect()->route('orders.show', $order->id)
                        ->with('success', 'Order placed successfully');
    }  

    // Your given code problems
    // problem 1 : Not validate request data 
    // problem 2 : Transaction is wrong placed
    // problem 3 : calling a wrong method.


    // Note :  I am not create the PaymentService.php file for integrate payment gateway.

} 
