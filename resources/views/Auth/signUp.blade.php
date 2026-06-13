@extends('layout')

@section('container')
    <div class="flex justify-center items-center h-dvh">
        <form action="{{ url('sign-up') }}" method="POST" class="w-96">
            @csrf

            <div class="flex flex-col gap-6">
                <flux:input type="text" name="name" label="Nome" value="{{ old('name') }}" />
                <flux:input type="email" name="email" label="E-mail" value="{{ old('email') }}" />
                <flux:input type="password" name="password" label="Senha">
                    <x-slot name="iconTrailing">
                        <flux:button size="sm" variant="subtle" icon="eye" class="-mr-1" />
                    </x-slot>
                </flux:input>
                <flux:input type="password" name="password_confirmation" label="Confirmar senha">
                    <x-slot name="iconTrailing">
                        <flux:button size="sm" variant="subtle" icon="eye" class="-mr-1" />
                    </x-slot>
                </flux:input>
            </div>
            <flux:button variant="primary" color="orange" class="w-full mt-8 cursor-pointer" type="submit">Registrar-se
            </flux:button>
        </form>
    </div>
@endsection
