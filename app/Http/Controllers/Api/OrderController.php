<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Libraries\ResponseBase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function getAll(Request $request)
    {
        $rules = [
            'page' => 'nullable|integer',
            'limit' => 'nullable|integer',
            'search' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ResponseBase::error($validator->errors(), 422);

        $pageNumber = $request->input('page', 1);
        $dataAmount = $request->input('limit', 10);
        $search = $request->input('search', null);

        $orders = Order::search($search);

        if (Auth::guard('user')->check()) {
            $user = Auth::guard('user')->user();
            $orders = Order::where('user_id', $user->id);
        }

        $orders = $orders->paginate($dataAmount, ['*'], 'page', $pageNumber);

        return ResponseBase::success("Berhasil menerima data order", $orders);
    }

    public function store(Request $request)
    {
        if (Auth::guard('user')->check()) {
            $user = Auth::guard('user')->user();
        } else {
            return ResponseBase::error('Tidak ada hak akses!', 401);
        }

        $rules = [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ResponseBase::error($validator->errors(), 422);


        $product = Product::findOrFail($request->product_id);

        try {
            $order = new Order();
            $order->product_id = $request->product_id;
            $order->user_id = $user->id;
            $order->quantity = $request->quantity;
            $order->price = $request->quantity * $product->price;
            $order->notes = $request->filled('notes') ? $request->notes : null;
            $order->save();

            return ResponseBase::success("Berhasil menambahkan data order!", $order);
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan data order: ' . $e->getMessage());
            return ResponseBase::error('Gagal menambahkan data order!', 409);
        }
    }

    public function validateOrder(Request $request)
    {
        $rules = [
            'product_id' => 'required|exists:products,id',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
            return ResponseBase::error($validator->errors(), 422);

        $order = Order::findOrFail($request->product_id);

        try {
            $order->is_validate = 1;
            $order->save();
            return ResponseBase::success("Berhasil validasi data order", $order);
        } catch (\Exception $e) {
            Log::error('Gagal validasi data order: ' . $e->getMessage());
            return ResponseBase::error('Gagal validasi data order', 409);
        }
    }
}
