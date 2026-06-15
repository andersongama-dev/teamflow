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
                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead>
                            <tr class="border-b">

                                <th class="px-6 py-4 text-left text-sm font-medium">Aluno</th>
                                <th class="px-6 py-4 text-left text-sm font-medium">Turma</th>
                                <th class="px-6 py-4 text-left text-sm font-medium">Disciplina</th>
                                <th class="px-6 py-4 text-left text-sm font-medium">Professor</th>
                                <th class="px-6 py-4 text-left text-sm font-medium">Data</th>
                                <th class="px-6 py-4 text-left text-sm font-medium">Presença</th>
                                <th class="px-6 py-4 text-right text-sm font-medium">Ações</th>

                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($attendances as $attendance)
                                <tr class="border-b hover:bg-zinc-50 dark:hover:bg-zinc-800/40">

                                    <td class="px-6 py-5">
                                        {{ $attendance->student?->user?->name }}
                                    </td>

                                    <td class="px-6 py-5">
                                        {{ $attendance->schoolClass?->name }}
                                    </td>

                                    <td class="px-6 py-5">
                                        {{ $attendance->schoolClass?->subject?->name }}
                                    </td>

                                    <td class="px-6 py-5">
                                        {{ $attendance->schoolClass?->teacher?->user?->name ?? 'Sistema' }}
                                    </td>

                                    <td class="px-6 py-5">
                                        {{ $attendance->date }}
                                    </td>

                                    <td class="px-6 py-5">
                                        <flux:badge size="sm">
                                            {{ $attendance->present ? 'Presente' : 'Falta' }}
                                        </flux:badge>
                                    </td>

                                    <td class="px-6 py-5 text-right">

                                        @if (auth()->user()->hasAnyRole(['Administrador', 'Professor']))
                                            <flux:modal.trigger name="edit-attendance-{{ $attendance->id }}">
                                                <flux:button size="sm" variant="filled" class="cursor-pointer">Editar
                                                </flux:button>
                                            </flux:modal.trigger>

                                            <flux:modal.trigger name="delete-attendance-{{ $attendance->id }}">
                                                <flux:button size="sm" variant="danger" class="cursor-pointer">Excluir
                                                </flux:button>
                                            </flux:modal.trigger>
                                        @endif

                                    </td>

                                </tr>

                                @include('App.Attendances.components.edit-modal', [
                                    'attendance' => $attendance,
                                ])

                                @include('App.Attendances.components.delete-modal', [
                                    'attendance' => $attendance,
                                ])
                            @endforeach

                        </tbody>

                    </table>

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
