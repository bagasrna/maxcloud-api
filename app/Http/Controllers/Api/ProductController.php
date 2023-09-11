<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Libraries\ResponseBase;
use App\Services\ProductService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        $this->middleware('permission:admin-product-list|user-product-list', ['only' => ['getAll']]);
        $this->middleware('permission:admin-product-list|user-product-list', ['only' => ['show']]);
        $this->middleware('permission:admin-product-create', ['only' => ['store']]);
        $this->middleware('permission:admin-product-edit', ['only' => ['update']]);
        $this->middleware('permission:admin-product-delete', ['only' => ['delete']]);
    }

    public function getAll()
    {
        $products = $this->productService->getAll();
        
        return ResponseBase::success('Berhasil mendapatkan data produk!', $products);
    }

    public function show($id)
    {
        $product = $this->productService->findProduct($id);

        return ResponseBase::success('Berhasil mendapatkan data produk!', $product);
    }

    public function store(ProductRequest $request)
    {
        try {
            $data = $request->all();
            $product = $this->productService->createProduct($data);

            return ResponseBase::success("Berhasil menambahkan data produk!", $product, 201);
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan data produk: ' . $e->getMessage());
            return ResponseBase::error("Gagal menambahkan data produk!", 409);
        }
    }

    public function update(Product $product, ProductRequest $request)
    {
        try {
            $data = $request->all();
            $product = $this->productService->updateProduct($product, $data);

            return ResponseBase::success("Berhasil merubah data produk!", $product);
        } catch (\Exception $e) {
            Log::error('Gagal merubah data produk: ' . $e->getMessage());
            return ResponseBase::error("Gagal merubah data produk!", 409);
        }
    }

    public function delete(Product $product)
    {
        try {
            $this->productService->deleteProduct($product);
            return ResponseBase::success("Berhasil menghapus data produk!");
        } catch (\Exception $e) {
            Log::error('Gagal menghapus data produk: ' . $e->getMessage());
            return ResponseBase::error('Gagal menghapus data produk!', 409);
        }
    }
}
