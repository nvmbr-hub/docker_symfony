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
        private readonly EntityManagerInterface $em,
        private readonly CountryTaxInterface    $taxService,
        PaypalPaymentProcessor $paypalProcessor,
        StripePaymentProcessor $stripeProcessor,

    )
    {
        $this->paypalProcessor = $paypalProcessor;
        $this->stripeProcessor = $stripeProcessor;
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

        return $this->getTotalPrice($productPrice, $coupon, $tax);
    }

    public function getTotalPrice(int $productPrice, array $coupon, int $tax, $type = 'fixed', $discountAmount = 'discountAmount'): float|int
    {


        if (!$coupon[$type]) {
            $discountAmount = ($coupon[$discountAmount] / 100) * $productPrice;

        }
        $productPrice = $productPrice + (($tax / 100) * $productPrice);

        return $productPrice - $discountAmount;
    }

    public function processPurchase(array $requestDataParam): bool
    {
        $totalPriceInCents = $this->calculatePrice($requestDataParam);

        $paymentName = $requestDataParam['paymentProcessor'];
        if ($paymentName == 'paypal') {
            return $this->paypalProcessor->pay($totalPriceInCents);
        }
        return $this->stripeProcessor->processPayment($totalPriceInCents);

    }

}