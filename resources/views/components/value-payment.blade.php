@props(['name' => 'amount', 'options' => [5.10, 10, 15.75, 20, 30.50], 'selected' => 5.10])

<div class="flex space-x-2 mt-2">
    @foreach ($options as $value)
        <label class="cursor-pointer rounded-lg flex items-center border rounded-lg cursor-pointer w-1/5 h-10 overflow-hidden
                    transition-all duration-200">
            <input type="radio"
                   name="{{ $name }}"
                   value="{{ $value }}"
                   class="hidden peer"
                {{ $selected == $value ? 'checked' : '' }}>
            <div class="w-full text-center h-16 flex justify-center items-center peer-checked:bg-blue-500 peer-checked:text-white peer-checked:border-blue-500 transition-all  duration-200">
                R$ {{ number_format($value, 2, ',', '.') }}
            </div>
        </label>
    @endforeach
</div>
