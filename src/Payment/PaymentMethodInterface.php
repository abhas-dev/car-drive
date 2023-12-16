<?php

namespace App\Payment;

interface PaymentMethodInterface
{
    public function pay(): void;

    public function supports(string $paymentMethod): bool;
}