<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250331172210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercise_muscle_group (exercise_id INT NOT NULL, muscle_group_id INT NOT NULL, INDEX IDX_D8A5BCA7E934951A (exercise_id), INDEX IDX_D8A5BCA744004D0 (muscle_group_id), PRIMARY KEY(exercise_id, muscle_group_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE exercise_muscle_group ADD CONSTRAINT FK_D8A5BCA7E934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercise_muscle_group ADD CONSTRAINT FK_D8A5BCA744004D0 FOREIGN KEY (muscle_group_id) REFERENCES muscle_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE muscle_group_exercise DROP FOREIGN KEY FK_B1C432BE44004D0');
        $this->addSql('ALTER TABLE muscle_group_exercise DROP FOREIGN KEY FK_B1C432BEE934951A');
        $this->addSql('DROP TABLE muscle_group_exercise');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE muscle_group_exercise (muscle_group_id INT NOT NULL, exercise_id INT NOT NULL, INDEX IDX_B1C432BE44004D0 (muscle_group_id), INDEX IDX_B1C432BEE934951A (exercise_id), PRIMARY KEY(muscle_group_id, exercise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE muscle_group_exercise ADD CONSTRAINT FK_B1C432BE44004D0 FOREIGN KEY (muscle_group_id) REFERENCES muscle_group (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE muscle_group_exercise ADD CONSTRAINT FK_B1C432BEE934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE exercise_muscle_group DROP FOREIGN KEY FK_D8A5BCA7E934951A');
        $this->addSql('ALTER TABLE exercise_muscle_group DROP FOREIGN KEY FK_D8A5BCA744004D0');
        $this->addSql('DROP TABLE exercise_muscle_group');
    }
}
