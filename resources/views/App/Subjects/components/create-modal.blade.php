<flux:modal name="create-subject" class="md:w-[600px]">
    <div class="space-y-6">

        <div>
            <flux:heading size="lg">
                Nova Matéria
            </flux:heading>

            <flux:text>
                Preencha os dados da matéria.
            </flux:text>
        </div>

        <form action="{{ route('subjects.store') }}" method="POST" class="space-y-4">
            @csrf

            <flux:input name="name" label="Nome da Matéria" value="{{ old('name') }}" />

            <flux:input name="code" label="Código" value="{{ old('code') }}" />

            <flux:input type="number" name="workload_hours" label="Carga Horária"
                value="{{ old('workload_hours') }}" />

            <flux:textarea name="description" label="Descrição">{{ old('description') }}</flux:textarea>

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
