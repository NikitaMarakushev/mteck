<?php

namespace App\Entity;

use App\Repository\ModifPasswordRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModifPasswordRepository::class)]
class ModifPassword
{

}