<?php

namespace App\Entity;

use App\Repository\CartItemRepository;

#[ORM\Entity(repositoryClass: CartItemRepository::class)]
class CartItem
{

}