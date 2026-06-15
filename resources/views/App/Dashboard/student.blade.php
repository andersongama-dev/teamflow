@extends('layoutApp')

@section('container')
    <div class="space-y-8">

        <div>
            <h1 class="text-3xl font-bold">
                Dashboard do Aluno
            </h1>

            <p class="text-zinc-500 mt-1">
                Acompanhe seu desempenho acadêmico
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">

            <flux:card class="border-l-4 border-orange-500">
                <div>
                    <p class="text-sm text-zinc-500">Matrículas</p>
                    <p class="text-4xl font-bold mt-2">
                        {{ $enrollments }}
                    </p>
                </div>
            </flux:card>

            <flux:card class="border-l-4 border-orange-500">
                <div>
                    <p class="text-sm text-zinc-500">Notas Registradas</p>
                    <p class="text-4xl font-bold mt-2">
                        {{ $grades }}
                    </p>
                </div>
            </flux:card>

            <flux:card class="border-l-4 border-orange-500">
                <div>
                    <p class="text-sm text-zinc-500">Frequências</p>
                    <p class="text-4xl font-bold mt-2">
                        {{ $attendances }}
                    </p>
                </div>
            </flux:card>

            <flux:card class="border-l-4 border-orange-500">
                <div>
                    <p class="text-sm text-zinc-500">Média Geral</p>
                    <p class="text-4xl font-bold mt-2">
                        {{ number_format($averageGrade ?? 0, 1) }}
                    </p>
                </div>
            </flux:card>

        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            <flux:card class="xl:col-span-2">

                <div class="mb-6">

                    <h2 class="font-semibold text-lg">
                        Desempenho Acadêmico
                    </h2>

                    <p class="text-sm text-zinc-500">
                        Resumo dos seus indicadores
                    </p>

                </div>

                <div class="h-87.5">
                    <canvas id="studentChart"></canvas>
                </div>

            </flux:card>

            <flux:card>

                <div class="space-y-5">

                    <div>
                        <h2 class="font-semibold text-lg">
                            Resumo Rápido
                        </h2>

                        <p class="text-sm text-zinc-500">
                            Seus números atuais
                        </p>
                    </div>

                    <div class="space-y-4">

                        <div class="flex items-center justify-between">
                            <span class="text-zinc-500">Matrículas</span>

                            <flux:badge color="orange">
                                {{ $enrollments }}
                            </flux:badge>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-zinc-500">Notas</span>

                            <flux:badge color="orange">
                                {{ $grades }}
                            </flux:badge>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-zinc-500">Frequências</span>

                            <flux:badge color="orange">
                                {{ $attendances }}
                            </flux:badge>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-zinc-500">Média Geral</span>

                            <flux:badge color="orange">
                                {{ number_format($averageGrade ?? 0, 1) }}
                            </flux:badge>
                        </div>

                    </div>

                </div>

            </flux:card>

        </div>

    </div>

    <script>
        new Chart(document.getElementById('studentChart'), {
            type: 'doughnut',
            data: {
                labels: [
                    'Matrículas',
                    'Notas',
                    'Frequências'
                ],
                datasets: [{
                    data: [
                        {{ $enrollments }},
                        {{ $grades }},
                        {{ $attendances }}
                    ],
                    backgroundColor: [
                        '#fb7200',
                        '#fd8f33',
                        '#ffb066'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
@endsection
