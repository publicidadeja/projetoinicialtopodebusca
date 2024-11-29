<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Editar') }} - {{ $profile->business_name }}
            </h2>
            <a href="{{ route('business-profiles.show', $profile) }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Voltar') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <form method="POST" action="{{ route('business-profiles.update', $profile) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Business Name -->
                        <div>
                            <x-input-label for="business_name" :value="__('Nome do Negócio')" />
                            <x-text-input id="business_name" 
                                        class="block mt-1 w-full" 
                                        type="text" 
                                        name="business_name" 
                                        :value="old('business_name', $profile->business_name)" 
                                        required />
                            <x-input-error :messages="$errors->get('business_name')" class="mt-2" />
                        </div>

                        <!-- Address -->
                        <div>
                            <x-input-label for="address" :value="__('Endereço')" />
                            <x-text-input id="address" 
                                        class="block mt-1 w-full" 
                                        type="text" 
                                        name="address" 
                                        :value="old('address', $profile->address)" />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <!-- Phone -->
                        <div>
                            <x-input-label for="phone" :value="__('Telefone')" />
                            <x-text-input id="phone" 
                                        class="block mt-1 w-full" 
                                        type="text" 
                                        name="phone" 
                                        :value="old('phone', $profile->phone)" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <!-- Website -->
                        <div>
                            <x-input-label for="website" :value="__('Website')" />
                            <x-text-input id="website" 
                                        class="block mt-1 w-full" 
                                        type="url" 
                                        name="website" 
                                        :value="old('website', $profile->website)" 
                                        placeholder="https://" />
                            <x-input-error :messages="$errors->get('website')" class="mt-2" />
                        </div>

                        <!-- Business Hours -->
                        <div>
                            <x-input-label :value="__('Horário de Funcionamento')" class="mb-2" />
                            @php
                                $days = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];
                                $hours = $profile->business_hours ?? [];
                            @endphp
                            
                            <div class="space-y-4">
                                @foreach($days as $index => $day)
                                    <div class="flex items-center space-x-4">
                                        <span class="w-24 text-sm text-gray-700 dark:text-gray-300">{{ $day }}</span>
                                        <x-text-input type="time" 
                                                    name="business_hours[{{ $index }}][open]" 
                                                    class="w-32"
                                                    :value="$hours[$index]['open'] ?? ''" />
                                        <span class="text-gray-500 dark:text-gray-400">até</span>
                                        <x-text-input type="time" 
                                                    name="business_hours[{{ $index }}][close]" 
                                                    class="w-32"
                                                    :value="$hours[$index]['close'] ?? ''" />
                                        
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" 
                                                   class="form-checkbox text-blue-600"
                                                   name="business_hours[{{ $index }}][closed]"
                                                   {{ !isset($hours[$index]) || 
                                                      (isset($hours[$index]['closed']) && $hours[$index]['closed']) ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Fechado</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Google Business Profile Settings -->
                        <div class="border-t pt-6 mt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                {{ __('Configurações do Google Business Profile') }}
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="google_business_id" :value="__('ID do Negócio no Google')" />
                                    <x-text-input id="google_business_id" 
                                                class="block mt-1 w-full" 
                                                type="text" 
                                                name="google_business_id" 
                                                :value="old('google_business_id', $profile->google_business_id)" />
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('Este ID é usado para sincronização com o Google Business Profile') }}
                                    </p>
                                </div>

                                <div>
                                    <x-input-label for="google_account_id" :value="__('ID da Conta Google')" />
                                    <x-text-input id="google_account_id" 
                                                class="block mt-1 w-full" 
                                                type="text" 
                                                name="google_account_id" 
                                                :value="old('google_account_id', $profile->google_account_id)" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Atualizar Negócio') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>