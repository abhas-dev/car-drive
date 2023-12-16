<?php

namespace App\Payment;

class PaymentMethodRegistry
{
    public function __construct(private iterable $paymentHandlers)
    {}

    public function payWith(string $paymentMethod): void
    {
        foreach ($this->paymentHandlers as $handler) {
            if ($handler->supports($paymentMethod)) {
                $handler->pay();
            }
        }
    }

}