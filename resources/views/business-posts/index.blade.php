<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Posts') }} - {{ $profile->business_name }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('business-profiles.posts.create', $profile) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Novo Post') }}
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

            <!-- Filtros -->
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
                <form method="GET" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <x-input-label for="status" :value="__('Status')" />
                        <select name="status" id="status" 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Todos</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Rascunho</option>
                            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Publicado</option>
                            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Falhou</option>
                        </select>
                    </div>

                    <div class="flex-1 min-w-[200px]">
                        <x-input-label for="search" :value="__('Buscar')" />
                        <x-text-input id="search" 
                                    name="search" 
                                    type="text" 
                                    class="mt-1 block w-full" 
                                    :value="request('search')" 
                                    placeholder="Buscar por título ou conteúdo..." />
                    </div>

                    <div class="flex items-end">
                        <x-primary-button type="submit">
                            {{ __('Filtrar') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Lista de Posts -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($posts->isEmpty())
                        <div class="text-center py-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Nenhum post encontrado.') }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Comece criando seu primeiro post!') }}
                            </p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($posts as $post)
                                <div class="border dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                    @if($post->image)
                                        <img src="{{ $post->image }}" 
                                             alt="{{ $post->title }}"
                                             class="w-full h-48 object-cover rounded-t-lg">
                                    @endif
                                    
                                    <div class="p-4">
                                        <div class="flex justify-between items-start mb-2">
                                            <h3 class="text-lg font-semibold">{{ $post->title }}</h3>
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                       {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 
                                                          ($post->status === 'draft' ? 'bg-gray-100 text-gray-800' : 
                                                           'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($post->status) }}
                                            </span>
                                        </div>

                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                            {{ Str::limit($post->content, 100) }}
                                        </p>

                                        <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                                            <span>
                                                <i class="far fa-calendar mr-1"></i>
                                                {{ $post->created_at->format('d/m/Y H:i') }}
                                            </span>
                                            
                                            @if($post->published_at)
                                                <span>
                                                    <i class="fas fa-globe mr-1"></i>
                                                    {{ $post->published_at->format('d/m/Y H:i') }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="mt-4 flex justify-end space-x-2">
                                            <a href="{{ route('business-profiles.posts.edit', [$profile, $post]) }}" 
                                               class="text-blue-600 hover:text-blue-800">
                                                {{ __('Editar') }}
                                            </a>
                                            
                                            @if($post->status === 'draft')
                                                <form method="POST" 
                                                      action="{{ route('business-profiles.posts.publish', [$profile, $post]) }}"
                                                      class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="text-green-600 hover:text-green-800">
                                                        {{ __('Publicar') }}
                                                    </button>
                                                </form>
                                            @endif

                                            <form method="POST" 
                                                  action="{{ route('business-profiles.posts.destroy', [$profile, $post]) }}"
                                                  class="inline"
                                                  onsubmit="return confirm('{{ __('Tem certeza que deseja excluir este post?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-800">
                                                    {{ __('Excluir') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>