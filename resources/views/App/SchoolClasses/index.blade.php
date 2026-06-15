@extends('layoutApp')

@section('container')
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
            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead>
                        <tr class="border-b">

                            <th class="px-6 py-4 text-left text-sm font-medium">
                                Disciplina
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-medium">
                                Nome da Turma
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-medium">
                                Professor
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-medium">
                                Ano/Semestre
                            </th>

                            <th class="px-6 py-4 text-left text-sm font-medium">
                                Sala
                            </th>

                            <th class="px-6 py-4 text-right text-sm font-medium">
                                Ações
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($classes as $class)
                            <tr class="border-b hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors">

                                <td class="px-6 py-5">
                                    <flux:badge size="sm">
                                        {{ $class->subject?->name }}
                                    </flux:badge>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="font-medium">
                                        {{ $class->name }}
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    {{ $class->teacher?->user?->name ?? 'Sistema' }}
                                </td>

                                <td class="px-6 py-5">
                                    <flux:badge size="sm">
                                        {{ $class->academic_year }} / {{ $class->semester }}
                                    </flux:badge>
                                </td>

                                <td class="px-6 py-5">
                                    <flux:badge size="sm">
                                        {{ $class->room ?? '-' }}
                                    </flux:badge>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex justify-end gap-2">

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
                                </td>

                            </tr>

                            @include('App.SchoolClasses.components.edit-modal', [
                                'class' => $class,
                            ])

                            @include('App.SchoolClasses.components.delete-modal', [
                                'class' => $class,
                            ])
                        @endforeach

                    </tbody>

                </table>

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

    @include('App.SchoolClasses.components.create-modal')
@endsection
