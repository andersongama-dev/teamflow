@extends('layoutApp')

@section('container')
    <div>

        <div class="flex items-center justify-between mb-8">

            <div>
                <h1 class="text-2xl font-semibold">
                    Frequência
                </h1>

                <p class="text-sm text-zinc-500">
                    {{ $attendances->total() }} registros de frequência
                </p>
            </div>

            @if (auth()->user()->hasAnyRole(['Professor']))
                <flux:modal.trigger name="create-attendance">
                    <flux:button color="orange" class="cursor-pointer">
                        Novo Registro
                    </flux:button>
                </flux:modal.trigger>
            @endif

        </div>

        <flux:card class="overflow-hidden">

            @if ($attendances->count())
                <div class="flex flex-col divide-y divide-zinc-200 dark:divide-zinc-800">

                    @foreach ($attendances as $attendance)
                        <div
                            class="p-4 md:p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4 hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">

                            {{-- LEFT: main info --}}
                            <div class="flex flex-col gap-2 min-w-0">

                                <div class="flex items-center gap-3 flex-wrap">

                                    <p class="font-semibold text-zinc-900 dark:text-zinc-100 truncate">
                                        {{ $attendance->student?->user?->name }}
                                    </p>

                                    <flux:badge size="sm">
                                        {{ $attendance->present ? 'Presente' : 'Falta' }}
                                    </flux:badge>

                                </div>

                                <div class="flex flex-wrap gap-x-6 gap-y-1 text-sm text-zinc-500">

                                    <span>
                                        <span class="text-zinc-400">Turma:</span>
                                        {{ $attendance->schoolClass?->name }}
                                    </span>

                                    <span>
                                        <span class="text-zinc-400">Disciplina:</span>
                                        {{ $attendance->schoolClass?->subject?->name }}
                                    </span>

                                    <span>
                                        <span class="text-zinc-400">Professor:</span>
                                        {{ $attendance->schoolClass?->teacher?->user?->name ?? 'Sistema' }}
                                    </span>

                                </div>

                            </div>

                            <div class="flex flex-col justify-between md:justify-end gap-4 md:gap-6">

                                <div class="text-sm text-zinc-500 whitespace-nowrap">
                                    {{ $attendance->date }}
                                </div>

                                @if (auth()->user()->hasAnyRole(['Administrador', 'Professor']))
                                    <div class="flex gap-2">

                                        <flux:modal.trigger name="edit-attendance-{{ $attendance->id }}">
                                            <flux:button size="sm" variant="filled" class="cursor-pointer">
                                                Editar
                                            </flux:button>
                                        </flux:modal.trigger>

                                        <flux:modal.trigger name="delete-attendance-{{ $attendance->id }}">
                                            <flux:button size="sm" variant="danger" class="cursor-pointer">
                                                Excluir
                                            </flux:button>
                                        </flux:modal.trigger>

                                    </div>
                                @endif

                            </div>

                        </div>

                        @include('App.Attendances.components.edit-modal', [
                            'attendance' => $attendance,
                        ])

                        @include('App.Attendances.components.delete-modal', [
                            'attendance' => $attendance,
                        ])
                    @endforeach

                </div>
            @else
                <div class="py-20 text-center">
                    <flux:heading size="lg">Nenhum registro encontrado</flux:heading>
                    <flux:text class="mt-2">Registre a primeira frequência.</flux:text>
                </div>
            @endif

        </flux:card>

        <div class="mt-6">
            {{ $attendances->links() }}
        </div>

    </div>

    @include('App.Attendances.components.create-modal')
@endsection
