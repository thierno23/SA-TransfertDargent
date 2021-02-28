<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210224164802 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom_complet VARCHAR(255) NOT NULL, cni VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, user_depot_id INT NOT NULL, user_retrait_id INT DEFAULT NULL, client_depot_id INT NOT NULL, client_retrait_id INT NOT NULL, montant DOUBLE PRECISION NOT NULL, date_depot DATE NOT NULL, date_retrait DATE DEFAULT NULL, frais_total DOUBLE PRECISION NOT NULL, frais_etat DOUBLE PRECISION NOT NULL, frais_system DOUBLE PRECISION NOT NULL, frais_envoi DOUBLE PRECISION NOT NULL, frais_retrait DOUBLE PRECISION NOT NULL, code_transaction VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_723705D13B76EC61 (code_transaction), INDEX IDX_723705D1659D30DE (user_depot_id), INDEX IDX_723705D1D99F8396 (user_retrait_id), INDEX IDX_723705D1ABF6E41B (client_depot_id), INDEX IDX_723705D1EEAC783B (client_retrait_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1659D30DE FOREIGN KEY (user_depot_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1D99F8396 FOREIGN KEY (user_retrait_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1ABF6E41B FOREIGN KEY (client_depot_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1EEAC783B FOREIGN KEY (client_retrait_id) REFERENCES client (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19AA9E40E05FE ON agence (nom_agence)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CFF652609731415A ON compte (numero_compte)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1ABF6E41B');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1EEAC783B');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP INDEX UNIQ_64C19AA9E40E05FE ON agence');
        $this->addSql('DROP INDEX UNIQ_CFF652609731415A ON compte');
    }
}
