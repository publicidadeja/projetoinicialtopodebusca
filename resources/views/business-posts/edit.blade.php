<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar Post') }} - {{ $profile->business_name }}
            </h2>
            <a href="{{ route('business-profiles.posts.index', $profile) }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Voltar') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" 
                          action="{{ route('business-profiles.posts.update', [$profile, $post]) }}" 
                          enctype="multipart/form-data"
                          class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Status do Post -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
                                        Status:
                                    </span>
                                    <span class="ml-2 px-2 py-1 text-xs rounded-full 
                                               {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 
                                                  ($post->status === 'draft' ? 'bg-gray-100 text-gray-800' : 
                                                   'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    @if($post->published_at)
                                        {{ __('Publicado em') }}: {{ $post->published_at->format('d/m/Y H:i') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Título -->
                        <div>
                            <x-input-label for="title" :value="__('Título')" />
                            <x-text-input id="title" 
                                        name="title" 
                                        type="text" 
                                        class="mt-1 block w-full" 
                                        :value="old('title', $post->title)" 
                                        required 
                                        maxlength="100" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Máximo 100 caracteres') }}
                            </p>
                        </div>

                        <!-- Conteúdo -->
                        <div>
                            <x-input-label for="content" :value="__('Conteúdo')" />
                            <textarea id="content" 
                                    name="content" 
                                    rows="5"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required
                                    maxlength="1500">{{ old('content', $post->content) }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Máximo 1500 caracteres') }}
                            </p>
                        </div>

                        <!-- Imagem -->
                        <div>
                            <x-input-label for="image" :value="__('Imagem')" />
                            <div class="mt-1">
                                @if($post->image)
                                    <div class="mb-2">
                                        <img src="{{ $post->image }}" 
                                             alt="{{ $post->title }}"
                                             class="rounded-lg max-h-48 object-cover">
                                    </div>
                                    <div class="flex items-center mb-4">
                                        <input type="checkbox" 
                                               id="remove_image" 
                                               name="remove_image" 
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <label for="remove_image" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                            {{ __('Remover imagem atual') }}
                                        </label>
                                    </div>
                                @endif
                                
                                <input type="file" 
                                       id="image" 
                                       name="image" 
                                       accept="image/*"
                                       class="block w-full text-sm text-gray-500 dark:text-gray-400
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-full file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-blue-50 file:text-blue-700
                                              hover:file:bg-blue-100
                                              dark:file:bg-gray-700 dark:file:text-gray-200" />
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Formatos aceitos: JPG, PNG. Tamanho máximo: 2MB') }}
                            </p>
                        </div>

                        <!-- Call to Action -->
                        <div>
                            <x-input-label for="cta_type" :value="__('Call to Action (CTA)')" />
                            <select id="cta_type" 
                                    name="cta_type"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">{{ __('Nenhum') }}</option>
                                <option value="LEARN_MORE" {{ old('cta_type', $post->cta_type) === 'LEARN_MORE' ? 'selected' : '' }}>
                                    {{ __('Saiba Mais') }}
                                </option>
                                <option value="BOOK" {{ old('cta_type', $post->cta_type) === 'BOOK' ? 'selected' : '' }}>
                                    {{ __('Reserve Agora') }}
                                </option>
                                <option value="ORDER" {{ old('cta_type', $post->cta_type) === 'ORDER' ? 'selected' : '' }}>
                                    {{ __('Peça Agora') }}
                                </option>
                                <option value="SHOP" {{ old('cta_type', $post->cta_type) === 'SHOP' ? 'selected' : '' }}>
                                    {{ __('Compre Agora') }}
                                </option>
                                <option value="SIGN_UP" {{ old('cta_type', $post->cta_type) === 'SIGN_UP' ? 'selected' : '' }}>
                                    {{ __('Cadastre-se') }}
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('cta_type')" class="mt-2" />
                        </div>

                        <!-- URL do CTA -->
                        <div>
                            <x-input-label for="cta_url" :value="__('URL do Call to Action')" />
                            <x-text-input id="cta_url" 
                                        name="cta_url" 
                                        type="url" 
                                        class="mt-1 block w-full" 
                                        :value="old('cta_url', $post->cta_url)" 
                                        :disabled="!$post->cta_type"
                                        placeholder="https://" />
                            <x-input-error :messages="$errors->get('cta_url')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Atualizar Post') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Preview da nova imagem
        document.getElementById('image').onchange = function (evt) {
            const [file] = this.files;
            if (file) {
                const preview = document.createElement('img');
                preview.src = URL.createObjectURL(file);
                preview.onload = function() {
                    URL.revokeObjectURL(this.src);
                }
                preview.className = 'mt-2 rounded-lg max-h-48 object-cover';
                
                const container = this.parentElement;
                const newPreview = container.querySelector('img:not([src^="http"])');
                if (newPreview) {
                    container.removeChild(newPreview);
                }
                container.appendChild(preview);
            }
        };

        // Habilitar/desabilitar URL do CTA
        document.getElementById('cta_type').onchange = function() {
            const ctaUrlInput = document.getElementById('cta_url');
            ctaUrlInput.disabled = !this.value;
            if (!this.value) {
                ctaUrlInput.value = '';
            }
        };

        // Remover preview ao marcar checkbox de remoção
        const removeImageCheckbox = document.getElementById('remove_image');
        if (removeImageCheckbox) {
            removeImageCheckbox.onchange = function() {
                const imagePreview = this.parentElement.previousElementSibling;
                if (this.checked) {
                    imagePreview.style.opacity = '0.5';
                } else {
                    imagePreview.style.opacity = '1';
                }
            };
        }
    </script>
    @endpush
</x-app-layout>