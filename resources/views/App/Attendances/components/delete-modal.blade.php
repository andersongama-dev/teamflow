@props(['attendance'])

<flux:modal name="delete-attendance-{{ $attendance->id }}" class="md:w-[500px]">

    <div class="space-y-6">

        <div>
            <flux:heading size="lg">
                Confirmar exclusão
            </flux:heading>

            <flux:text class="mt-2">
                Tem certeza que deseja excluir o registro de frequência de
                <strong>{{ $attendance->student?->user?->name }}</strong>?
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

            <form action="{{ route('attendances.destroy', $attendance) }}" method="POST">
                @csrf
                @method('DELETE')

                <flux:button type="submit" variant="danger" class="cursor-pointer">
                    Sim, excluir
                </flux:button>
            </form>

        </div>

    </div>

</flux:modal>
