<?php

namespace App\Payment;

class StripeHandler implements PaymentMethodInterface
{
    public function pay(): void
    {
        dd('stripe_handler');
    }

    public function supports(string $paymentMethod): bool
    {
        return $paymentMethod === 'stripe';
    }

}