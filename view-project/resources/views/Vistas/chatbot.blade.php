@extends('layouts.app')

@section('title', 'ChatBot View')

@section('content')

    <div class="flex flex-col items-center justify-center max-h-screen">

        <div
            class="flex flex-col w-full max-w-md h-150 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
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
            <div class="flex-1 overflow-y-auto bg-gray-100 p-6" id="chat-container">

                {{-- Mensaje del Bot --}}
                <div class="flex items-start gap-2.5 mb-4">
                    <div
                        class="flex flex-col w-full max-w-[320px] leading-1.5 p-4 bg-white rounded-e-xl rounded-es-xl border border-gray-200 shadow-sm">
                        <div class="flex items-center space-x-2 rtl:space-x-reverse mb-2">
                            <span class="text-sm font-semibold text-gray-900">Asistente virtual</span>
                            <span class="text-xs text-gray-500"></span>
                        </div>
                        <p class="text-sm text-gray-700">¡Hola! Soy tu asistente virtual del HNM. ¿En qué puedo ayudarte?
                        </p>
                    </div>
                </div>

                {{-- Bubble Templates --}}
                <template id="bubble-user-template">
                    <div class="flex items-start gap-2.5 mb-4 justify-end">
                        <div
                            class="chat-bubble opacity-0 translate-y-2 transition-all duration-200 ease-out
                            flex flex-col max-w-[320px] leading-1.5 p-4 bg-blue-100 rounded-s-xl rounded-ee-xl border border-blue-200 shadow-sm">
                            <div class="flex items-center mb-2">
                                <span class="text-sm font-semibold">Tú</span>
                                <span class="time text-xs text-gray-500 ml-2"></span>
                            </div>
                            <p class="message text-sm wrap-break-word whitespace-pre-wrap"></p>
                            <span class="text-xs text-gray-500 mt-1">Enviado</span>
                        </div>
                    </div>
                </template>

                <template id="bubble-bot-template">
                    <div class="flex items-start gap-2.5 mb-4">
                        <div
                            class="chat-bubble opacity-0 translate-y-2 transition-all duration-200 ease-out
                            flex flex-col w-full max-w-[320px] leading-1.5 p-4 bg-white rounded-e-xl rounded-es-xl border border-gray-200 shadow-sm">
                            <div class="flex items-center mb-2">
                                <span class="text-sm font-semibold">Asistente virtual</span>
                                <span class="time text-xs text-gray-500 ml-2"></span>
                            </div>
                            <p class="message text-sm wrap-break-word whitespace-pre-wrap"></p>
                            <span class="text-xs text-gray-500 mt-1">Entregado</span>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Input de Mensaje --}}
            <div class="bg-white border-t border-gray-200 px-6 py-4">
                <form id="chat-form" class="flex items-center gap-2">
                    @csrf

                    {{-- Input de Texto --}}
                    <div class="flex-1">
                        <label for="chat-input" class="sr-only">Escribe tu mensaje</label>
                        <div class="relative">
                            <input type="text" id ="chat-input" name="message"
                                class="block w-full p-4 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Escribe tu mensaje aquí..." required />
                        </div>
                    </div>

                    {{-- Botón de Enviar --}}
                    <button type="submit" id="sendButton"
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
    </div>

@endsection

@vite(['resources/js/chatbot.js'])
