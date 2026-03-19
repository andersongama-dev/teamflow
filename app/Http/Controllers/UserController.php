<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function store(Request $request) {
        //Criando um objeto Usuário
        $user = new User();

        //Definindo os atributos do usuário
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        $request->validate([
            'name' => 'required|String|max:255',
            'email' => "required|email|unique:users ,email",
            'password' => "required|min:6|confirmed"
        ],[
            'required' => 'O campo :attribute é obrigatório',
            'required' => 'Digite um :attribute válido',
            'min' => 'O campo :attribute deve ter menos :min caracteres',
            'confirmed' => 'As senhas não coincidem'
        ],[
            'name' => 'nome',
            'email' => 'e-mail',
            'password' => 'senha'
        ]);
        //Salvando no BD
        $user->save();

        return redirect("/");
    }//fim do store
}