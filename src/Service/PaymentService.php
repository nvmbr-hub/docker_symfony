<?php

namespace App\Service;



class PaymentService
{
    public function __construct(
        private SupportService $supportService,

    ) {}

    public function processCalculatePrice(array $requestDataParam): float
    {
        $productId = (int)$requestDataParam['product'];
        $productTax = (string)$requestDataParam['taxNumber'];
        $productCoupon = (string)$requestDataParam['couponCode'];

        $productPrice = $this->supportService->getProductPrice($productId);

        $coupon = $this->supportService->getCoupon($productCoupon);

        $tax = $this->supportService->getCountryTax($productTax);

        return $this->calculateTotalPrice($productPrice, $coupon, $tax);
    }

    public function calculateTotalPrice(int $productPrice, array $coupon, int $tax, $type = 'percent', $discountAmount = 'discount'): float
    {
        $discount = $coupon[$discountAmount];
        if (!$coupon[$type]) {
            $discount = ($discount / 100) * $productPrice;
        }
        $productPrice = $productPrice - $discount;

        return $productPrice + (($tax / 100) * $productPrice);
    }

    public function processPurchase(array $requestDataParam): bool
    {
        $totalPriceInCents = $this->processCalculatePrice($requestDataParam);
        $paymentType = $requestDataParam['paymentProcessor'];

        $paymentProcessorFactory = new PaymentProcessorFactory();
        $paymentProcessor = $paymentProcessorFactory->payment($paymentType);

        return $paymentProcessor->pay($totalPriceInCents);
    }

}