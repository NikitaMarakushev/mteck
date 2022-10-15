<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221014172603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE public.product (
            id serial PRIMARY KEY,
            name TEXT NOT NULL,
            description TEXT NOT NULL,
            price FLOAT NOT NULL,
            image TEXT NOT NULL
        )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE public.product");
    }
}
