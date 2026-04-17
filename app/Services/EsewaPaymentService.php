<?php

namespace App\Services;

// Simple eSewa payment service for Sanskriti Bazar
class EsewaPaymentService
{
    // eSewa configuration from .env file
    private $merchantCode;
    private $successUrl;
    private $failureUrl;
    private $environment;

    // Constructor - runs when class is created
    public function __construct()
    {
        // Get eSewa settings from .env file
        $this->merchantCode = env('ESEWA_MERCHANT_CODE', 'EPAYTEST');
        $this->successUrl = env('ESEWA_SUCCESS_URL');
        $this->failureUrl = env('ESEWA_FAILURE_URL');
        $this->environment = env('ESEWA_ENV', 'test');
    }

    // Generate eSewa payment URL and parameters
    public function initiatePayment($amount, $taxAmount, $totalAmount, $transactionUuid)
    {
        // eSewa test URL for payments - using the working test environment
        $paymentUrl = $this->environment === 'live' 
            ? 'https://esewa.com.np/epay/main' 
            : 'https://uat.esewa.com.np/epay/main';

        // Parameters required by eSewa
        $params = [
            'amt' => $amount,                    // Base amount
            'pdc' => 0,                         // Product delivery charge
            'psc' => 0,                         // Product service charge  
            'txAmt' => $taxAmount,              // Tax amount
            'tAmt' => $totalAmount,             // Total amount
            'pid' => $transactionUuid,          // Product ID (our transaction ID)
            'scd' => $this->merchantCode,       // Service code (merchant code)
            'su' => $this->successUrl,          // Success URL
            'fu' => $this->failureUrl,          // Failure URL
        ];

        // Return URL and parameters for form submission
        return [
            'url' => $paymentUrl,
            'params' => $params
        ];
    }

    // Verify payment with eSewa after success
    public function verifyPayment($transactionUuid, $refId, $amount)
    {
        // eSewa verification URL
        $verifyUrl = $this->environment === 'live'
            ? 'https://esewa.com.np/epay/transrec'
            : 'https://uat.esewa.com.np/epay/transrec';

        // Parameters for verification
        $params = [
            'amt' => $amount,
            'rid' => $refId,
            'pid' => $transactionUuid,
            'scd' => $this->merchantCode
        ];

        // Make HTTP request to verify payment
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

        // Get response from eSewa
        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // eSewa returns "Success" for successful verification
        return $httpCode === 200 && strpos($response, 'Success') !== false;
    }
}