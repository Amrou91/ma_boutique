<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210823212208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A77E5854A');
        $this->addSql('DROP INDEX IDX_B3BA5A5A77E5854A ON products');
        $this->addSql('ALTER TABLE products CHANGE mode_id fashion_id INT NOT NULL');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A988D3F4B FOREIGN KEY (fashion_id) REFERENCES fashion (id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A988D3F4B ON products (fashion_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A988D3F4B');
        $this->addSql('DROP INDEX IDX_B3BA5A5A988D3F4B ON products');
        $this->addSql('ALTER TABLE products CHANGE fashion_id mode_id INT NOT NULL');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A77E5854A FOREIGN KEY (mode_id) REFERENCES fashion (id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5A77E5854A ON products (mode_id)');
    }
}
