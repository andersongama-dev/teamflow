@extends('layout')

@section('container')
    <div class="flex justify-center items-center h-dvh">
        <flux:card class="space-y-6 w-96">
            <div>
                <flux:heading size="lg">Criar conta</flux:heading>
                <flux:text class="mt-2">
                    Preencha os dados para se cadastrar.
                </flux:text>
            </div>

            <form action="{{ url('sign-up') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <flux:input label="Nome" type="text" name="name" value="{{ old('name') }}"
                        placeholder="Seu nome" />

                    <flux:error name="name" />

                    <flux:input label="E-mail" type="email" name="email" value="{{ old('email') }}"
                        placeholder="Seu endereço de e-mail" />


                    <flux:field>
                        <flux:label>Senha</flux:label>

                        <flux:input type="password" name="password" placeholder="Sua senha">
                            <x-slot name="iconTrailing">
                                <flux:button size="sm" variant="subtle" icon="eye" class="-mr-1" type="button" />
                            </x-slot>
                        </flux:input>

                        <flux:error name="password" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Confirmar senha</flux:label>

                        <flux:input type="password" name="password_confirmation" placeholder="Confirme sua senha">
                            <x-slot name="iconTrailing">
                                <flux:button size="sm" variant="subtle" icon="eye" class="-mr-1" type="button" />
                            </x-slot>
                        </flux:input>
                    </flux:field>
                </div>

                <div class="space-y-2 mt-6">
                    <flux:button type="submit" variant="primary" color="orange" class="w-full cursor-pointer">
                        Registrar-se
                    </flux:button>

                    <a href="/sign-in" class="block">
                        <flux:button type="button" variant="ghost" class="w-full cursor-pointer">
                            Já tenho uma conta
                        </flux:button>
                    </a>
                </div>
            </form>
        </flux:card>
    </div>
@endsection
