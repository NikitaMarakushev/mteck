<?php

namespace App\Entity;

use App\Repository\ConfirmationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConfirmationRepository::class)]
class Confirmation
{

}