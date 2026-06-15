@props(['enrollment'])

<flux:modal name="edit-enrollment-{{ $enrollment->id }}" class="md:w-[600px]">

    <div class="space-y-6">

        <div>
            <flux:heading size="lg">
                Editar Matrícula
            </flux:heading>

            <flux:text>
                Atualize o status da matrícula.
            </flux:text>
        </div>

        <form action="{{ route('enrollments.update', $enrollment) }}" method="POST" class="space-y-4">

            @csrf
            @method('PUT')

            <flux:select name="status" label="Status">

                <option value="active" @selected($enrollment->status === 'active')>
                    Ativa
                </option>

                <option value="cancelled" @selected($enrollment->status === 'cancelled')>
                    Cancelada
                </option>

                <option value="completed" @selected($enrollment->status === 'completed')>
                    Concluída
                </option>

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
