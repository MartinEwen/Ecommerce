<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109081747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pictures (id INT AUTO_INCREMENT NOT NULL, name_picture VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pictures_products (pictures_id INT NOT NULL, products_id INT NOT NULL, INDEX IDX_C1C570DABC415685 (pictures_id), INDEX IDX_C1C570DA6C8A81A9 (products_id), PRIMARY KEY(pictures_id, products_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pictures_products ADD CONSTRAINT FK_C1C570DABC415685 FOREIGN KEY (pictures_id) REFERENCES pictures (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pictures_products ADD CONSTRAINT FK_C1C570DA6C8A81A9 FOREIGN KEY (products_id) REFERENCES products (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pictures_products DROP FOREIGN KEY FK_C1C570DABC415685');
        $this->addSql('ALTER TABLE pictures_products DROP FOREIGN KEY FK_C1C570DA6C8A81A9');
        $this->addSql('DROP TABLE pictures');
        $this->addSql('DROP TABLE pictures_products');
    }
}
