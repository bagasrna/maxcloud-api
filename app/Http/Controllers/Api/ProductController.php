<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Libraries\ResponseBase;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getAll()
    {
        // Implementasi logika untuk menampilkan semua produk.
    }

    public function show($id)
    {
        // Implementasi logika untuk menampilkan produk.
    }

    public function create(ProductRequest $request)
    {
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
