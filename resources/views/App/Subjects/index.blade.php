@extends('layoutApp')

@section('container')
    <div class="">

        <div class="flex items-center justify-between mb-8">
            <div>
                <flux:heading size="xl">Minhas Matérias</flux:heading>

                <flux:text class="mt-1 text-zinc-500">
                    Visualize e gerencie as matérias sob sua responsabilidade.
                </flux:text>
            </div>

            <flux:modal.trigger name="create-subject">
                <flux:button variant="primary" color="orange">
                    Nova Matéria
                </flux:button>
            </flux:modal.trigger>
        </div>

        <flux:card class="overflow-hidden">

            @if ($subjects->count())
                <div class="overflow-x-auto">
                    <table class="w-full">

                        <thead>
                            <tr class="border-b bg-zinc-50 dark:bg-zinc-900">
                                <th class="px-6 py-4 text-left font-medium">
                                    Código
                                </th>

                                <th class="px-6 py-4 text-left font-medium">
                                    Matéria
                                </th>

                                <th class="px-6 py-4 text-left font-medium">
                                    Professor
                                </th>

                                <th class="px-6 py-4 text-left font-medium">
                                    Carga Horária
                                </th>

                                <th class="px-6 py-4 text-right font-medium">
                                    Ações
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($subjects as $subject)
                                <tr class="border-b transition hover:bg-zinc-50 dark:hover:bg-zinc-900">

                                    <td class="px-6 py-5">
                                        <flux:badge>
                                            {{ $subject->code }}
                                        </flux:badge>
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="font-medium">
                                            {{ $subject->name }}
                                        </div>

                                        @if ($subject->description)
                                            <div class="text-sm text-zinc-500 mt-1">
                                                {{ Str::limit($subject->description, 60) }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5">
                                        {{ $subject->teacher?->user?->name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-5">
                                        <flux:badge>
                                            {{ $subject->workload_hours }}h
                                        </flux:badge>
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="flex justify-end gap-2">

                                            <flux:button size="sm" href="{{ route('subjects.show', $subject) }}">
                                                Ver
                                            </flux:button>

                                            <flux:modal.trigger name="edit-subject-{{ $subject->id }}">
                                                <flux:button size="sm" variant="filled">
                                                    Editar
                                                </flux:button>
                                            </flux:modal.trigger>

                                            <flux:modal.trigger name="delete-subject-{{ $subject->id }}">
                                                <flux:button size="sm" variant="danger">
                                                    Excluir
                                                </flux:button>
                                            </flux:modal.trigger>

                                        </div>
                                    </td>

                                </tr>
                                <flux:modal name="edit-subject-{{ $subject->id }}" class="md:w-[600px]">

                                    <div class="space-y-6">

                                        <div>
                                            <flux:heading size="lg">
                                                Editar Matéria
                                            </flux:heading>

                                            <flux:text>
                                                Atualize os dados da matéria.
                                            </flux:text>
                                        </div>

                                        <form action="{{ route('subjects.update', $subject) }}" method="POST"
                                            class="space-y-4">

                                            @csrf
                                            @method('PUT')

                                            <flux:input name="name" label="Nome da Matéria"
                                                value="{{ $subject->name }}" />

                                            <flux:input name="code" label="Código" value="{{ $subject->code }}" />

                                            <flux:input type="number" name="workload_hours" label="Carga Horária"
                                                value="{{ $subject->workload_hours }}" />

                                            <flux:textarea name="description" label="Descrição">{{ $subject->description }}
                                            </flux:textarea>

                                            <div class="flex justify-end gap-2">

                                                <flux:modal.close>
                                                    <flux:button variant="ghost">
                                                        Cancelar
                                                    </flux:button>
                                                </flux:modal.close>

                                                <flux:button type="submit" color="orange">
                                                    Atualizar
                                                </flux:button>

                                            </div>

                                        </form>

                                    </div>

                                </flux:modal>

                                <flux:modal name="delete-subject-{{ $subject->id }}" class="md:w-[500px]">

                                    <div class="space-y-6">

                                        <div>
                                            <flux:heading size="lg">
                                                Confirmar exclusão
                                            </flux:heading>

                                            <flux:text class="mt-2">
                                                Tem certeza que deseja excluir a matéria
                                                <strong>{{ $subject->name }}</strong>?
                                            </flux:text>

                                            <flux:text class="text-red-500 mt-2">
                                                Esta ação não poderá ser desfeita.
                                            </flux:text>
                                        </div>

                                        <div class="flex justify-end gap-2">

                                            <flux:modal.close>
                                                <flux:button variant="ghost">
                                                    Cancelar
                                                </flux:button>
                                            </flux:modal.close>

                                            <form action="{{ route('subjects.destroy', $subject) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <flux:button type="submit" variant="danger">
                                                    Sim, excluir
                                                </flux:button>
                                            </form>

                                        </div>

                                    </div>

                                </flux:modal>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            @else
                <div class="py-16 text-center">

                    <flux:heading size="lg">
                        Nenhuma matéria cadastrada
                    </flux:heading>

                    <flux:text class="mt-2">
                        Você ainda não possui matérias vinculadas.
                    </flux:text>

                    <flux:modal.trigger name="create-subject">
                        <flux:button color="orange" class="mt-8">
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

    <flux:modal name="create-subject" class="md:w-[600px]">
        <div class="space-y-6">

            <div>
                <flux:heading size="lg">
                    Nova Matéria
                </flux:heading>

                <flux:text>
                    Preencha os dados da matéria.
                </flux:text>
            </div>

            <form action="{{ route('subjects.store') }}" method="POST" class="space-y-4">
                @csrf

                <flux:input name="name" label="Nome da Matéria" value="{{ old('name') }}" />

                <flux:input name="code" label="Código" value="{{ old('code') }}" />

                <flux:input type="number" name="workload_hours" label="Carga Horária"
                    value="{{ old('workload_hours') }}" />

                <flux:textarea name="description" label="Descrição">{{ old('description') }}</flux:textarea>

                <div class="flex justify-end gap-2">
                    <flux:modal.close>
                        <flux:button variant="ghost">
                            Cancelar
                        </flux:button>
                    </flux:modal.close>

                    <flux:button type="submit" color="orange">
                        Salvar
                    </flux:button>
                </div>

            </form>

        </div>
    </flux:modal>
@endsection
