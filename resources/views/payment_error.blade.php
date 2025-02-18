@extends('layouts.app')

@section('title', 'Erro no Pagamento')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen bg-red-100 px-4">
        <div class="bg-white p-8 rounded-2xl shadow-xl max-w-lg w-full text-center">
            <svg class="w-20 h-20 text-red-500 mx-auto" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
            </svg>

            <h2 class="text-3xl font-bold text-red-600 mt-4">Erro no Pagamento</h2>
            <p class="text-gray-600 mt-2">Infelizmente, houve um problema ao processar o seu pagamento.</p>

            @if(session('error_message'))
                <div class="mt-4 p-4 bg-red-200 text-red-800 rounded-md border-l-4 border-red-600">
                    <strong>Detalhes:</strong> {{ session('error_message') }}
                </div>
            @endif

            <div class="mt-6 flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('home') }}"
                   class="px-6 py-3 bg-gray-400 text-gray-800 rounded-lg hover:bg-gray-500 transition shadow-md">
                    🏠 Voltar para Home
                </a>
            </div>
        </div>
    </div>
@endsection
