<flux:modal name="create-class" class="md:w-150">
    <div class="space-y-6">

        <div>
            <flux:heading size="lg">
                Nova Turma
            </flux:heading>

            <flux:text>
                Preencha os dados da turma.
            </flux:text>
        </div>

        <form action="{{ route('classes.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="space-y-2">

                <label class="text-sm font-medium">Disciplina</label>

                <select name="subject_id" class="w-full border rounded-md px-3 py-2">
                    <option value="">Selecione uma disciplina</option>

                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">
                            {{ $subject->name }}
                        </option>
                    @endforeach

                </select>

            </div>

            <flux:input name="name" label="Nome da Turma" value="{{ old('name') }}" />

            <flux:input name="academic_year" label="Ano Letivo" value="{{ old('academic_year') }}" />

            <flux:input name="semester" label="Semestre" value="{{ old('semester') }}" />

            <flux:input name="room" label="Sala (opcional)" value="{{ old('room') }}" />

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
