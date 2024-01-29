<?php

namespace App\Service;

use App\Service\Adapter\PaypalPaymentAdapter;
use App\Service\Adapter\StripePaymentAdapter;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class PaymentProcessorFactory
{
    public function payment(string $paymentName): PaypalPaymentAdapter|StripePaymentAdapter
    {
        return match ($paymentName) {
            'paypal' => new PaypalPaymentAdapter(new PaypalPaymentProcessor()),
            'stripe' => new StripePaymentAdapter(new StripePaymentProcessor()),
            default => throw new \InvalidArgumentException("Unsupported payment processor: $paymentName"),
        };
    }



}