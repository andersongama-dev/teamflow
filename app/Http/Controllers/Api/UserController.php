<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('classes')->with('success', 'Usuário cadastrado com sucesso!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect()->route('classes');
        }

        return back()->withErrors([
            'email' => 'E-mail ou senha inválidos.',
        ])->onlyInput('email');
    }
}