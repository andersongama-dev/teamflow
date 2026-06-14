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

            <flux:button href="{{ route('subjects.create') }}" variant="primary" color="orange">
                Nova Matéria
            </flux:button>
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

                                            <flux:button size="sm" variant="filled"
                                                href="{{ route('subjects.edit', $subject) }}">
                                                Editar
                                            </flux:button>

                                            <form action="{{ route('subjects.destroy', $subject) }}" method="POST">

                                                @csrf
                                                @method('DELETE')

                                                <flux:button type="submit" size="sm" variant="danger">
                                                    Excluir
                                                </flux:button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>
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

                    <div class="mt-6">
                        <flux:button href="{{ route('subjects.create') }}" color="orange">
                            Criar primeira matéria
                        </flux:button>
                    </div>

                </div>
            @endif

        </flux:card>

        @if ($subjects->count())
            <div class="mt-6">
                {{ $subjects->links() }}
            </div>
        @endif

    </div>
@endsection
