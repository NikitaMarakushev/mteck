<?php

namespace App\Entity;

use App\Repository\VariationOptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VariationOptionRepository::class)]
class VariationOption
{

}