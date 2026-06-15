@extends('layoutApp')

@section('container')
    <div class="space-y-8">

        <div>
            <h1 class="text-3xl font-bold">
                Dashboard do Professor
            </h1>

            <p class="text-zinc-500 mt-1">
                Visão geral das suas atividades acadêmicas
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

            <flux:card class="border-l-4 border-orange-500">
                <div>
                    <p class="text-sm text-zinc-500">Matérias</p>
                    <p class="text-4xl font-bold mt-2">
                        {{ $subjects }}
                    </p>
                </div>
            </flux:card>

            <flux:card class="border-l-4 border-orange-500">
                <div>
                    <p class="text-sm text-zinc-500">Turmas</p>
                    <p class="text-4xl font-bold mt-2">
                        {{ $classes }}
                    </p>
                </div>
            </flux:card>

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
                    <p class="text-sm text-zinc-500">Notas Lançadas</p>
                    <p class="text-4xl font-bold mt-2">
                        {{ $grades }}
                    </p>
                </div>
            </flux:card>

        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            <flux:card class="xl:col-span-2">

                <div class="flex items-center justify-between mb-6">

                    <div>
                        <h2 class="font-semibold text-lg">
                            Desempenho Acadêmico
                        </h2>

                        <p class="text-sm text-zinc-500">
                            Dados relacionados às suas turmas
                        </p>
                    </div>

                </div>

                <div class="h-[350px]">
                    <canvas id="teacherChart"></canvas>
                </div>

            </flux:card>

            <flux:card>

                <div class="space-y-5">

                    <div>
                        <h2 class="font-semibold text-lg">
                            Resumo Rápido
                        </h2>

                        <p class="text-sm text-zinc-500">
                            Seus indicadores atuais
                        </p>
                    </div>

                    <div class="space-y-4">

                        <div class="flex items-center justify-between">
                            <span class="text-zinc-500">Matérias</span>

                            <flux:badge color="orange">
                                {{ $subjects }}
                            </flux:badge>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-zinc-500">Turmas</span>

                            <flux:badge color="orange">
                                {{ $classes }}
                            </flux:badge>
                        </div>

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

                    </div>

                </div>

            </flux:card>

        </div>

    </div>

    <script>
        new Chart(document.getElementById('teacherChart'), {
            type: 'bar',
            data: {
                labels: [
                    'Matérias',
                    'Turmas',
                    'Matrículas',
                    'Notas',
                    'Frequências'
                ],
                datasets: [{
                    data: [
                        {{ $subjects }},
                        {{ $classes }},
                        {{ $enrollments }},
                        {{ $grades }},
                        {{ $attendances }}
                    ],
                    backgroundColor: '#fb7200',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
