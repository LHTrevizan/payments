<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220402163146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shopkeeper (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, cnpj VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE standard_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, cpf VARCHAR(11) NOT NULL)');
        $this->addSql('CREATE TABLE transactions (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, bank_balance VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, user_type VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE shopkeeper');
        $this->addSql('DROP TABLE standard_user');
        $this->addSql('DROP TABLE transactions');
        $this->addSql('DROP TABLE user');
    }
}
