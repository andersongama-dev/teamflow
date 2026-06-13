@extends('layout')

@section('container')
    <div class="flex justify-center items-center h-dvh">
        <flux:card class="space-y-6 w-96">
            <div>
                <flux:heading size="lg">Entrar na sua conta</flux:heading>
                <flux:text class="mt-2">Bem-vindo de volta!</flux:text>
            </div>

            <form action="{{ url('sign-in') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <flux:input label="E-mail" type="email" name="email" value="{{ old('email') }}"
                        placeholder="Seu endereço de e-mail" />

                    <flux:field>
                        <div class="mb-3 flex justify-between">
                            <flux:label>Senha</flux:label>

                            <flux:link href="#" variant="subtle" class="text-sm">
                                Esqueceu a senha?
                            </flux:link>
                        </div>

                        <flux:input type="password" name="password" placeholder="Sua senha">
                            <x-slot name="iconTrailing">
                                <flux:button size="sm" variant="subtle" icon="eye" class="-mr-1" type="button" />
                            </x-slot>
                        </flux:input>

                        <flux:error name="password" />
                    </flux:field>
                </div>

                <div class="space-y-2 mt-6">
                    <flux:button type="submit" variant="primary" color="orange" class="w-full cursor-pointer">
                        Entrar
                    </flux:button>

                    <a href="/sign-up" class="block">
                        <flux:button type="button" variant="ghost" class="w-full cursor-pointer">
                            Criar uma conta
                        </flux:button>
                    </a>
                </div>
            </form>
        </flux:card>
    </div>
@endsection
