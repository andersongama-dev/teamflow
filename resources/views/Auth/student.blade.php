@extends('layout')

@section('container')
    <div class="flex justify-center items-center h-dvh">
        <flux:card class="space-y-6 w-96">

            <div>
                <flux:heading size="lg">Perfil do estudante</flux:heading>
                <flux:text class="mt-2">
                    Complete suas informações acadêmicas.
                </flux:text>
            </div>

            <form action="{{ route('students.profile.store') }}" method="POST">
                @csrf

                <div class="space-y-6">

                    <flux:input label="Número de matrícula" type="text" name="registration_number"
                        value="{{ old('registration_number') }}" placeholder="Ex: 202600123" />
                    <flux:error name="registration_number" />

                    <flux:input label="Data de nascimento" type="date" name="birth_date"
                        value="{{ old('birth_date') }}" />
                    <flux:error name="birth_date" />

                    <flux:input label="Telefone" type="text" name="phone" value="{{ old('phone') }}"
                        placeholder="(11) 99999-9999" />
                    <flux:error name="phone" />

                    <flux:field>
                        <flux:label>Endereço</flux:label>

                        <textarea name="address" class="w-full rounded-md border border-zinc-300 p-2 text-sm"
                            placeholder="Rua, número, bairro, cidade...">{{ old('address') }}</textarea>

                        <flux:error name="address" />
                    </flux:field>

                    <flux:input label="Data de matrícula" type="date" name="enrollment_date"
                        value="{{ old('enrollment_date', now()->toDateString()) }}" />
                    <flux:error name="enrollment_date" />

                    <flux:field>
                        <flux:label>Status</flux:label>

                        <select name="status" class="w-full rounded-md border border-zinc-300 p-2 text-sm">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                Ativo
                            </option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                Inativo
                            </option>
                            <option value="transferred" {{ old('status') == 'transferred' ? 'selected' : '' }}>
                                Transferido
                            </option>
                            <option value="graduated" {{ old('status') == 'graduated' ? 'selected' : '' }}>
                                Formado
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
