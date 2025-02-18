<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'payment_method'   => 'required|in:boleto,cartao,pix',
            'amount'           => 'required|numeric|min:5.00',
            'customer_name'    => 'required|string|max:255',
            'customer_email'   => 'required|email|max:255',
            'customer_cpf'     => 'required|cpf',
            'phone'            => 'required|celular_com_ddd',
            'postalCode'       => 'required',
            'addressNumber'       => 'required',

            // Dados específicos para cartão de crédito
            'card_number'      => 'required_if:payment_method,cartao|nullable|string',
            'card_expiration'  => 'required_if:payment_method,cartao|nullable|string',
            'card_ccv'         => 'required_if:payment_method,cartao|nullable|string',
        ];
    }

    public function messages() {

        return [
            'payment_method.required' => 'O campo Método de pagamento é obrigatório!',

            'amount.required' => 'O campo Valor é obrigatório!',
            'amount.numeric' => 'O valor do campo Valor deve ser numérico!',
            'amount.min' => 'O valor do campo Valor deve ser igual ou maior a 5,00!',

            'customer_name.required' => 'O campo Nome é obrigatório!',
            'customer_name.string' => 'O campo Nome é deve ser uma string!',
            'customer_name.max' => 'O campo Nome deve ter no máximo 255 caracteres!',

            'customer_email.required' => 'O campo E-mail é obrigatório!',
            'customer_email.string' => 'O campo E-mail é deve ser uma string!',
            'customer_email.max' => 'O campo E-mail deve ter no máximo 255 caracteres!',

            'customer_cpf.required' => 'O campo CPF é obrigatório!',
            'customer_cpf.cpf' => 'O campo  CPF não é um CPF válido!',

            'phone.required' => 'O campo Telefone é obrigatório!',
            'phone.celular_com_ddd' => 'O campo Telefone não é um número válido!',

            'postalCode.required' => 'O campo CEP é obrigatório!',
            'addressNumber.required' => 'O campo Número do endereço é obrigatório!',

            'card_number.required_if' => 'O campo Número do Cartão é obrigatório!',
            'card_expiration.required_if' => 'O campo Validade é obrigatório!',
            'card_ccv.required_if' => 'O campo CCV é obrigatório!',
        ];
    }
}
