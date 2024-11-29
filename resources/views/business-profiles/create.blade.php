<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Adicionar Novo Negócio') }}
            </h2>
            <a href="{{ route('business-profiles.index') }}" 
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Voltar') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <form method="POST" action="{{ route('business-profiles.store') }}" class="space-y-6">
                        @csrf

                        <!-- Business Name -->
                        <div>
                            <x-input-label for="business_name" :value="__('Nome do Negócio')" />
                            <x-text-input id="business_name" 
                                        class="block mt-1 w-full" 
                                        type="text" 
                                        name="business_name" 
                                        :value="old('business_name')" 
                                        required 
                                        autofocus />
                            <x-input-error :messages="$errors->get('business_name')" class="mt-2" />
                        </div>

                        <!-- Address -->
                        <div>
                            <x-input-label for="address" :value="__('Endereço')" />
                            <x-text-input id="address" 
                                        class="block mt-1 w-full" 
                                        type="text" 
                                        name="address" 
                                        :value="old('address')" />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <!-- Phone -->
                        <div>
                            <x-input-label for="phone" :value="__('Telefone')" />
                            <x-text-input id="phone" 
                                        class="block mt-1 w-full" 
                                        type="text" 
                                        name="phone" 
                                        :value="old('phone')" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <!-- Website -->
                        <div>
                            <x-input-label for="website" :value="__('Website')" />
                            <x-text-input id="website" 
                                        class="block mt-1 w-full" 
                                        type="url" 
                                        name="website" 
                                        :value="old('website')" 
                                        placeholder="https://" />
                            <x-input-error :messages="$errors->get('website')" class="mt-2" />
                        </div>

                        <!-- Business Hours -->
                        <div>
                            <x-input-label :value="__('Horário de Funcionamento')" class="mb-2" />
                            @php
                                $days = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];
                            @endphp
                            
                            <div class="space-y-4">
                                @foreach($days as $index => $day)
                                    <div class="flex items-center space-x-4">
                                        <span class="w-24 text-sm text-gray-700 dark:text-gray-300">{{ $day }}</span>
                                        <x-text-input type="time" 
                                                    name="business_hours[{{ $index }}][open]" 
                                                    class="w-32" />
                                        <span class="text-gray-500">até</span>
                                        <x-text-input type="time" 
                                                    name="business_hours[{{ $index }}][close]" 
                                                    class="w-32" />
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Cadastrar Negócio') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>