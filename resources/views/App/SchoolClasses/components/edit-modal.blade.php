@props(['class'])

<flux:modal name="edit-class-{{ $class->id }}" class="md:w-150">

    <div class="space-y-6">

        <div>
            <flux:heading size="lg">
                Editar Turma
            </flux:heading>

            <flux:text>
                Atualize os dados da turma.
            </flux:text>
        </div>

        <form action="{{ route('classes.update', $class) }}" method="POST" class="space-y-4">

            @csrf
            @method('PUT')

            <div class="space-y-2">

                <label class="text-sm font-medium">Disciplina</label>

                <select name="subject_id" class="w-full border rounded-md px-3 py-2">

                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}" @selected($subject->id == $class->subject_id)>
                            {{ $subject->name }}
                        </option>
                    @endforeach

                </select>

            </div>

            <flux:input name="name" label="Nome da Turma" value="{{ $class->name }}" />

            <flux:input name="academic_year" label="Ano Letivo" value="{{ $class->academic_year }}" />

            <flux:input name="semester" label="Semestre" value="{{ $class->semester }}" />

            <flux:input name="room" label="Sala (opcional)" value="{{ $class->room }}" />

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
