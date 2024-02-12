<?php

namespace App\Service;

use App\Entity\Coupon;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class SupportService implements SupportServiceInterface
{
    public function __construct(
        private EntityManagerInterface  $em,
    ) {}
    private array $taxMap = [
        'de' => 19,
        'it' => 22,
        'fr' => 20,
        'gr' => 24,
    ];

    public function getProductPrice(int $productId): int|float
    {
        $product =$this->em->find(Product::class, $productId);

        return $product->getPrice();
    }

    public function getCountryTax(string $taxNumber): int
    {
        $countryCode = substr($taxNumber, 0, 2);
        $countryCode = strtolower($countryCode);

        return  $this->taxMap[$countryCode] ?? 0;
    }

    public function getCoupon(string $productCoupon): array
    {
        $couponData = $this->em
            ->getRepository(Coupon::class)
            ->findOneBy(['coupon_name' => $productCoupon]);

        if (!$couponData instanceof Coupon) {
            return ['error' => 'Coupon not found'];
        }

        return [
            'discount' => $couponData->getDiscount(),
            'percent' => $couponData->getPercent(),
        ];
    }
}