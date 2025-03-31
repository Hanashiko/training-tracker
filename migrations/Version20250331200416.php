<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250331200416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE muscle_group_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE muscle_group DROP FOREIGN KEY FK_323D098E727ACA70');
        $this->addSql('DROP INDEX IDX_323D098E727ACA70 ON muscle_group');
        $this->addSql('ALTER TABLE muscle_group ADD category_id INT NOT NULL, DROP parent_id');
        $this->addSql('ALTER TABLE muscle_group ADD CONSTRAINT FK_323D098E12469DE2 FOREIGN KEY (category_id) REFERENCES muscle_group_category (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_323D098E12469DE2 ON muscle_group (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE muscle_group DROP FOREIGN KEY FK_323D098E12469DE2');
        $this->addSql('DROP TABLE muscle_group_category');
        $this->addSql('DROP INDEX IDX_323D098E12469DE2 ON muscle_group');
        $this->addSql('ALTER TABLE muscle_group ADD parent_id INT DEFAULT NULL, DROP category_id');
        $this->addSql('ALTER TABLE muscle_group ADD CONSTRAINT FK_323D098E727ACA70 FOREIGN KEY (parent_id) REFERENCES muscle_group (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_323D098E727ACA70 ON muscle_group (parent_id)');
    }
}
