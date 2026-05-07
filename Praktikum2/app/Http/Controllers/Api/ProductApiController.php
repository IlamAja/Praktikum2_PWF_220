<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductApiController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index()
    {
        try {
            $products = Product::with('kategoris')->get();

            return response()->json([
                'message' => 'Products retrieved successfully',
                'data' => $products
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data produk', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Gagal mengambil data produk',
            ], 500);
        }
    }

    /**
     * Store a newly created product in database.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $validated = $request->validated();

            $validated['user_id'] = Auth::id();

            $product = Product::create($validated);

            Log::info('Menambah data produk', [
                'list' => $product
            ]);

            return response()->json([
                'message' => 'Produk berhasil ditambahkan!!',
                'data' => $product,
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Error saat menambah product', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Error saat menambah product',
            ], 500);
        }
    }

    /**
     * Display the specified product.
     */
    public function show(int $id)
    {
        try {
            $product = Product::with('kategoris')->find($id);

            if (!$product)
            {
                return response()->json([
                    'message' => 'Product tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'message' => 'Product retrieved successfully',
                'data' => $product
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data produk', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Gagal mengambil data produk',
            ], 500);
        }
    }

    /**
     * Update the specified product in database.
     */
    public function update(StoreProductRequest $request, int $id)
    {
        try {
            $product = Product::find($id);

            if (!$product)
            {
                return response()->json([
                    'message' => 'Product tidak ditemukan',
                ], 404);
            }

            // Check authorization - user can only update their own products
            if ($product->user_id !== Auth::id()) {
                return response()->json([
                    'message' => 'Anda tidak memiliki akses untuk mengubah produk ini',
                ], 403);
            }

            $validated = $request->validated();
            $product->update($validated);

            Log::info('Update data produk', [
                'list' => $product
            ]);

            return response()->json([
                'message' => 'Produk berhasil diperbarui!!',
                'data' => $product,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Error saat update product', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Error saat update product',
            ], 500);
        }
    }

    /**
     * Remove the specified product from database.
     */
    public function destroy(int $id)
    {
        try {
            $product = Product::find($id);

            if (!$product)
            {
                return response()->json([
                    'message' => 'Product tidak ditemukan',
                ], 404);
            }

            // Check authorization - user can only delete their own products
            if ($product->user_id !== Auth::id()) {
                return response()->json([
                    'message' => 'Anda tidak memiliki akses untuk menghapus produk ini',
                ], 403);
            }

            $product->delete();

            Log::info('Delete data produk', [
                'id' => $id
            ]);

            return response()->json([
                'message' => 'Produk berhasil dihapus!!',
            ], 204);
        } catch (\Throwable $e) {
            Log::error('Error saat delete product', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Error saat delete product',
            ], 500);
        }
    }
}
