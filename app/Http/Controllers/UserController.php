<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request) {

        // validação primeiro
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ],[
            'required' => 'O campo :attribute é obrigatório',
            'email' => 'Digite um :attribute válido',
            'min' => 'O campo :attribute deve ter no mínimo :min caracteres',
            'confirmed' => 'As senhas não coincidem'
        ],[
            'name' => 'nome',
            'email' => 'e-mail',
            'password' => 'senha'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;

        // senha criptografada
        $user->password = Hash::make($request->password);

        // salvar
        $user->save();

        return response()->json([
            'user_email' => $user->email
        ]);
    }
}