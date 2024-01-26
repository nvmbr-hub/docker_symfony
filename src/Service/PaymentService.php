<?php

namespace App\Service;

use App\Entity\Product;
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
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function calculatePrice($data)
    {
//        $product = new Product();
//
//        // ... update the product data somehow (e.g. with a form) ...
//
//        $errors = $validator->validate($product);
//        if (count($errors) > 0) {
//            return new Response((string) $errors, 400);
//        }
        $product = $this->product;

        $productId = $data['product'];
        $taxNum = $data['taxNumber'];
        $couponCode = $data['couponCode'];
//        PaypalPaymentProcessor::pay();
//        StripePaymentProcessor::processPayment();

        return $data;
    }

    public function processPayment()
    {
        # Осуществить получение продукта и оплату
        $product = $this->product;


        return $product;
    }
//    public function processPurchase(array $requestData): void
//    {
//
//
//        $this->paypalProcessor->pay($totalPriceInCents);
//    }
}