<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function create() {
        return view("materials/form");
    }

    // Cria o metodo de salvar o material no banco de dados
    public function store(Request $request) {
        $material = new Material();

        $material->user_id = 1;
        $material->file_url = 'link url';
        $material->description = $request->description;

        $material->save();

        return response()->json([
            "user_id" => $material->user_id,
            "file_url" => $material->file_url,
            "description" => $material->description
        ]);
    }
}
