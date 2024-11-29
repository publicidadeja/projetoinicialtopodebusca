<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Avaliações') }} - {{ $profile->business_name }}
            </h2>
            <div class="flex space-x-4">
                <form action="{{ route('business-profiles.reviews.sync', $profile) }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                        <i class="fas fa-sync-alt mr-2"></i>
                        {{ __('Sincronizar Avaliações') }}
                    </button>
                </form>
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

            <!-- Métricas de Avaliações -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                            {{ number_format($metrics['average_rating'] ?? 0, 1) }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            {{ __('Média Geral') }}
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400">
                            {{ $metrics['total_reviews'] ?? 0 }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            {{ __('Total de Avaliações') }}
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                            {{ $metrics['pending_replies'] ?? 0 }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            {{ __('Aguardando Resposta') }}
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">
                            {{ number_format($metrics['reply_rate'] ?? 0, 1) }}%
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                            {{ __('Taxa de Resposta') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                <form method="GET" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <x-input-label for="rating" :value="__('Avaliação')" />
                        <select name="rating" id="rating" 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Todas</option>
                            @foreach(range(5, 1) as $stars)
                                <option value="{{ $stars }}" {{ request('rating') == $stars ? 'selected' : '' }}>
                                    {{ $stars }} {{ __('estrelas') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-1 min-w-[200px]">
                        <x-input-label for="reply_status" :value="__('Status de Resposta')" />
                        <select name="reply_status" id="reply_status" 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Todos</option>
                            <option value="replied" {{ request('reply_status') === 'replied' ? 'selected' : '' }}>
                                {{ __('Respondidas') }}
                            </option>
                            <option value="pending" {{ request('reply_status') === 'pending' ? 'selected' : '' }}>
                                {{ __('Não Respondidas') }}
                            </option>
                        </select>
                    </div>

                    <div class="flex-1 min-w-[200px]">
                        <x-input-label for="search" :value="__('Buscar')" />
                        <x-text-input id="search" 
                                    name="search" 
                                    type="text" 
                                    class="mt-1 block w-full" 
                                    :value="request('search')" 
                                    placeholder="Buscar em comentários..." />
                    </div>

                    <div class="flex items-end">
                        <x-primary-button type="submit">
                            {{ __('Filtrar') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Lista de Avaliações -->
            <div class="space-y-6">
                @forelse($reviews as $review)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($review->reviewer_avatar)
                                            <img src="{{ $review->reviewer_avatar }}" 
                                                 alt="{{ $review->reviewer_name }}"
                                                 class="h-10 w-10 rounded-full">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                                <i class="fas fa-user text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ $review->reviewer_name }}
                                        </div>
                                        <div class="flex items-center mt-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                            @endfor
                                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                                {{ $review->created_at->format('d/m/Y H:i') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                @if(!$review->reply)
                                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                        {{ __('Aguardando Resposta') }}
                                    </span>
                                @endif
                            </div>

                            <div class="mt-4 text-gray-700 dark:text-gray-300">
                                {{ $review->comment }}
                            </div>

                            @if($review->reply)
                                <div class="mt-4 ml-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="h-8 w-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                                                <i class="fas fa-building text-blue-500 dark:text-blue-400"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ $profile->business_name }}
                                            </div>
                                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                {{ $review->reply_date?->format('d/m/Y H:i') }}
                                            </div>
                                            <div class="mt-2 text-gray-700 dark:text-gray-300">
                                                {{ $review->reply }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="mt-4">
                                    <form action="{{ route('business-profiles.reviews.reply', [$profile, $review]) }}" 
                                          method="POST"
                                          class="space-y-4">
                                        @csrf
                                        <div>
                                            <x-input-label for="reply_{{ $review->id }}" :value="__('Sua Resposta')" />
                                            <textarea id="reply_{{ $review->id }}" 
                                                    name="reply" 
                                                    rows="3"
                                                    required
                                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                    placeholder="{{ __('Digite sua resposta...') }}"></textarea>
                                        </div>
                                        <div class="flex justify-end">
                                            <x-primary-button type="submit">
                                                {{ __('Responder') }}
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center">
                            <p class="text-gray-700 dark:text-gray-300">
                                {{ __('Nenhuma avaliação encontrada.') }}
                            </p>
                        </div>
                    </div>
                @endforelse

                <div class="mt-6">
                    {{ $reviews->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>