@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Processamento de Pagamento</h1>

            @if(session('error_message'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    {{ session('error_message') }}
                </div>
            @endif

            @error('payment_error')
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                {{ $message }}
            </div>
            @enderror

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 border border-red-400 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('create.payment') }}" method="POST" id="paymentForm" class="space-y-5">
                @csrf

                <div>
                    <label for="customer_name" class="block text-gray-700 font-medium">Nome</label>
                    <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}"
                           class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-300">
                    @error('customer_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="customer_email" class="block text-gray-700 font-medium">Email</label>
                    <input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email') }}"
                           class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-300"
                    >
                    @error('customer_email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="customer_cpf" class="block text-gray-700 font-medium">CPF</label>
                    <input type="text" name="customer_cpf" id="customer_cpf" value="{{ old('customer_cpf') }}"
                           class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-300"
                    >
                    @error('customer_cpf')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="amount" class="block text-gray-700 font-medium">Valor</label>
                    <x-value-payment name="amount" selected="{{ old('amount') ?? 5.10}}" />
                    @error('amount')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-5">
                    <label for="phone" class="block text-gray-700 font-medium">Telefone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                           class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-300"
                    >
                    @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-5">
                    <label for="postalCode" class="block text-gray-700 font-medium">CEP</label>
                    <input type="text" name="postalCode" id="postalCode" value="{{ old('postalCode') }}"
                           class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-300">
                    @error('postalCode')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-5">
                    <label for="addressNumber" class="block text-gray-700 font-medium">Número do endereço</label>
                    <input type="text" name="addressNumber" id="addressNumber" value="{{ old('addressNumber') }}"
                           class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-300">
                    @error('addressNumber')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="payment_method" class="block text-gray-700 font-medium">Método de Pagamento</label>
                    <x-payment-method name="payment_method" selected="{{ old('payment_method') ?? 'boleto' }}" />
                    @error('payment_method')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campos do Cartão de Crédito -->
                <div id="creditCardFields" class="hidden transition-opacity duration-300 ease-in-out">
                    <div>
                        <label for="card_number" class="block text-gray-700 font-medium">Número do Cartão</label>
                        <input type="text" name="card_number" id="card_number" value="{{ old('card_number') }}"
                               class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-300">
                        @error('card_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-5">
                        <div>
                            <label for="card_expiration" class="block text-gray-700 font-medium">Validade (MM/AAAA)</label>
                            <input type="text" name="card_expiration" id="card_expiration" value="{{ old('card_expiration') }}"
                                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-300">
                            @error('card_expiration')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="card_ccv" class="block text-gray-700 font-medium">CCV</label>
                            <input type="text" name="card_ccv" id="card_ccv" value="{{ old('card_ccv') }}"
                                   class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-300">
                            @error('card_ccv')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-all duration-300">
                    Finalizar Pagamento
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleCreditCardFields() {
            const creditCardFields = document.getElementById('creditCardFields');
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
            if (selectedMethod && selectedMethod.value === 'cartao') {
                creditCardFields.classList.remove('hidden');
                creditCardFields.classList.add('opacity-100');
            } else {
                creditCardFields.classList.add('hidden');
                creditCardFields.classList.remove('opacity-100');
            }
        }

        toggleCreditCardFields();

        $(document).ready(function(){
            $('#customer_cpf').mask('000.000.000-00', { reverse: false });
            $('#postalCode').mask('00000000');
            $('#card_number').mask('0000 0000 0000 0000');
            $("#card_expiration").mask("00/0000", { placeholder:"MM/YYYY" });
            $('#card_ccv').mask('000');
            var maskBehavior = function (val) {
                    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                },
                options = {onKeyPress: function(val, e, field, options) {
                        field.mask(maskBehavior.apply({}, arguments), options);
                    }
                };
            $('#phone').mask(maskBehavior, options);
        });
    </script>
@endsection
