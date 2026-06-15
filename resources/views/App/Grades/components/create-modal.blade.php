<flux:modal name="create-grade" class="md:w-[600px]">
    <div class="space-y-6">

        <div>
            <flux:heading size="lg">
                Nova Nota
            </flux:heading>

            <flux:text>
                Registre uma avaliação para um aluno.
            </flux:text>
        </div>

        <form action="{{ route('grades.store') }}" method="POST" class="space-y-4">
            @csrf

            <flux:select name="school_class_id" label="Turma">
                @foreach ($classes ?? [] as $class)
                    <option value="{{ $class->id }}">
                        {{ $class->name }} - {{ $class->subject?->name }}
                    </option>
                @endforeach
            </flux:select>

            <flux:select name="student_id" label="Aluno">
                @foreach ($students ?? [] as $student)
                    <option value="{{ $student->id }}">
                        {{ $student->user?->name }}
                    </option>
                @endforeach
            </flux:select>

            <flux:input name="assessment_name" label="Avaliação" />

            <flux:input type="number" step="0.01" name="grade" label="Nota" />

            <flux:input type="date" name="assessment_date" label="Data da avaliação" />

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
