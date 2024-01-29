<?php

namespace App\Service\Adapter;

use App\Service\PaymentProcessorInterface;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class StripePaymentAdapter implements PaymentProcessorInterface
{
    public function __construct(
        private readonly StripePaymentProcessor $stripeProcessor,
    ) {}

    public function pay(int $totalPriceInCents): bool
    {
        return $this->stripeProcessor->processPayment($totalPriceInCents);
    }

}