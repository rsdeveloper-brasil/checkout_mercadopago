<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Exceptions\PaymentException;
use App\Models\Order;
use Database\Seeders\OrderSeeder;
use Exception;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Common\RequestOptions;
use MercadoPago\Client\Order\OrderClient;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Exceptions\InvalidArgumentException;
use MercadoPago\Exceptions\MPApiException;

class CheckoutService
{
    /**
     * php artisan config:cache
     * php artisan config:clear
     *
     * sail composer remove vendor/mercadopago
     * https://www.mercadopago.com.br/developers/pt/docs/sdks-library/server-side
     * https://github.com/mercadopago/sdk-php
     * sail composer require "mercadopago/dx-php:2.5.5" (versao compativel com a aula)
     * sail composer require leonardcodep/mercadopago-sdk-php
     * @throws InvalidArgumentException
     */

    public function __construct()
    {
        //SDK::setAccessToken(config('payment.mercadopago.access_token'));
        MercadoPagoConfig::setAccessToken(config('payment.mercadopago.access_token'));
        //MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);

        //https://www.mercadopago.com.br/developers/pt/reference/payments/_payments/post
        //https://www.mercadopago.com.br/developers/pt/docs/checkout-api/integration-configuration/card/integrate-via-cardform
    }

    public function loadCart(): array
    {
        $cart = Order::with('skus.product', 'skus.features')
            ->where('status', OrderStatusEnum::CART)
            ->where(function ($query) {
                $query->where('session_id', session()->getId());
                if (auth()->check()) {
                    $query->orWhere('user_id', auth()->user()->id);
                }
            })->first();

        //Apenas em hambiente de produção
        if (!$cart && config('app.env') == 'local') {
            $seed = new OrderSeeder();
            $seed->run(session()->getId());
            return $this->loadCart();
        }

        return $cart->toArray();
    }

    /**
     * @throws MPApiException
     * @throws \Throwable
     */
    public function creditCardPayment($data)
    {
        /** https://www.mercadopago.com.br/developers/pt/reference/orders/online-payments/create/post
         * https://github.com/mercadopago/sdk-php/blob/HEAD/MIGRATION_GUIDE.md
         * https://github.com/mercadopago/sdk-php/tree/master-v2 */

        $client = new OrderClient();
        //$client = new PaymentClient();

        $request = [
            "type" => "online",
            "processing_mode" => "automatic",
            "total_amount" => (string)$data['transaction_amount'],
            "external_reference" => (string)$data['issuer_id'],
            "capture_mode" => "automatic_async",
            "description" => $data['description'],
            "payer" => [
                "email" => $data['payer']['email'],
            ],
            "transactions" => [
                "payments" => [
                    [
                        "amount" => (string)$data['transaction_amount'],
                        "payment_method" => [
                            "id" => $data['payment_method_id'],
                            "type" => "credit_card",
                            "token" => $data['token'],
                            "installments" => (int)$data['installments'],
                            "statement_descriptor" => "RS Developer",
                        ]
                    ]
                ]
            ],
        ];

        $request_options = new RequestOptions();
        $request_options->setCustomHeaders(["X-Idempotency-Key:" . uniqid('mp_', true)]);

        $payment = $client->create($request, $request_options);

        throw_if(
            !$payment->id || $payment->status === 'rejected',
            PaymentException::class,
            $payment?->error?->message ?? "Verifique os dados do cartão"
        );

        return $payment;

        /** SDK ANTIGA, NÃO MAIS FUNCIONA */
//        $payment = new Payment();
//        $payment->transaction_amount = (float)$data['transaction_amount'];
//        $payment->token = $data['token'];
//        $payment->description = $data['description'];
//        $payment->installments = (int)$data['installments'];
//        $payment->payment_method_id = $data['payment_method_id'];
//        $payment->issuer_id = (int)$data['issuer_id'];
//
//        $payer = new Payer();
//        $payer->email = $data['payer']['email'];
//        $payer->identification = array([
//            "type" => $data['payer']['identification']['type'],
//            "number" => $data['payer']['identification']['number']
//        ]);
//
//        $payment->payer = $payer;
//        $payment->save();
//        dd($payment);
    }
}
