<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221121004950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX articles ON articles');
        $this->addSql('CREATE FULLTEXT INDEX articles ON articles (titre_article_a, texte_article_a)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX articles ON articles');
        $this->addSql('CREATE FULLTEXT INDEX articles ON articles (titre_article_a, resume_articlea)');
    }
}
