@extends('layout')

@section('container')
    <div class="flex justify-center items-center h-dvh">
        <flux:card class="space-y-6 w-96">

            <form action="{{ route('accountType.store') }}" method="POST">
                @csrf

                <input type="hidden" id="role" name="role" value="Aluno">

                <flux:radio.group label="Tipo de Conta" variant="cards" class="flex-col">
                    <flux:radio value="Aluno" label="Aluno" description="Visualizar notas, frequência e matérias." checked
                        onclick="document.getElementById('role').value='Aluno'" />

                    <flux:radio value="Professor" label="Professor" description="Gerenciar notas, frequência e turmas."
                        onclick="document.getElementById('role').value='Professor'" />
                </flux:radio.group>

                <flux:button type="submit" variant="primary" color="orange" class="w-full mt-6">
                    Continuar
                </flux:button>
            </form>

        </flux:card>
    </div>
@endsection
