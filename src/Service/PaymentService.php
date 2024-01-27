<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;
use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class PaymentService
{

    public function __construct(
        private readonly EntityManagerInterface  $em,
        private readonly supportServiceInterface $taxService,
        private readonly PaypalPaymentProcessor  $paypalProcessor,
        private readonly StripePaymentProcessor  $stripeProcessor,

    )
    {

    }

    public function calculatePrice(array $requestDataParam): float|array|int
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

    public function processPurchase(array $requestDataParam): bool|null
    {
        $totalPriceInCents = $this->calculatePrice($requestDataParam);
        $paymentName = $requestDataParam['paymentProcessor'];
        // TODO: добавления новых PaymentProcessors

        if ($paymentName === 'paypal') {
            return $this->paypalProcessor->pay($totalPriceInCents);
        }
        return $this->stripeProcessor->processPayment($totalPriceInCents);

    }

}