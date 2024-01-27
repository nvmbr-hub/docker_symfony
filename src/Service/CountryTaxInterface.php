<?php

namespace App\Service;

use PhpParser\Node\Expr\Cast\Int_;

interface CountryTaxInterface
{
    public function getCountryTax(string $taxNumber): int;
    public function getCoupon(string $productCoupon): array;

}