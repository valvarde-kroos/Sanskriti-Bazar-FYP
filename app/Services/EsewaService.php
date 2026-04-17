<?php

namespace App\Services;

class EsewaService
{
    private $merchantId;
    private $secretKey;
    private $successUrl;
    private $failureUrl;
    private $environment;

    public function __construct()
    {
        $this->merchantId = env('ESEWA_MERCHANT_ID', 'EPAYTEST');
        $this->secretKey = env('ESEWA_SECRET_KEY', '8gBm/:&EnhH.1/q');
        $this->successUrl = env('ESEWA_SUCCESS_URL');
        $this->failureUrl = env('ESEWA_FAILURE_URL');
        $this->environment = env('ESEWA_ENVIRONMENT', 'test');
    }

    public function getPaymentUrl($orderId, $amount, $productName = 'Sanskriti Bazar Order')
    {
        $paymentUrl = $this->environment === 'live' 
            ? 'https://esewa.com.np/epay/main' 
            : 'https://uat.esewa.com.np/epay/main';

        $params = [
            'amt' => $amount,
            'pdc' => 0, // Product delivery charge
            'psc' => 0, // Product service charge
            'txAmt' => 0, // Tax amount
            'tAmt' => $amount, // Total amount
            'pid' => $orderId, // Product ID (Order ID)
            'scd' => $this->merchantId, // Service code (Merchant ID)
            'su' => $this->successUrl, // Success URL
            'fu' => $this->failureUrl, // Failure URL
        ];

        return [
            'url' => $paymentUrl,
            'params' => $params
        ];
    }

    public function verifyPayment($orderId, $amount, $refId)
    {
        $verifyUrl = $this->environment === 'live'
            ? 'https://esewa.com.np/epay/transrec'
            : 'https://uat.esewa.com.np/epay/transrec';

        $params = [
            'amt' => $amount,
            'rid' => $refId,
            'pid' => $orderId,
            'scd' => $this->merchantId
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $verifyUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded'
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // eSewa returns "Success" in response body for successful verification
        return $httpCode === 200 && strpos($response, 'Success') !== false;
    }

    public function generateSignature($orderId, $amount)
    {
        $message = "total_amount={$amount},transaction_uuid={$orderId},product_code={$this->merchantId}";
        return base64_encode(hash_hmac('sha256', $message, $this->secretKey, true));
    }
}