<?php

namespace App\Service;

use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class PaymentService
{
//    private PaypalPaymentProcessor $paypalProcessor;
//    private StripePaymentProcessor $stripeProcessor;
//
//    public function __construct(PaypalPaymentProcessor $paypalProcessor, StripePaymentProcessor $stripeProcessor)
//    {
//        $this->paypalProcessor = $paypalProcessor;
//        $this->stripeProcessor = $stripeProcessor;
//    }

    public function calculatePrice($data)
    {
//        foreach ($data as $key => $value) {
//
//        }

//        PaypalPaymentProcessor::pay();
//        StripePaymentProcessor::processPayment();

        return $data;
    }

//    public function processPurchase(array $requestData): void
//    {
//
//
//        $this->paypalProcessor->pay($totalPriceInCents);
//    }
}