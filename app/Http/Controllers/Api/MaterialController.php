<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::all();

        return response()->json($materials, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $material = Material::create([
            'user_id' => 1,
            'file_url' => 'link url',
            'name' => 'Material padrão',
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Material criado com sucesso',
            'data' => $material
        ], 201);
    }

    public function show($id)
    {
        $material = Material::find($id);

        if (!$material) {
            return response()->json([
                'message' => 'Material não encontrado'
            ], 404);
        }

        return response()->json($material, 200);
    }

    public function update(Request $request, $id)
    {
        $material = Material::find($id);

        if (!$material) {
            return response()->json([
                'message' => 'Material não encontrado'
            ], 404);
        }

        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        $material->update([
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Material atualizado com sucesso',
            'data' => $material
        ], 200);
    }

    public function destroy($id)
    {
        $material = Material::find($id);

        if (!$material) {
            return response()->json([
                'message' => 'Material não encontrado'
            ], 404);
        }

        $material->delete();

        return response()->json([   
            'message' => 'Material removido com sucesso'
        ], 200);
    }
}