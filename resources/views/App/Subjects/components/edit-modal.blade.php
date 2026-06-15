@props(['subject'])

<flux:modal name="edit-subject-{{ $subject->id }}" class="md:w-150">

    <div class="space-y-6">

        <div>
            <flux:heading size="lg">
                Editar Matéria
            </flux:heading>

            <flux:text>
                Atualize os dados da matéria.
            </flux:text>
        </div>

        <form action="{{ route('subjects.update', $subject) }}" method="POST" class="space-y-4">

            @csrf
            @method('PUT')

            <flux:input name="name" label="Nome da Matéria" value="{{ $subject->name }}" />

            <flux:input name="code" label="Código" value="{{ $subject->code }}" />

            <flux:input type="number" name="workload_hours" label="Carga Horária"
                value="{{ $subject->workload_hours }}" />

            <flux:textarea name="description" label="Descrição">{{ $subject->description }}
            </flux:textarea>

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
