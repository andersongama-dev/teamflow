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

            @if (auth()->user()->hasAnyRole(['Professor']))
                <flux:modal.trigger name="create-grade">
                    <flux:button color="orange" class="cursor-pointer">
                        Lançar Nota
                    </flux:button>
                </flux:modal.trigger>
            @endif

        </div>

        <flux:card class="overflow-hidden">

            @if ($grades->count())
                <div class="flex flex-col divide-y divide-zinc-200 dark:divide-zinc-800">

                    @foreach ($grades as $grade)
                        <div
                            class="p-4 md:p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4 hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">

                            {{-- LEFT --}}
                            <div class="flex flex-col gap-2 min-w-0">

                                <div class="flex items-center gap-3 flex-wrap">

                                    <p class="font-semibold text-zinc-900 dark:text-zinc-100 truncate">
                                        {{ $grade->student?->user?->name }}
                                    </p>

                                    <flux:badge size="sm">
                                        {{ $grade->grade }}
                                    </flux:badge>

                                </div>

                                <div class="flex flex-wrap gap-x-6 gap-y-1 text-sm text-zinc-500">

                                    <span>
                                        <span class="text-zinc-400">Turma:</span>
                                        {{ $grade->schoolClass?->name }}
                                    </span>

                                    <span>
                                        <span class="text-zinc-400">Disciplina:</span>
                                        {{ $grade->schoolClass?->subject?->name }}
                                    </span>

                                    <span>
                                        <span class="text-zinc-400">Professor:</span>
                                        {{ $grade->teacher?->user?->name ?? 'Sistema' }}
                                    </span>

                                </div>

                                <div class="flex flex-wrap gap-x-6 gap-y-1 text-sm text-zinc-500">

                                    <span>
                                        <span class="text-zinc-400">Avaliação:</span>
                                        {{ $grade->assessment_name }}
                                    </span>

                                </div>

                            </div>

                            {{-- RIGHT --}}
                            <div class="flex flex-col md:items-end justify-between gap-4 md:gap-6">

                                <div class="text-sm text-zinc-500 whitespace-nowrap">
                                    {{ $grade->assessment_date }}
                                </div>

                                <div class="flex gap-2">

                                    @php($user = auth()->user())

                                    @if ($user->hasRole('Administrador') || ($user->hasRole('Professor') && $grade->teacher_id === $user->teacher?->id))
                                        <flux:modal.trigger name="edit-grade-{{ $grade->id }}">
                                            <flux:button size="sm" variant="filled" class="cursor-pointer">
                                                Editar
                                            </flux:button>
                                        </flux:modal.trigger>

                                        <flux:modal.trigger name="delete-grade-{{ $grade->id }}">
                                            <flux:button size="sm" variant="danger" class="cursor-pointer">
                                                Excluir
                                            </flux:button>
                                        </flux:modal.trigger>
                                    @endif

                                </div>

                            </div>

                        </div>

                        @include('App.Grades.components.edit-modal', [
                            'grade' => $grade,
                        ])

                        @include('App.Grades.components.delete-modal', [
                            'grade' => $grade,
                        ])
                    @endforeach

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
