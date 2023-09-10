<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Libraries\ResponseBase;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['getAll']]);
        $this->middleware('permission:product-list', ['only' => ['show']]);
        $this->middleware('permission:product-create', ['only' => ['store']]);
        $this->middleware('permission:product-edit', ['only' => ['update']]);
        $this->middleware('permission:product-delete', ['only' => ['delete']]);
    }

    public function getAll()
    {
        dd('get');
        $products = $this->productService->getAll();
        
        return ResponseBase::success('Berhasil mendapatkan data produk!', $products);
    }

    public function show($id)
    {
        // Implementasi logika untuk menampilkan produk.
    }

    public function store(ProductRequest $request)
    {
        dd('create');
        try {
            $data = $request->all();
            $product = $this->productService->createProduct($data);

            return ResponseBase::success("Berhasil menambahkan data produk!", $product, 201);
        } catch (\Exception $e) {
            // Tangkap dan kelola pengecualian di sini.
            return ResponseBase::error("Gagal menambahkan data produk!", $product);
        }
    }

    public function update(Request $request, $id)
    {
        // Implementasi logika untuk mengupdate produk.
    }

    public function delete($id)
    {
        // Implementasi logika untuk menghapus produk.
    }
}
