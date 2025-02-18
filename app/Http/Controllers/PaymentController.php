<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Services\AsaasService;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected AsaasService $asaasService;

    public function __construct(AsaasService $asaasService)
    {
        $this->asaasService = $asaasService;
    }

    public function createPayment(PaymentRequest $request)
    {
        // Obtém os dados validados do request
        $validated = $request->validated();

        try {
            $payment = $this->asaasService->createPayment($validated);

            if (!isset($payment->id)) {
                throw new \Exception('Resposta inesperada da API Asaas.');
            }

            return redirect()->route('payment.success', ['idPayment' => $payment->id])
                ->with('success_message', 'Pagamento realizado com sucesso!');
        } catch (RequestException $e) {
            Log::error("Erro de comunicação com a API Asaas: " . $e->getMessage());

            $response = $e->getResponse();
            $errorMessage = 'Erro de conexão com o serviço de pagamento. Tente novamente mais tarde.';
            if ($response) {
                $responseBody = json_decode($response->getBody()->getContents(), true);
                $errorMessage = $responseBody['errors'][0]['description'] ?? $errorMessage;
            }

            // Redireciona para a tela anterior com a mensagem de erro
            return redirect()->back()
                ->withInput()
                ->with('error_message', $errorMessage);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $responseBody = json_decode($response->getBody()->getContents(), true);

            $errorDescription = $responseBody['errors'][0]['description'] ?? 'Erro desconhecido';

            Log::error("Erro ao processar pagamento na API Asaas: " . $errorDescription, ['dados' => $validated]);

            return redirect()->back()
                ->withInput()
                ->withErrors(['payment_error' => $errorDescription]);
        } catch (\Exception $e) {
            Log::error("Erro ao processar pagamento: " . $e->getMessage(), ['dados' => $validated]);

            return redirect()->route('home')
                ->with('error_message', 'Houve um erro ao processar o pagamento. Por favor, tente novamente.');
        }
    }

    public function paymentSuccess($idPayment = null)
    {
        if($idPayment){
            $payment = Payment::findOrFail($idPayment);
        }
        return view('payment_success', compact('payment'));
    }
}
