<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    // Cria o metodo de salvar o material no banco de dados
    public function store(Request $request) {
        $material = new Material();
        $material->save();
    }
}
