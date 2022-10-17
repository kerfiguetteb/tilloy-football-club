<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221012091717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE visiteur (id INT AUTO_INCREMENT NOT NULL, equipe_id INT DEFAULT NULL, INDEX IDX_4EA587B86D861B89 (equipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE visiteur ADD CONSTRAINT FK_4EA587B86D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE game ADD visiteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C7F72333D FOREIGN KEY (visiteur_id) REFERENCES visiteur (id)');
        $this->addSql('CREATE INDEX IDX_232B318C7F72333D ON game (visiteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C7F72333D');
        $this->addSql('ALTER TABLE visiteur DROP FOREIGN KEY FK_4EA587B86D861B89');
        $this->addSql('DROP TABLE visiteur');
        $this->addSql('DROP INDEX IDX_232B318C7F72333D ON game');
        $this->addSql('ALTER TABLE game DROP visiteur_id');
    }
}
