<?php

namespace App\Service;

use PhpParser\Node\Expr\Cast\Int_;

interface SupportServiceInterface
{
    public function getCountryTax(string $taxNumber): int;
    public function getCoupon(string $productCoupon): array;
    public function getProductPrice(int $productId): int|float;

}