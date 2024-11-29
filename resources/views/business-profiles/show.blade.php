<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $profile->business_name }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('business-profiles.edit', $profile) }}" 
                   class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Editar') }}
                </a>
                <a href="{{ route('business-profiles.index') }}" 
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Informações Principais -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Informações do Negócio') }}
                        </h3>
                        
                        <div class="space-y-4">
                            @if($profile->address)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Endereço') }}</label>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        {{ $profile->address }}
                                    </p>
                                </div>
                            @endif

                            @if($profile->phone)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Telefone') }}</label>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-phone mr-2"></i>
                                        {{ $profile->phone }}
                                    </p>
                                </div>
                            @endif

                            @if($profile->website)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Website') }}</label>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-globe mr-2"></i>
                                        <a href="{{ $profile->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                            {{ $profile->website }}
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Horário de Funcionamento -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Horário de Funcionamento') }}
                        </h3>
                        
                        @if($profile->business_hours)
                            <div class="space-y-2">
                                @php
                                    $days = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];
                                @endphp

                                @foreach($days as $index => $day)
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $day }}</span>
                                        <span class="text-sm text-gray-600 dark:text-gray-400">
                                            @if(isset($profile->business_hours[$index]))
                                                {{ $profile->business_hours[$index]['open'] }} - {{ $profile->business_hours[$index]['close'] }}
                                            @else
                                                Fechado
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Horários não definidos') }}
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Estatísticas Rápidas -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('Estatísticas') }}
                        </h3>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <span class="block text-2xl font-bold text-blue-600 dark:text-blue-400">
                                    {{ $profile->posts_count ?? 0 }}
                                </span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Posts</span>
                            </div>
                            
                            <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <span class="block text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                                    {{ $profile->reviews_count ?? 0 }}
                                </span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Avaliações</span>
                            </div>
                        </div>

                        <div class="mt-6 space-y-2">
                            <a href="{{ route('business-profiles.posts.index', $profile) }}" 
                               class="block w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Ver Posts') }}
                            </a>
                            
                            <a href="{{ route('business-profiles.reviews.index', $profile) }}" 
                               class="block w-full text-center bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Ver Avaliações') }}
                            </a>
                            
                            <a href="{{ route('business-profiles.analytics.index', $profile) }}" 
                               class="block w-full text-center bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Ver Analytics') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botão de Exclusão -->
            <div class="mt-6 flex justify-end">
                <form method="POST" action="{{ route('business-profiles.destroy', $profile) }}" 
                      onsubmit="return confirm('{{ __('Tem certeza que deseja excluir este negócio?') }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('Excluir Negócio') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>