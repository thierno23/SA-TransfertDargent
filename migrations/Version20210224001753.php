<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210224001753 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E6D6B297A4D60759 ON profil (libelle)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6497AC033BE ON user (cni)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_E6D6B297A4D60759 ON profil');
        $this->addSql('DROP INDEX UNIQ_8D93D6497AC033BE ON user');
    }
}
