<?php

namespace App\Service\Adapter;

use App\Service\PaymentProcessorInterface;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

class PaypalPaymentAdapter implements PaymentProcessorInterface
{
    public function __construct(
        private readonly PaypalPaymentProcessor $paypalProcessor,
    ) {}

    public function pay(int $totalPriceInCents): bool
    {

        return $this->paypalProcessor->pay($totalPriceInCents) ?? true;
    }
}