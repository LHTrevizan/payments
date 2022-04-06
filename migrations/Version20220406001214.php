<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220406001214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transactions (id INT AUTO_INCREMENT NOT NULL, payer_id INT DEFAULT NULL, payee_id INT DEFAULT NULL, value DOUBLE PRECISION NOT NULL, transaction_type VARCHAR(255) NOT NULL, INDEX IDX_EAA81A4CC17AD9A9 (payer_id), INDEX IDX_EAA81A4CCB4B68F (payee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, user_type_id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(50) NOT NULL, password VARCHAR(15) NOT NULL, bank_balance DOUBLE PRECISION DEFAULT \'0.0\', updated_at DATETIME NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, cnpj VARCHAR(15) DEFAULT NULL, cpf VARCHAR(15) DEFAULT NULL, INDEX IDX_8D93D6499D419299 (user_type_id), UNIQUE INDEX UNIQ_8D93D649A899537A (CPF), UNIQUE INDEX UNIQ_8D93D649FE537DDF (CNPJ), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CC17AD9A9 FOREIGN KEY (payer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4CCB4B68F FOREIGN KEY (payee_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6499D419299 FOREIGN KEY (user_type_id) REFERENCES user_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CC17AD9A9');
        $this->addSql('ALTER TABLE transactions DROP FOREIGN KEY FK_EAA81A4CCB4B68F');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6499D419299');
        $this->addSql('DROP TABLE transactions');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_type');
    }
}
