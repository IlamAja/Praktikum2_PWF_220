<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryApiController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        try {
            $categories = Kategori::all();

            return response()->json([
                'message' => 'Categories retrieved successfully',
                'data' => $categories
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data kategori', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Gagal mengambil data kategori',
            ], 500);
        }
    }

    /**
     * Store a newly created category in database.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'name' => 'required|string|max:255',
            ]);

            $category = Kategori::create($validated);

            Log::info('Menambah data kategori', [
                'list' => $category
            ]);

            return response()->json([
                'message' => 'Kategori berhasil ditambahkan!!',
                'data' => $category,
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Error saat menambah kategori', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Error saat menambah kategori',
            ], 500);
        }
    }

    /**
     * Display the specified category.
     */
    public function show(int $id)
    {
        try {
            $category = Kategori::find($id);

            if (!$category)
            {
                return response()->json([
                    'message' => 'Kategori tidak ditemukan',
                ], 404);
            }

            return response()->json([
                'message' => 'Kategori retrieved successfully',
                'data' => $category
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data kategori', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Gagal mengambil data kategori',
            ], 500);
        }
    }

    /**
     * Update the specified category in database.
     */
    public function update(Request $request, int $id)
    {
        try {
            $category = Kategori::find($id);

            if (!$category)
            {
                return response()->json([
                    'message' => 'Kategori tidak ditemukan',
                ], 404);
            }

            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'name' => 'required|string|max:255',
            ]);

            $category->update($validated);

            Log::info('Update data kategori', [
                'list' => $category
            ]);

            return response()->json([
                'message' => 'Kategori berhasil diperbarui!!',
                'data' => $category,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Error saat update kategori', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Error saat update kategori',
            ], 500);
        }
    }

    /**
     * Remove the specified category from database.
     */
    public function destroy(int $id)
    {
        try {
            $category = Kategori::find($id);

            if (!$category)
            {
                return response()->json([
                    'message' => 'Kategori tidak ditemukan',
                ], 404);
            }

            $category->delete();

            Log::info('Delete data kategori', [
                'id' => $id
            ]);

            return response()->json([
                'message' => 'Kategori berhasil dihapus!!',
            ], 204);
        } catch (\Throwable $e) {
            Log::error('Error saat delete kategori', [
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Error saat delete kategori',
            ], 500);
        }
    }
}
