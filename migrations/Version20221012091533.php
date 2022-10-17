<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221012091533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE domicile (id INT AUTO_INCREMENT NOT NULL, equipe_id INT DEFAULT NULL, INDEX IDX_F6305DA26D861B89 (equipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE domicile ADD CONSTRAINT FK_F6305DA26D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE game ADD domicile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C95715F7D FOREIGN KEY (domicile_id) REFERENCES domicile (id)');
        $this->addSql('CREATE INDEX IDX_232B318C95715F7D ON game (domicile_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C95715F7D');
        $this->addSql('ALTER TABLE domicile DROP FOREIGN KEY FK_F6305DA26D861B89');
        $this->addSql('DROP TABLE domicile');
        $this->addSql('DROP INDEX IDX_232B318C95715F7D ON game');
        $this->addSql('ALTER TABLE game DROP domicile_id');
    }
}
