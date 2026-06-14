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

            <flux:modal.trigger name="create-subject">
                <flux:button color="orange" class="cursor-pointer">
                    Nova Matéria
                </flux:button>
            </flux:modal.trigger>

        </div>

        <flux:card class="overflow-hidden">

            @if ($subjects->count())
                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead>
                            <tr class="border-b">

                                <th class="px-6 py-4 text-left text-sm font-medium">
                                    Código
                                </th>

                                <th class="px-6 py-4 text-left text-sm font-medium">
                                    Matéria
                                </th>

                                <th class="px-6 py-4 text-left text-sm font-medium">
                                    Professor
                                </th>

                                <th class="px-6 py-4 text-left text-sm font-medium">
                                    Carga Horária
                                </th>

                                <th class="px-6 py-4 text-right text-sm font-medium">
                                    Ações
                                </th>

                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($subjects as $subject)
                                <tr class="border-b hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors">

                                    <td class="px-6 py-5">

                                        <flux:badge size="sm">
                                            {{ $subject->code }}
                                        </flux:badge>

                                    </td>

                                    <td class="px-6 py-5">

                                        <div class="font-medium">
                                            {{ $subject->name }}
                                        </div>

                                        @if ($subject->description)
                                            <div class="text-sm text-zinc-500 mt-1">
                                                {{ Str::limit($subject->description, 70) }}
                                            </div>
                                        @endif

                                    </td>

                                    <td class="px-6 py-5">
                                        {{ $subject->teacher?->user?->name }}
                                    </td>

                                    <td class="px-6 py-5">

                                        <flux:badge size="sm">
                                            {{ $subject->workload_hours }}h
                                        </flux:badge>

                                    </td>

                                    <td class="px-6 py-5">

                                        <div class="flex justify-end gap-2">

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

                                        </div>

                                    </td>

                                </tr>

                                @include('App.Subjects.components.edit-modal', [
                                    'subject' => $subject,
                                ])

                                @include('App.Subjects.components.delete-modal', [
                                    'subject' => $subject,
                                ])
                            @endforeach

                        </tbody>

                    </table>

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
