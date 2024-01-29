<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class PaymentService
{
    public function __construct(
        private readonly EntityManagerInterface  $em,
        private readonly SupportServiceInterface $taxService,
    ) {}

    public function processCalculatePrice(array $requestDataParam): float
    {
        $productId = (int)$requestDataParam['product'];
        $productTax = (string)$requestDataParam['taxNumber'];
        $productCoupon = (string)$requestDataParam['couponCode'];

        $product = $this->em->find(Product::class, $productId);
        $productPrice = $product->getPrice();
        $coupon = $this->taxService->getCoupon($productCoupon);
        $tax = $this->taxService->getCountryTax($productTax);

        return $this->calculateTotalPrice($productPrice, $coupon, $tax);
    }

    public function calculateTotalPrice(int $productPrice, array $coupon, int $tax, $type = 'fixed', $discountAmount = 'discountAmount'): float
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