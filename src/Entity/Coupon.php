<?php

namespace App\Entity;

use App\Repository\CouponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $percent = null;

    #[ORM\Column(length: 255)]
    private ?string $coupon_name = null;

    #[ORM\Column(nullable: true)]
    private ?float $discount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPercent(): ?bool
    {
        return $this->percent;
    }

    public function setPercent(bool $percent): static
    {
        $this->percent = $percent;

        return $this;
    }

    public function getCouponName(): ?string
    {
        return $this->coupon_name;
    }

    public function setCouponName(string $coupon_name): static
    {
        $this->coupon_name = $coupon_name;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(?float $discount): static
    {
        $this->discount = $discount;

        return $this;
    }
}
