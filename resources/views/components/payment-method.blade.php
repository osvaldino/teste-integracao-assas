@props(['name' => 'payment_method', 'selected' => 'boleto'])

<div class="flex space-x-2 mt-2">
    @foreach (['boleto' => 'Boleto', 'pix' => 'Pix', 'cartao' => 'Cartão de Crédito'] as $value => $label)
        <label class="cursor-pointer rounded-lg flex items-center border rounded-lg cursor-pointer w-1/3 h-10 overflow-hidden
                    transition-all duration-200">
            <input type="radio"
                   name="{{ $name }}"
                   value="{{ $value }}"
                   class="hidden peer"
                   {{ $selected == $value ? 'checked' : '' }}
                   onchange="toggleCreditCardFields()">
            <div class="w-full text-center h-16 flex justify-center items-center peer-checked:bg-blue-500 peer-checked:text-white peer-checked:border-blue-500 transition-all duration-200">
                {{ $label }}
            </div>
        </label>
    @endforeach
</div>
