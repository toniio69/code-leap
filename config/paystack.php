<?php

return [
    'publicKey' => env('PAYSTACK_PUBLIC_KEY', 'pk_test_17cb653b1b67e4802ad372ef3a625e6b5f1fa62d'),
    'secretKey' => env('PAYSTACK_SECRET_KEY'),
    'paymentUrl' => env('PAYSTACK_PAYMENT_URL', 'https://api.paystack.co'),
    'merchantEmail' => env('PAYSTACK_MERCHANT_EMAIL'),
];
