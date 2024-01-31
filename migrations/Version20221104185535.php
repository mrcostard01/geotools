<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221104185535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles CHANGE texte_article_a texte_article_a VARCHAR(5000) NOT NULL');
        $this->addSql('ALTER TABLE carte CHANGE desc_pays_c desc_pays_c VARCHAR(5000) NOT NULL');
        $this->addSql('ALTER TABLE modifications CHANGE modif_regions_desc_m modif_regions_desc_m VARCHAR(5000) DEFAULT NULL');
        $this->addSql('ALTER TABLE regions CHANGE desc_regions_r desc_regions_r VARCHAR(5000) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles CHANGE texte_article_a texte_article_a VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE carte CHANGE desc_pays_c desc_pays_c VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE modifications CHANGE modif_regions_desc_m modif_regions_desc_m VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE regions CHANGE desc_regions_r desc_regions_r VARCHAR(100) NOT NULL');
    }
}
