<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Novo Post') }} - {{ $profile->business_name }}
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
                          action="{{ route('business-profiles.posts.store', $profile) }}" 
                          enctype="multipart/form-data"
                          class="space-y-6">
                        @csrf

                        <!-- Título -->
                        <div>
                            <x-input-label for="title" :value="__('Título')" />
                            <x-text-input id="title" 
                                        name="title" 
                                        type="text" 
                                        class="mt-1 block w-full" 
                                        :value="old('title')" 
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
                                    maxlength="1500">{{ old('content') }}</textarea>
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Máximo 1500 caracteres') }}
                            </p>
                        </div>

                        <!-- Imagem -->
                        <div>
                            <x-input-label for="image" :value="__('Imagem')" />
                            <div class="mt-1 flex items-center">
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
                                <option value="LEARN_MORE" {{ old('cta_type') === 'LEARN_MORE' ? 'selected' : '' }}>
                                    {{ __('Saiba Mais') }}
                                </option>
                                <option value="BOOK" {{ old('cta_type') === 'BOOK' ? 'selected' : '' }}>
                                    {{ __('Reserve Agora') }}
                                </option>
                                <option value="ORDER" {{ old('cta_type') === 'ORDER' ? 'selected' : '' }}>
                                    {{ __('Peça Agora') }}
                                </option>
                                <option value="SHOP" {{ old('cta_type') === 'SHOP' ? 'selected' : '' }}>
                                    {{ __('Compre Agora') }}
                                </option>
                                <option value="SIGN_UP" {{ old('cta_type') === 'SIGN_UP' ? 'selected' : '' }}>
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
                                        :value="old('cta_url')" 
                                        placeholder="https://" />
                            <x-input-error :messages="$errors->get('cta_url')" class="mt-2" />
                        </div>

                        <!-- Opções de Publicação -->
                        <div class="border-t pt-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input type="checkbox" 
                                           id="publish_now" 
                                           name="publish_now" 
                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                           {{ old('publish_now') ? 'checked' : '' }}>
                                    <label for="publish_now" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                        {{ __('Publicar imediatamente') }}
                                    </label>
                                </div>

                                <x-primary-button class="ml-4">
                                    {{ __('Criar Post') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Preview da imagem
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
                const existingPreview = container.querySelector('img');
                if (existingPreview) {
                    container.removeChild(existingPreview);
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
    </script>
    @endpush
</x-app-layout>