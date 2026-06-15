@extends('layoutApp')

@section('container')
    <div>

        <div class="flex items-center justify-between mb-8">

            <div>
                <h1 class="text-2xl font-semibold">
                    Matérias
                </h1>

                <p class="text-sm text-zinc-500">
                    {{ $subjects->total() }} matérias cadastradas
                </p>
            </div>

            @if (auth()->user()->hasRole('Professor'))
                <flux:modal.trigger name="create-subject">
                    <flux:button color="orange" class="cursor-pointer">
                        Nova Matéria
                    </flux:button>
                </flux:modal.trigger>
            @endif

        </div>

        <flux:card class="overflow-hidden">

            @if ($subjects->count())
                <div class="flex flex-col divide-y divide-zinc-200 dark:divide-zinc-800">

                    @foreach ($subjects as $subject)
                        <div
                            class="p-4 md:p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4 hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition">

                            {{-- LEFT --}}
                            <div class="flex flex-col gap-2 min-w-0">

                                <div class="flex items-center gap-3 flex-wrap">

                                    <flux:badge size="sm">
                                        {{ $subject->code }}
                                    </flux:badge>

                                    <p class="font-semibold text-zinc-900 dark:text-zinc-100 truncate">
                                        {{ $subject->name }}
                                    </p>

                                    <flux:badge size="sm">
                                        {{ $subject->workload_hours }}h
                                    </flux:badge>

                                </div>

                                @if ($subject->description)
                                    <p class="text-sm text-zinc-500">
                                        {{ \Illuminate\Support\Str::limit($subject->description, 90) }}
                                    </p>
                                @endif

                                <div class="text-sm text-zinc-500">
                                    <span class="text-zinc-400">Professor:</span>
                                    {{ $subject->teacher?->user?->name ?? 'Sistema' }}
                                </div>

                            </div>

                            {{-- RIGHT --}}
                            <div class="flex flex-col md:items-end justify-between gap-4 md:gap-6">

                                <div class="text-sm text-zinc-500 whitespace-nowrap">
                                    {{ $subject->workload_hours }}h
                                </div>

                                <div class="flex gap-2">

                                    @php($user = auth()->user())

                                    @if ($user->hasRole('Administrador') || ($user->hasRole('Professor') && $subject->teacher_id === $user->teacher?->id))
                                        <flux:modal.trigger name="edit-subject-{{ $subject->id }}">
                                            <flux:button size="sm" variant="filled" class="cursor-pointer">
                                                Editar
                                            </flux:button>
                                        </flux:modal.trigger>

                                        <flux:modal.trigger name="delete-subject-{{ $subject->id }}">
                                            <flux:button size="sm" variant="danger" class="cursor-pointer">
                                                Excluir
                                            </flux:button>
                                        </flux:modal.trigger>
                                    @endif

                                </div>

                            </div>

                        </div>

                        @include('App.Subjects.components.edit-modal', [
                            'subject' => $subject,
                        ])

                        @include('App.Subjects.components.delete-modal', [
                            'subject' => $subject,
                        ])
                    @endforeach

                </div>
            @else
                <div class="py-20 text-center">
                    <flux:heading size="lg">
                        Nenhuma matéria encontrada
                    </flux:heading>

                    <flux:text class="mt-2">
                        Crie sua primeira matéria para começar.
                    </flux:text>

                    <flux:modal.trigger name="create-subject">
                        <flux:button color="orange" class="mt-6 cursor-pointer">
                            Criar primeira matéria
                        </flux:button>
                    </flux:modal.trigger>
                </div>
            @endif

        </flux:card>

        @if ($subjects->count())
            <div class="mt-6">
                {{ $subjects->links() }}
            </div>
        @endif

    </div>

    @include('App.Subjects.components.create-modal')
@endsection
