<?php

namespace App\Service;

class supportService implements supportServiceInterface
{
    private array $taxMap = [
        'de' => 19,
        'it' => 22,
        'fr' => 20,
        'gr' => 24,
    ];

    public function getCountryTax(string $taxNumber): int
    {
        $countryCode = substr($taxNumber, 0, 2);
        $countryCode = strtolower($countryCode);

        return  $this->taxMap[$countryCode] ?? 0;

//        if (array_key_exists($countryCode, $this->taxMap)) {
//
//            return $this->taxMap[$countryCode];
//        } else {
//            return 0;
//        }
    }
    public function getCoupon(string $productCoupon): array
    {
        $couponType = substr($productCoupon, 0, 1);
        $couponType = strtolower($couponType);

        switch ($couponType) {
            case 'd':
                // Fixed discount
                $discountAmount = (int)substr($productCoupon, 1);

                return [
                    'discountAmount' => $discountAmount,
                    'fixed' => true,
                ];

            case 'p':
                // Percentage discount
                $discountAmount = (int)substr($productCoupon, 1);

                return [
                    'discountAmount' => $discountAmount,
                    'fixed' => false,
                ];

            default:

                return [
                    'error' => 0
                ];
        }
    }
}