@extends('layoutApp')

@section('container')
    <div>

        <div class="flex items-center justify-between mb-8">

            <div>
                <h1 class="text-2xl font-semibold">
                    Notas
                </h1>

                <p class="text-sm text-zinc-500">
                    {{ $grades->total() }} registros de notas
                </p>
            </div>

            @if (auth()->user()->hasAnyRole(['Administrador', 'Professor']))
                <flux:modal.trigger name="create-grade">
                    <flux:button color="orange" class="cursor-pointer">
                        Lançar Nota
                    </flux:button>
                </flux:modal.trigger>
            @endif

        </div>

        <flux:card class="overflow-hidden">

            @if ($grades->count())
                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead>
                            <tr class="border-b">

                                <th class="px-6 py-4 text-left text-sm font-medium">
                                    Aluno
                                </th>

                                <th class="px-6 py-4 text-left text-sm font-medium">
                                    Turma
                                </th>

                                <th class="px-6 py-4 text-left text-sm font-medium">
                                    Disciplina
                                </th>

                                <th class="px-6 py-4 text-left text-sm font-medium">
                                    Professor
                                </th>

                                <th class="px-6 py-4 text-left text-sm font-medium">
                                    Avaliação
                                </th>

                                <th class="px-6 py-4 text-left text-sm font-medium">
                                    Nota
                                </th>

                                <th class="px-6 py-4 text-left text-sm font-medium">
                                    Data
                                </th>

                                <th class="px-6 py-4 text-right text-sm font-medium">
                                    Ações
                                </th>

                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($grades as $grade)
                                <tr class="border-b hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors">

                                    <td class="px-6 py-5">
                                        {{ $grade->student?->user?->name }}
                                    </td>

                                    <td class="px-6 py-5">
                                        <flux:badge size="sm">
                                            {{ $grade->schoolClass?->name }}
                                        </flux:badge>
                                    </td>

                                    <td class="px-6 py-5">
                                        {{ $grade->schoolClass?->subject?->name }}
                                    </td>

                                    <td class="px-6 py-5">
                                        {{ $grade->teacher?->user?->name ?? 'Sistema' }}
                                    </td>

                                    <td class="px-6 py-5">
                                        {{ $grade->assessment_name }}
                                    </td>

                                    <td class="px-6 py-5">
                                        <flux:badge size="sm">
                                            {{ $grade->grade }}
                                        </flux:badge>
                                    </td>

                                    <td class="px-6 py-5">
                                        <flux:badge size="sm">
                                            {{ $grade->assessment_date }}
                                        </flux:badge>
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="flex justify-end gap-2">

                                            @php($user = auth()->user())

                                            @if ($user->hasRole('Administrador') || ($user->hasRole('Professor') && $grade->teacher_id === $user->teacher?->id))
                                                <flux:modal.trigger name="edit-grade-{{ $grade->id }}">
                                                    <flux:button size="sm" variant="filled">
                                                        Editar
                                                    </flux:button>
                                                </flux:modal.trigger>

                                                <flux:modal.trigger name="delete-grade-{{ $grade->id }}">
                                                    <flux:button size="sm" variant="danger">
                                                        Excluir
                                                    </flux:button>
                                                </flux:modal.trigger>
                                            @endif

                                        </div>
                                    </td>

                                </tr>

                                @include('App.Grades.components.edit-modal', [
                                    'grade' => $grade,
                                ])

                                @include('App.Grades.components.delete-modal', [
                                    'grade' => $grade,
                                ])
                            @endforeach

                        </tbody>

                    </table>

                </div>
            @else
                <div class="py-20 text-center">
                    <flux:heading size="lg">
                        Nenhuma nota encontrada
                    </flux:heading>

                    <flux:text class="mt-2">
                        Lançe a primeira nota para começar.
                    </flux:text>

                    <flux:modal.trigger name="create-grade">
                        <flux:button color="orange" class="mt-6 cursor-pointer">
                            Lançar primeira nota
                        </flux:button>
                    </flux:modal.trigger>
                </div>
            @endif

        </flux:card>

        @if ($grades->count())
            <div class="mt-6">
                {{ $grades->links() }}
            </div>
        @endif

    </div>

    @include('App.Grades.components.create-modal')
@endsection
