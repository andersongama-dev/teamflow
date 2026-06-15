@extends('layoutApp')

@section('container')
    <div>

        <div class="flex items-center justify-between mb-8">

            <div>
                <h1 class="text-2xl font-semibold">
                    Turmas
                </h1>

                <p class="text-sm text-zinc-500">
                    {{ $classes->total() }} turmas cadastradas
                </p>
            </div>

            @if (auth()->user()->hasRole('Professor'))
                <flux:modal.trigger name="create-class">
                    <flux:button color="orange" class="cursor-pointer">
                        Nova Turma
                    </flux:button>
                </flux:modal.trigger>
            @endif

        </div>

        <flux:card class="overflow-hidden">

            @if ($classes->count())
                <div class="flex flex-col divide-y divide-zinc-200 dark:divide-zinc-800">

                    @foreach ($classes as $class)
                        <div
                            class="p-4 md:p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4 hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">

                            {{-- LEFT --}}
                            <div class="flex flex-col gap-2 min-w-0">

                                <div class="flex items-center gap-3 flex-wrap">

                                    <p class="font-semibold text-zinc-900 dark:text-zinc-100 truncate">
                                        {{ $class->name }}
                                    </p>

                                    <flux:badge size="sm">
                                        {{ $class->subject?->name }}
                                    </flux:badge>

                                </div>

                                <div class="flex flex-wrap gap-x-6 gap-y-1 text-sm text-zinc-500">

                                    <span>
                                        <span class="text-zinc-400">Professor:</span>
                                        {{ $class->teacher?->user?->name ?? 'Sistema' }}
                                    </span>

                                    <span>
                                        <span class="text-zinc-400">Ano/Semestre:</span>
                                        {{ $class->academic_year }} / {{ $class->semester }}
                                    </span>

                                    <span>
                                        <span class="text-zinc-400">Sala:</span>
                                        {{ $class->room ?? '-' }}
                                    </span>

                                </div>

                            </div>

                            {{-- RIGHT --}}
                            <div class="flex flex-col md:items-end justify-between gap-4 md:gap-6">

                                <div class="text-sm text-zinc-500 whitespace-nowrap">
                                    {{ $class->subject?->name }}
                                </div>

                                <div class="flex gap-2">

                                    @php($user = auth()->user())

                                    @if ($user->hasRole('Administrador') || ($user->hasRole('Professor') && $class->teacher_id === $user->teacher?->id))
                                        <flux:modal.trigger name="edit-class-{{ $class->id }}">
                                            <flux:button size="sm" variant="filled" class="cursor-pointer">
                                                Editar
                                            </flux:button>
                                        </flux:modal.trigger>

                                        <flux:modal.trigger name="delete-class-{{ $class->id }}">
                                            <flux:button size="sm" variant="danger" class="cursor-pointer">
                                                Excluir
                                            </flux:button>
                                        </flux:modal.trigger>
                                    @endif

                                </div>

                            </div>

                        </div>

                        @include('App.SchoolClasses.components.edit-modal', [
                            'class' => $class,
                        ])

                        @include('App.SchoolClasses.components.delete-modal', [
                            'class' => $class,
                        ])
                    @endforeach

                </div>
            @else
                <div class="py-20 text-center">
                    <flux:heading size="lg">
                        Nenhuma turma encontrada
                    </flux:heading>

                    <flux:text class="mt-2">
                        Crie sua primeira turma para começar.
                    </flux:text>
                </div>
            @endif

        </flux:card>

        @if ($classes->count())
            <div class="mt-6">
                {{ $classes->links() }}
            </div>
        @endif

    </div>

    @include('App.SchoolClasses.components.create-modal')
@endsection
