<flux:modal name="create-enrollment" class="md:w-[600px]">
    <div class="space-y-6">

        <div>
            <flux:heading size="lg">
                Nova Matrícula
            </flux:heading>

            <flux:text>
                Selecione a turma para realizar a matrícula.
            </flux:text>
        </div>

        <form action="{{ route('enrollments.store') }}" method="POST" class="space-y-4">
            @csrf

            <flux:select name="school_class_id" label="Turma">
                @foreach ($classes ?? [] as $class)
                    <option value="{{ $class->id }}">
                        {{ $class->name }} - {{ $class->subject?->name }}
                    </option>
                @endforeach
            </flux:select>

            @if (auth()->user()->hasAnyRole(['Administrador', 'Professor']))
                <flux:select name="student_id" label="Aluno">
                    @foreach ($students ?? [] as $student)
                        <option value="{{ $student->id }}">
                            {{ $student->user?->name }}
                        </option>
                    @endforeach
                </flux:select>
            @endif

            <div class="flex justify-end gap-2">

                <flux:modal.close>
                    <flux:button variant="ghost" class="cursor-pointer">
                        Cancelar
                    </flux:button>
                </flux:modal.close>

                <flux:button type="submit" color="orange" class="cursor-pointer">
                    Matricular
                </flux:button>

            </div>

        </form>

    </div>
</flux:modal>
