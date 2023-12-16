<?php

namespace App\Payment;

class PaypalHandler implements PaymentMethodInterface
{
    public function pay(): void
    {
        dd('paypal_handler');
    }

    public function supports(string $paymentMethod): bool
    {
        return $paymentMethod === 'paypal';
    }

}