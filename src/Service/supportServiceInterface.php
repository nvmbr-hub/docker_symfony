<?php

namespace App\Service;

use PhpParser\Node\Expr\Cast\Int_;

interface supportServiceInterface
{
    public function getCountryTax(string $taxNumber): int;
    public function getCoupon(string $productCoupon): array;

}