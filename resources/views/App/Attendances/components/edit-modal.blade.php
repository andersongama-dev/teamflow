@props(['grade'])

<flux:modal name="edit-grade-{{ $grade->id }}" class="md:w-[600px]">

    <div class="space-y-6">

        <div>
            <flux:heading size="lg">
                Editar Nota
            </flux:heading>

            <flux:text>
                Atualize os dados da avaliação.
            </flux:text>
        </div>

        <form action="{{ route('grades.update', $grade) }}" method="POST" class="space-y-4">

            @csrf
            @method('PUT')

            <flux:input name="assessment_name" label="Avaliação" value="{{ $grade->assessment_name }}" />

            <flux:input type="number" step="0.01" name="grade" label="Nota" value="{{ $grade->grade }}" />

            <flux:input type="date" name="assessment_date" label="Data da avaliação"
                value="{{ $grade->assessment_date }}" />

            <flux:select name="school_class_id" label="Turma">
                @foreach ($classes ?? [] as $class)
                    <option value="{{ $class->id }}" @selected($class->id == $grade->school_class_id)>
                        {{ $class->name }} - {{ $class->subject?->name }}
                    </option>
                @endforeach
            </flux:select>

            <flux:select name="student_id" label="Aluno">
                @foreach ($students ?? [] as $student)
                    <option value="{{ $student->id }}" @selected($student->id == $grade->student_id)>
                        {{ $student->user?->name }}
                    </option>
                @endforeach
            </flux:select>

            <div class="flex justify-end gap-2">

                <flux:modal.close>
                    <flux:button variant="ghost" class="cursor-pointer">
                        Cancelar
                    </flux:button>
                </flux:modal.close>

                <flux:button type="submit" color="orange" class="cursor-pointer">
                    Atualizar
                </flux:button>

            </div>

        </form>

    </div>

</flux:modal>
