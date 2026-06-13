@extends('layout')

@section('container')
    <div class="flex justify-center items-center h-dvh">
        <flux:card class="space-y-6 w-96">

            <div>
                <flux:heading size="lg">Perfil do professor</flux:heading>
                <flux:text class="mt-2">
                    Complete suas informações profissionais.
                </flux:text>
            </div>

            <form action="{{ route('teachers-complete-profile.store') }}" method="POST">
                @csrf

                <div class="space-y-6">

                    <flux:input label="Especialização" type="text" name="specialization" value="{{ old('specialization') }}"
                        placeholder="Ex: Matemática, História..." />
                    <flux:error name="specialization" />

                    <flux:input label="Telefone" type="text" name="phone" value="{{ old('phone') }}"
                        placeholder="(11) 99999-9999" />
                    <flux:error name="phone" />

                    <flux:input label="Data de contratação" type="date" name="hire_date"
                        value="{{ old('hire_date', now()->toDateString()) }}" />
                    <flux:error name="hire_date" />

                    <flux:field>
                        <flux:label>Status</flux:label>

                        <select name="status" class="w-full rounded-md border border-zinc-300 p-2 text-sm">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                Ativo
                            </option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                Inativo
                            </option>
                            <option value="on_leave" {{ old('status') == 'on_leave' ? 'selected' : '' }}>
                                Licença
                            </option>
                        </select>

                        <flux:error name="status" />
                    </flux:field>

                </div>

                <div class="space-y-2 mt-6">
                    <flux:button type="submit" variant="primary" color="orange" class="w-full cursor-pointer">
                        Salvar perfil
                    </flux:button>
                </div>

            </form>
        </flux:card>
    </div>
@endsection
