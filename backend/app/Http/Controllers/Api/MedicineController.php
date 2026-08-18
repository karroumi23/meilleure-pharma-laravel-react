<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\JsonResponse;

class MedicineController extends Controller
{
    public function index(): JsonResponse
    {
        $medicines = Medicine::query()
            ->with(['category', 'brand'])
            ->latest()
            ->paginate(12);

        return response()->json([
            'success' => true,
            'data' => $medicines,
        ]);
    }

    public function show(Medicine $medicine): JsonResponse
    {
        $medicine->load(['category', 'brand']);

        return response()->json([
            'success' => true,
            'data' => $medicine,
        ]);
    }
}