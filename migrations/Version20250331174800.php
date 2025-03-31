<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250331174800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE muscle_group ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE muscle_group ADD CONSTRAINT FK_323D098E727ACA70 FOREIGN KEY (parent_id) REFERENCES muscle_group (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_323D098E727ACA70 ON muscle_group (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE muscle_group DROP FOREIGN KEY FK_323D098E727ACA70');
        $this->addSql('DROP INDEX IDX_323D098E727ACA70 ON muscle_group');
        $this->addSql('ALTER TABLE muscle_group DROP parent_id');
    }
}
