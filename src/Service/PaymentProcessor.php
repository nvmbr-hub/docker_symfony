<?php

namespace App\Service;

use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

class PaymentProcessor implements PaymentProcessorInterface
{
    public function __construct(
        private readonly PaypalPaymentProcessor  $paypalProcessor,
    ) {}

     public function pay(float|int $totalPriceInCents): bool
     {
           return $this->paypalProcessor->pay($totalPriceInCents) ?? true;
     }

}