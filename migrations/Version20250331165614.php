<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250331165614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE muscle_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE muscle_group_exercise (muscle_group_id INT NOT NULL, exercise_id INT NOT NULL, INDEX IDX_B1C432BE44004D0 (muscle_group_id), INDEX IDX_B1C432BEE934951A (exercise_id), PRIMARY KEY(muscle_group_id, exercise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE muscle_group_exercise ADD CONSTRAINT FK_B1C432BE44004D0 FOREIGN KEY (muscle_group_id) REFERENCES muscle_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE muscle_group_exercise ADD CONSTRAINT FK_B1C432BEE934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercise DROP muscle_group, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE muscle_group_exercise DROP FOREIGN KEY FK_B1C432BE44004D0');
        $this->addSql('ALTER TABLE muscle_group_exercise DROP FOREIGN KEY FK_B1C432BEE934951A');
        $this->addSql('DROP TABLE muscle_group');
        $this->addSql('DROP TABLE muscle_group_exercise');
        $this->addSql('ALTER TABLE exercise ADD muscle_group VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
