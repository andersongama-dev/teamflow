@props(['attendance'])

<flux:modal name="edit-attendance-{{ $attendance->id }}" class="md:w-150">

    <div class="space-y-6">

        <div>
            <flux:heading size="lg">
                Editar Frequência
            </flux:heading>

            <flux:text>
                Atualize o registro de presença.
            </flux:text>
        </div>

        <form action="{{ route('attendances.update', $attendance) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <flux:select name="present" label="Presença">
                <option value="1" @selected($attendance->present)>Presente</option>
                <option value="0" @selected(!$attendance->present)>Falta</option>
            </flux:select>

            <flux:input name="observation" label="Observação" value="{{ $attendance->observation }}" />

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
