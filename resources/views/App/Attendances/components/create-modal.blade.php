<flux:modal name="create-attendance" class="md:w-150">
    <div class="space-y-6">

        <div>
            <flux:heading size="lg">
                Novo Registro de Frequência
            </flux:heading>

            <flux:text>
                Selecione turma, aluno e registre a presença.
            </flux:text>
        </div>

        <form action="{{ route('attendances.store') }}" method="POST" class="space-y-4">
            @csrf

            <flux:select name="school_class_id" label="Turma" required>
                @foreach ($classes ?? [] as $class)
                    <option value="{{ $class->id }}">
                        {{ $class->name }} - {{ $class->subject?->name }}
                    </option>
                @endforeach
            </flux:select>

            @if (auth()->user()->hasAnyRole(['Administrador', 'Professor']))
                <flux:select name="student_id" label="Aluno" required>
                    @foreach ($students ?? [] as $student)
                        <option value="{{ $student->id }}">
                            {{ $student->user?->name }}
                        </option>
                    @endforeach
                </flux:select>
            @endif

            <flux:input type="date" name="date" label="Data" required />

            <flux:select name="present" label="Presença" required>
                <option value="1">Presente</option>
                <option value="0">Falta</option>
            </flux:select>

            <flux:textarea name="observation" label="Observação (opcional)" />

            <div class="flex justify-end gap-2">

                <flux:modal.close>
                    <flux:button variant="ghost" class="cursor-pointer">
                        Cancelar
                    </flux:button>
                </flux:modal.close>

                <flux:button type="submit" color="orange" class="cursor-pointer">
                    Salvar
                </flux:button>

            </div>

        </form>

    </div>
</flux:modal>
