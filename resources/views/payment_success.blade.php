@extends('layouts.app')

@section('title', 'Pagamento Concluído')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen bg-green-100 px-4">
        <div class="bg-white p-8 rounded-2xl shadow-xl max-w-lg w-full text-center">

            <h2 class="text-3xl font-bold text-green-600 mt-4">Pagamento Confirmado!</h2>
            <p class="text-gray-600 mt-2">Seu pagamento foi processado com sucesso.</p>

            @if($payment->payment_method === 'boleto')
                <p class="mt-4 mb-4">Seu boleto está disponível:</p>
                <a href="{{ $payment->boleto_url }}" target="_blank"
                   class="px-6 py-3 mb-4 bg-green-400 text-white rounded-lg hover:bg-green-500 transition shadow-md">
                    Baixar Boleto
                </a>
            @endif

            @if($payment->payment_method === 'pix')
                <p class="mt-4 mb-4">Escaneie o QR Code ou copie o código abaixo:</p>
                <div class="flex justify-center mb-4">
                    <img class="max-w-lg h-40 w-40" src="data:image/png;base64,{{ $payment->pix_qrcode }}" alt="QR Code Pix" />
                </div>
                <div class="relative">
                    <input
                        id="pixInput"
                        type="text"
                        placeholder="Insira o código PIX"
                        value="{{ $payment->pix_copy }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                    <button
                        id="copyButton"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors"
                    >
                        Copiar
                    </button>
                </div>

                <p class="mt-4">Data de validade deste Pix: <strong>{{ $payment->expirationDatePix->format('d/m/Y H:i') }}</strong></p>
            @endif

            @if($payment->payment_method === 'cartao')
                <p class="mt-4 mb-4">Pagamento realizado com sucesso!</p>
            @endif

            <div class="flex my-5 h-10"></div>

            <div class="mt-10">
                <a href="{{ route('home') }}"
                   class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-md">
                    Voltar para Home
                </a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('copyButton').addEventListener('click', () => {
            const input = document.getElementById('pixInput');
            input.select();
            document.execCommand('copy');
            alert('Texto copiado para a área de transferência!');
        });
    </script>
@endsection
