@props(['subject'])

<flux:modal name="delete-subject-{{ $subject->id }}" class="md:w-150">

    <div class="space-y-6">

        <div>
            <flux:heading size="lg">
                Confirmar exclusão
            </flux:heading>

            <flux:text class="mt-2">
                Tem certeza que deseja excluir a matéria
                <strong>{{ $subject->name }}</strong>?
            </flux:text>

            <flux:text class="text-red-500 mt-2">
                Esta ação não poderá ser desfeita.
            </flux:text>
        </div>

        <div class="flex justify-end gap-2">

            <flux:modal.close>
                <flux:button variant="ghost" class="cursor-pointer">
                    Cancelar
                </flux:button>
            </flux:modal.close>

            <form action="{{ route('subjects.destroy', $subject) }}" method="POST">
                @csrf
                @method('DELETE')

                <flux:button type="submit" variant="danger" class="cursor-pointer">
                    Sim, excluir
                </flux:button>
            </form>

        </div>

    </div>

</flux:modal>
