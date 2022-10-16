<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221015210322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE public.user (
            id serial PRIMARY KEY,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            roles json NOT NULL,
            password TEXT NOT NULL,
            is_verified BOOLEAN NOT NULL 
        )");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE public.user");
    }
}
