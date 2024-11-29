<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Meus Negócios') }}
            </h2>
            <a href="{{ route('business-profiles.create') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Novo Negócio') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if($profiles->isEmpty())
                        <div class="text-center py-8">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Nenhum negócio cadastrado.') }}
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Comece cadastrando seu primeiro negócio!') }}
                            </p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($profiles as $profile)
                                <div class="border dark:border-gray-700 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                                    <div class="p-4">
                                        <h3 class="text-lg font-semibold mb-2">
                                            {{ $profile->business_name }}
                                        </h3>
                                        
                                        @if($profile->address)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                                <i class="fas fa-map-marker-alt mr-2"></i>
                                                {{ $profile->address }}
                                            </p>
                                        @endif

                                        <div class="flex space-x-4 text-sm text-gray-500 dark:text-gray-400 mb-4">
                                            <span>
                                                <i class="far fa-newspaper mr-1"></i>
                                                {{ $profile->posts_count }} posts
                                            </span>
                                            <span>
                                                <i class="far fa-star mr-1"></i>
                                                {{ $profile->reviews_count }} avaliações
                                            </span>
                                        </div>

                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('business-profiles.show', $profile) }}" 
                                               class="text-blue-600 hover:text-blue-800">
                                                {{ __('Ver') }}
                                            </a>
                                            <a href="{{ route('business-profiles.edit', $profile) }}" 
                                               class="text-green-600 hover:text-green-800">
                                                {{ __('Editar') }}
                                            </a>
                                            <form method="POST" 
                                                  action="{{ route('business-profiles.destroy', $profile) }}"
                                                  class="inline"
                                                  onsubmit="return confirm('{{ __('Tem certeza que deseja excluir este negócio?') }}')">
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
                            {{ $profiles->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>