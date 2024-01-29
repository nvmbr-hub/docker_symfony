<?php

namespace App\Service;

interface PaymentProcessorInterface
{
    public function pay(int $totalPriceInCents): bool;

}