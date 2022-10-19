<?php

declare(strict_types=1);

namespace App\User\Domain\Entity;

class User
{
    private int $id;

    private string $name;

    private string $email;

    private string $password;

    public function __construct(
        string $name,
        string $email,
        string $password
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function fillName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getemail(): string
    {
        return $this->email;
    }

    public function fillemail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function fillPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}