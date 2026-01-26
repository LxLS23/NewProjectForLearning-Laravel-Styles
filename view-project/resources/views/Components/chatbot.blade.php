@extends('layouts.app')

@section('title', 'ChatBot View')

@section('content')

    <div class="flex flex-col h-screen">
        {{-- Header del Chat --}}
        <div class="bg-white border-b border-gray-200 px-6 py-4">
            <div class="flex items-center gap-3">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">ChatBot Assistant</h2>
                    <p class="text-sm text-gray-500">Siempre en línea</p>
                </div>
            </div>
        </div>

        {{-- Área de Mensajes --}}
        <div class="flex-1 overflow-y-auto bg-gray-50 p-6" id="chat-container">

            {{-- Mensaje del Bot --}}
            <div class="flex items-start gap-2.5 mb-4">
                <div
                    class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 bg-white rounded-e-xl rounded-es-xl border border-gray-200 shadow-sm">
                    <div class="flex items-center space-x-2 rtl:space-x-reverse mb-2">
                        <span class="text-sm font-semibold text-gray-900">Asistente virtual</span>
                        <span class="text-xs text-gray-500">hour</span>
                    </div>
                    <p class="text-sm text-gray-700">¡Hola! Soy tu asistente virtual del HNM. ¿En qué puedo ayudarte hoy?
                    </p>
                </div>
                <button type="button" data-dropdown-toggle="dropdownDots1"
                    class="inline-flex self-center items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 4 15">
                        <path
                            d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                    </svg>
                </button>
                <div id="dropdownDots1" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-40">
                    <ul class="py-2 text-sm text-gray-700">
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Responder</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Copiar</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Eliminar</a></li>
                    </ul>
                </div>
            </div>

        </div>

        {{-- Input de Mensaje --}}
        <div class="bg-white border-t border-gray-200 px-6 py-4">
            <form id="chat-form" class="flex items-center gap-2">
                @csrf

                {{-- Input de Texto --}}
                <div class="flex-1">
                    <label for="chat-input" class="sr-only">Escribe tu mensaje</label>
                    <div class="relative">
                        <input type="text" id="chat-input" name="message"
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Escribe tu mensaje aquí..." required />
                    </div>
                </div>

                {{-- Botón de Enviar --}}
                <button type="submit"
                    class="inline-flex justify-center items-center p-3 text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <svg class="w-5 h-5 rotate-90 rtl:-rotate-90" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 18 20">
                        <path
                            d="m17.914 18.594-8-18a1 1 0 0 0-1.828 0l-8 18a1 1 0 0 0 1.157 1.376L8 18.281V9a1 1 0 0 1 2 0v9.281l6.758 1.689a1 1 0 0 0 1.156-1.376Z" />
                    </svg>
                    <span class="sr-only">Enviar mensaje</span>
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const chatForm = document.getElementById('chat-form');
            const chatInput = document.getElementById('chat-input');
            const chatContainer = document.getElementById('chat-container');

            function addBotMessage(text) {
                chatContainer.insertAdjacentHTML('beforeend', `
            <div class="flex items-start gap-2.5 mb-4">
                <div class="flex flex-col max-w-[320px] p-4 bg-white rounded-xl border shadow-sm">
                    <span class="text-sm font-semibold">Asistente virtual</span>
                    <p class="text-sm text-gray-700">${text}</p>
                </div>
            </div>
        `);
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }

            function addUserMessage(text) {
                chatContainer.insertAdjacentHTML('beforeend', `
            <div class="flex justify-end mb-4">
                <div class="bg-blue-100 p-4 rounded-xl max-w-[320px]">
                    <p class="text-sm">${text}</p>
                </div>
            </div>
        `);
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }

            chatForm.addEventListener('submit', async (e) => {
                e.preventDefault();

                const message = chatInput.value.trim();
                if (!message) return;

                addUserMessage(message);
                chatInput.value = '';

                try {
                    const response = await fetch('/chatbot', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message
                        })
                    });

                    const data = await response.json();
                    addBotMessage(data.reply);

                } catch (error) {
                    addBotMessage('Ocurrió un error');
                }
            });
        });
    </script>
@endpush
