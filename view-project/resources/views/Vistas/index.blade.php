@extends('layouts.app')

@section('title', 'Index Probe')

@section('content')
<div class="flex flex-col min-h-screen">
    <div data-dial-init class="fixed bottom-20 right-10 group">
        <button type="button" data-popover-target="popover-chat-info"
            aria-controls="speed-dial-menu-dropdown-alternative" aria-expanded="false"
            class="flex items-center justify-center ml-auto text-white bg-brand rounded-full w-14 h-14 hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium focus:outline-none">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28" />
            </svg>
            <span class="sr-only">Open Chat Action</span>
        </button>
    </div>


    <div data-popover id="popover-chat-info" role="tooltip"
        class="absolute z-10  invisible inline-block w-64 text-sm text-body transition-opacity duration-300 bg-neutral-primary-soft border border-default rounded-base shadow-xs opacity-0">
        <div class="p-3">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm font-semibold text-heading">
                Asistente Inteligente
            </p>
                <div>
                    <button type="button"
                        class="text-white bg-brand hover:bg-brand-strong box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded text-xs px-3 py-1.5 focus:outline-none">Mensajear</button>
                </div>
            </div>
            <p class="mb-4 text-sm">Puedes realizar preguntas frecuentes y consulta de información.</p>
        </div>
        <div data-popper-arrow></div>
    </div>

</div>

@endsection