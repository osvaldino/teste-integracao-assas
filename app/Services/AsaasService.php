<?php

namespace App\Services;

use App\Models\Payment;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;

class AsaasService
{
    protected $client;
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.asaas.base_url');
        $this->apiKey = config('services.asaas.api_key');
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'access_token' => $this->apiKey,
                'Content-Type' => 'application/json',
                'User-Agent' => 'Integração teste-perfectpay',
            ],
        ]);
    }

    public function createOrGetCustomer($name, $email, $cpfCnpj)
    {
        try {
            // Verificar se o cliente já existe pelo CPF ou email
            $response = $this->client->get('customers', [
                'query' => [
                    'email' => $email,
                    'cpfCnpj' => $cpfCnpj,
                ]
            ]);

            $customer = json_decode($response->getBody()->getContents(), true);

            // Se o cliente já existir, retornar o ID
            if (!empty($customer['data'])) {
                return $customer['data'][0]['id'];
            }

            // Caso o cliente não exista, cria um novo
            $response = $this->client->post('customers', [
                'json' => [
                    'name' => $name,
                    'email' => $email,
                    'cpfCnpj' => $cpfCnpj,
                ]
            ]);

            $customer = json_decode($response->getBody()->getContents(), true);

            if (isset($customer['id'])) {
                return $customer['id'];
            }

            throw new \Exception('Falha ao criar o cliente.');
        } catch (RequestException $e) {
            // Captura de exceções relacionadas a erros de requisição
            $response = $e->getResponse();
            $errorData = json_decode($response->getBody(), true);
            $errorDescription = $errorData['errors'][0]['description'] ?? 'Erro na requisição à API.';
            throw new \Exception($errorDescription);
        } catch (ClientException $e) {
            // Captura erros 4xx (cliente). 4xx
            $response = $e->getResponse();
            $errorData = json_decode($response->getBody(), true);
            $errorDescription = $errorData['errors'][0]['description'] ?? 'Erro do lado do cliente na API.';
            throw new \Exception($errorDescription);
        } catch (ServerException $e) {
            // Captura erros 5xx (servidor). 5xx
            $response = $e->getResponse();
            $errorData = json_decode($response->getBody(), true);
            $errorDescription = $errorData['errors'][0]['description'] ?? 'Erro no servidor da API.';
            throw new \Exception($errorDescription);
        } catch (\Exception $e) {
            // Captura erros gerais e lança uma exceção
            throw new \Exception('Erro ao criar ou buscar o cliente: ' . $e->getMessage());
        }
    }


    public function createPayment(array $requestData)
    {
        // Mapeia o metodo de pagamento para o billingType do Asaas
        $billingType = $this->mapPaymentMethod($requestData['payment_method']);

        $customerId = $this->createOrGetCustomer(
            $requestData['customer_name'],
            $requestData['customer_email'],
            $requestData['customer_cpf'],
        );

        // Monta o payload
        $payload = $this->preparePayload($customerId, $billingType, $requestData);

        // Envia a requisição para a API do Asaas
        $response = $this->client->post('payments', ['json' => $payload]);
        $asaasResponse = json_decode($response->getBody()->getContents(), true);

        // Busca dados do QR Code se o pagamnento foi via PIX
        if($requestData['payment_method'] === 'pix'){
            $responseQRCode = $this->client->get("payments/{$asaasResponse['id']}/pixQrCode");
            $qrCode = json_decode($responseQRCode->getBody()->getContents(), true);
        }

        // Persiste o pagamento no banco de dados
        $payment = Payment::create([
            'asaas_id'          => $asaasResponse['id'] ?? null,
            'payment_method'    => $requestData['payment_method'],
            'amount'            => $requestData['amount'],
            'status'            => $asaasResponse['status'] ?? 'PENDING',
            'boleto_url'        => $asaasResponse['bankSlipUrl'] ?? null,
            'pix_qrcode'        => $qrCode['encodedImage'] ?? null,
            'pix_copy'          => $qrCode['payload'] ?? null,
            'expirationDatePix' => $qrCode['expirationDate'] ?? null,
            'customer_id'       => $customerId,
            'customer_name'     => $requestData['customer_name'],
            'customer_email'    => $requestData['customer_email'],
            'customer_cpf'      => $requestData['customer_cpf'],
        ]);

        return $payment;
    }

    private function mapPaymentMethod(string $method): string
    {
        return match ($method) {
            'boleto' => 'BOLETO',
            'cartao' => 'CREDIT_CARD',
            'pix'    => 'PIX',
            default  => throw new \Exception("Método de pagamento inválido."),
        };
    }

    private function preparePayload($customerId, $billingType, $requestData)
    {
        $payload = [
            'customer'    => $customerId,
            'billingType' => $billingType,
            'value'       => $requestData['amount'],
            'dueDate'     => now()->addDays(5)->toDateString(),
        ];

        if ($requestData['payment_method'] === 'cartao') {
            $payload['creditCard'] = [
                'holderName'            => $requestData['customer_name'],
                'number'          => $requestData['card_number'],
                'expiryMonth'     => substr($requestData['card_expiration'], 0, 2),
                'expiryYear'      => substr($requestData['card_expiration'], -4),
                'ccv'             => $requestData['card_ccv'],
                'cpfCnpj'         => $requestData['customer_cpf'],
            ];

            $payload['creditCardHolderInfo'] = [
                'name'           => $requestData['customer_name'],
                'email'          => $requestData['customer_email'],
                'cpfCnpj'        => $requestData['customer_cpf'],
                'phone'          => $requestData['phone'],
                'postalCode'     => $requestData['postalCode'],
                'addressNumber'  => $requestData['addressNumber'],
            ];

            $payment['callback'] = [
                'successUrl' => route("payment.success"),
            ];
        }

        return $payload;
    }
}
