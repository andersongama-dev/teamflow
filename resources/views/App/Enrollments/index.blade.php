@extends('layoutApp')

@section('container')
    <div>

        <div class="flex items-center justify-between mb-8">

            <div>
                <h1 class="text-2xl font-semibold">
                    Matrículas
                </h1>

                <p class="text-sm text-zinc-500">
                    {{ $enrollments->total() }} matrículas registradas
                </p>
            </div>

            @if (auth()->user()->hasAnyRole(['Professor', 'Aluno']))
                <flux:modal.trigger name="create-enrollment">
                    <flux:button color="orange" class="cursor-pointer">
                        Nova Matrícula
                    </flux:button>
                </flux:modal.trigger>
            @endif

        </div>

        <flux:card class="overflow-hidden">

            @if ($enrollments->count())
                <div class="flex flex-col divide-y divide-zinc-200 dark:divide-zinc-800">

                    @foreach ($enrollments as $enrollment)
                        <div
                            class="p-4 md:p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4 hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">

                            {{-- LEFT --}}
                            <div class="flex flex-col gap-2 min-w-0">

                                <div class="flex items-center gap-3 flex-wrap">

                                    <p class="font-semibold text-zinc-900 dark:text-zinc-100 truncate">
                                        {{ $enrollment->student?->user?->name }}
                                    </p>

                                    <flux:badge size="sm">
                                        {{ ucfirst($enrollment->status) }}
                                    </flux:badge>

                                </div>

                                <div class="flex flex-wrap gap-x-6 gap-y-1 text-sm text-zinc-500">

                                    <span>
                                        <span class="text-zinc-400">Turma:</span>
                                        {{ $enrollment->schoolClass?->name }}
                                    </span>

                                    <span>
                                        <span class="text-zinc-400">Disciplina:</span>
                                        {{ $enrollment->schoolClass?->subject?->name }}
                                    </span>

                                    <span>
                                        <span class="text-zinc-400">Professor:</span>
                                        {{ $enrollment->schoolClass?->teacher?->user?->name ?? 'Sistema' }}
                                    </span>

                                </div>

                            </div>

                            {{-- RIGHT --}}
                            <div class="flex flex-col md:items-end justify-between gap-4 md:gap-6">

                                <div class="text-sm text-zinc-500 whitespace-nowrap">
                                    {{ $enrollment->enrollment_date }}
                                </div>

                                <div class="flex gap-2">

                                    @php($user = auth()->user())

                                    @if (
                                        $user->hasRole('Administrador') ||
                                            ($user->hasRole('Professor') && $enrollment->schoolClass->teacher_id === $user->teacher?->id))
                                        <flux:modal.trigger name="edit-enrollment-{{ $enrollment->id }}">
                                            <flux:button size="sm" variant="filled" class="cursor-pointer">
                                                Editar
                                            </flux:button>
                                        </flux:modal.trigger>

                                        <flux:modal.trigger name="delete-enrollment-{{ $enrollment->id }}">
                                            <flux:button size="sm" variant="danger" class="cursor-pointer">
                                                Excluir
                                            </flux:button>
                                        </flux:modal.trigger>
                                    @endif

                                    @if ($user->hasRole('Aluno') && $enrollment->student_id === $user->student?->id)
                                        <flux:modal.trigger name="delete-enrollment-{{ $enrollment->id }}">
                                            <flux:button size="sm" variant="danger" class="cursor-pointer">
                                                Cancelar matrícula
                                            </flux:button>
                                        </flux:modal.trigger>
                                    @endif

                                </div>

                            </div>

                        </div>

                        @include('App.Enrollments.components.edit-modal', [
                            'enrollment' => $enrollment,
                        ])

                        @include('App.Enrollments.components.delete-modal', [
                            'enrollment' => $enrollment,
                        ])
                    @endforeach

                </div>
            @else
                <div class="py-20 text-center">
                    <flux:heading size="lg">
                        Nenhuma matrícula encontrada
                    </flux:heading>

                    <flux:text class="mt-2">
                        Crie a primeira matrícula para começar.
                    </flux:text>

                    <flux:modal.trigger name="create-enrollment">
                        <flux:button color="orange" class="mt-6 cursor-pointer">
                            Criar primeira matrícula
                        </flux:button>
                    </flux:modal.trigger>
                </div>
            @endif

        </flux:card>

        @if ($enrollments->count())
            <div class="mt-6">
                {{ $enrollments->links() }}
            </div>
        @endif

    </div>

    @include('App.Enrollments.components.create-modal')
@endsection
