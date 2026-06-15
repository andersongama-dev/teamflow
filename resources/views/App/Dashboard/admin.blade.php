@extends('layoutApp')

@section('container')
    <div class="space-y-8">

        <div>
            <h1 class="text-3xl font-bold">
                Dashboard Administrativo
            </h1>

            <p class="text-zinc-500 mt-1">
                Visão geral do TeamFlow
            </p>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            <flux:card class="xl:col-span-2">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="font-semibold text-lg">
                            Estatísticas do Sistema
                        </h2>

                        <p class="text-sm text-zinc-500">
                            Distribuição geral dos registros
                        </p>
                    </div>
                </div>

                <div class="h-[350px]">
                    <canvas id="systemChart"></canvas>
                </div>
            </flux:card>

            <flux:card>
                <div class="space-y-5">

                    <div>
                        <h2 class="font-semibold text-lg">
                            Resumo Rápido
                        </h2>

                        <p class="text-sm text-zinc-500">
                            Indicadores principais
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
                            <span class="text-zinc-500">Professores</span>

                            <flux:badge color="orange">
                                {{ $teachers }}
                            </flux:badge>
                        </div>

                    </div>

                </div>
            </flux:card>

        </div>

    </div>

    <script>
        const ctx = document.getElementById('systemChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    'Alunos',
                    'Professores',
                    'Matérias',
                    'Turmas',
                    'Matrículas',
                    'Notas',
                    'Frequências'
                ],
                datasets: [{
                    label: 'Quantidade',
                    data: [
                        {{ $students }},
                        {{ $teachers }},
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
