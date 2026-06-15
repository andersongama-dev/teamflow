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
                                    Status
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

                            @foreach ($enrollments as $enrollment)
                                <tr class="border-b hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors">

                                    <td class="px-6 py-5">
                                        {{ $enrollment->student?->user?->name }}
                                    </td>

                                    <td class="px-6 py-5">
                                        <flux:badge size="sm">
                                            {{ $enrollment->schoolClass?->name }}
                                        </flux:badge>
                                    </td>

                                    <td class="px-6 py-5">
                                        {{ $enrollment->schoolClass?->subject?->name }}
                                    </td>

                                    <td class="px-6 py-5">
                                        {{ $enrollment->schoolClass?->teacher?->user?->name ?? 'Sistema' }}
                                    </td>

                                    <td class="px-6 py-5">
                                        <flux:badge size="sm">
                                            {{ ucfirst($enrollment->status) }}
                                        </flux:badge>
                                    </td>

                                    <td class="px-6 py-5">
                                        <flux:badge size="sm">
                                            {{ $enrollment->enrollment_date }}
                                        </flux:badge>
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="flex justify-end gap-2">

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
                                    </td>

                                </tr>

                                @include('App.Enrollments.components.edit-modal', [
                                    'enrollment' => $enrollment,
                                ])

                                @include('App.Enrollments.components.delete-modal', [
                                    'enrollment' => $enrollment,
                                ])
                            @endforeach

                        </tbody>

                    </table>

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
