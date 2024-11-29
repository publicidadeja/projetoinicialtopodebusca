<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Analytics') }} - {{ $profile->business_name }}
            </h2>
            <div class="flex space-x-4">
                <form action="{{ route('business-profiles.analytics.sync', $profile) }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                        <i class="fas fa-sync-alt mr-2"></i>
                        {{ __('Sincronizar Dados') }}
                    </button>
                </form>
                <a href="{{ route('business-profiles.analytics.export', $profile) }}" 
                   class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                    <i class="fas fa-download mr-2"></i>
                    {{ __('Exportar') }}
                </a>
                <a href="{{ route('business-profiles.show', $profile) }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Voltar') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Filtros de Data -->
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                <form method="GET" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <x-input-label for="date_range" :value="__('Período')" />
                        <select name="date_range" id="date_range" 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="7" {{ request('date_range', '7') == '7' ? 'selected' : '' }}>Últimos 7 dias</option>
                            <option value="30" {{ request('date_range') == '30' ? 'selected' : '' }}>Últimos 30 dias</option>
                            <option value="90" {{ request('date_range') == '90' ? 'selected' : '' }}>Últimos 90 dias</option>
                            <option value="365" {{ request('date_range') == '365' ? 'selected' : '' }}>Último ano</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <x-primary-button type="submit">
                            {{ __('Filtrar') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Métricas Principais -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                            {{ number_format($metrics['total_views'] ?? 0) }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            {{ __('Visualizações') }}
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400">
                            {{ number_format($metrics['total_searches'] ?? 0) }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            {{ __('Buscas') }}
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                            {{ number_format($metrics['total_actions'] ?? 0) }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            {{ __('Ações') }}
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">
                            {{ number_format($metrics['conversion_rate'] ?? 0, 1) }}%
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            {{ __('Taxa de Conversão') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Gráfico de Visualizações -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">
                        {{ __('Visualizações por Dia') }}
                    </h3>
                    <canvas id="viewsChart"></canvas>
                </div>

                <!-- Gráfico de Ações -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">
                        {{ __('Tipos de Ações') }}
                    </h3>
                    <canvas id="actionsChart"></canvas>
                </div>

                <!-- Gráfico de Origem das Buscas -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">
                        {{ __('Origem das Buscas') }}
                    </h3>
                    <canvas id="searchesChart"></canvas>
                </div>

                <!-- Gráfico de Plataformas -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">
                        {{ __('Plataformas') }}
                    </h3>
                    <canvas id="platformsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Configuração comum para modo escuro
        const isDarkMode = document.documentElement.classList.contains('dark');
        const textColor = isDarkMode ? '#E5E7EB' : '#374151';
        const gridColor = isDarkMode ? '#374151' : '#E5E7EB';

        // Configuração comum para gráficos
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    labels: {
                        color: textColor
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        color: gridColor
                    },
                    ticks: {
                        color: textColor
                    }
                },
                y: {
                    grid: {
                        color: gridColor
                    },
                    ticks: {
                        color: textColor
                    }
                }
            }
        };

        // Gráfico de Visualizações
        new Chart(document.getElementById('viewsChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($charts['views']['labels']) !!},
                datasets: [{
                    label: '{{ __("Visualizações") }}',
                    data: {!! json_encode($charts['views']['data']) !!},
                    borderColor: '#3B82F6',
                    backgroundColor: '#93C5FD',
                    fill: true
                }]
            },
            options: commonOptions
        });

        // Gráfico de Ações
        new Chart(document.getElementById('actionsChart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($charts['actions']['labels']) !!},
                datasets: [{
                    data: {!! json_encode($charts['actions']['data']) !!},
                    backgroundColor: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444']
                }]
            },
            options: {
                ...commonOptions,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: textColor
                        }
                    }
                }
            }
        });

        // Gráfico de Origem das Buscas
        new Chart(document.getElementById('searchesChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($charts['searches']['labels']) !!},
                datasets: [{
                    label: '{{ __("Buscas") }}',
                    data: {!! json_encode($charts['searches']['data']) !!},
                    backgroundColor: '#10B981'
                }]
            },
            options: commonOptions
        });

        // Gráfico de Plataformas
        new Chart(document.getElementById('platformsChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($charts['platforms']['labels']) !!},
                datasets: [{
                    data: {!! json_encode($charts['platforms']['data']) !!},
                    backgroundColor: ['#3B82F6', '#F59E0B', '#10B981']
                }]
            },
            options: {
                ...commonOptions,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            color: textColor
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>