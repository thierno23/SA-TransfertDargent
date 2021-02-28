<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210228231642 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agence (id INT AUTO_INCREMENT NOT NULL, compte_id INT DEFAULT NULL, nom_agence VARCHAR(255) NOT NULL, latittude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, statut TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_64C19AA9E40E05FE (nom_agence), UNIQUE INDEX UNIQ_64C19AA9F2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom_complet VARCHAR(255) NOT NULL, cni VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commission (id INT AUTO_INCREMENT NOT NULL, commission_etat DOUBLE PRECISION NOT NULL, commission_system DOUBLE PRECISION NOT NULL, commission_envoie DOUBLE PRECISION NOT NULL, commission_retrait DOUBLE PRECISION NOT NULL, commission_agence DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, numero_compte VARCHAR(255) NOT NULL, montant DOUBLE PRECISION NOT NULL, statut TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_CFF652609731415A (numero_compte), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE depot (id INT AUTO_INCREMENT NOT NULL, user_depot_id INT DEFAULT NULL, compte_id INT DEFAULT NULL, date_depot DATE NOT NULL, montant_depot DOUBLE PRECISION NOT NULL, INDEX IDX_47948BBC659D30DE (user_depot_id), INDEX IDX_47948BBCF2C56620 (compte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_E6D6B297A4D60759 (libelle), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_9BACE7E1C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tableau_frais (id INT AUTO_INCREMENT NOT NULL, min DOUBLE PRECISION NOT NULL, max DOUBLE PRECISION NOT NULL, tarif DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, user_depot_id INT NOT NULL, user_retrait_id INT DEFAULT NULL, client_depot_id INT NOT NULL, client_retrait_id INT NOT NULL, montant DOUBLE PRECISION NOT NULL, date_depot DATE NOT NULL, date_retrait DATE DEFAULT NULL, frais_total DOUBLE PRECISION NOT NULL, frais_etat DOUBLE PRECISION NOT NULL, frais_system DOUBLE PRECISION NOT NULL, frais_envoi DOUBLE PRECISION NOT NULL, frais_retrait DOUBLE PRECISION NOT NULL, code_transaction VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_723705D13B76EC61 (code_transaction), INDEX IDX_723705D1659D30DE (user_depot_id), INDEX IDX_723705D1D99F8396 (user_retrait_id), INDEX IDX_723705D1ABF6E41B (client_depot_id), INDEX IDX_723705D1EEAC783B (client_retrait_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, profil_id INT NOT NULL, agence_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, avatar LONGBLOB DEFAULT NULL, cni VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, statut TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D6497AC033BE (cni), INDEX IDX_8D93D649275ED078 (profil_id), INDEX IDX_8D93D649D725330D (agence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA9F2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBC659D30DE FOREIGN KEY (user_depot_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBCF2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1659D30DE FOREIGN KEY (user_depot_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1D99F8396 FOREIGN KEY (user_retrait_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1ABF6E41B FOREIGN KEY (client_depot_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1EEAC783B FOREIGN KEY (client_retrait_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D725330D FOREIGN KEY (agence_id) REFERENCES agence (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D725330D');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1ABF6E41B');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1EEAC783B');
        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA9F2C56620');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBCF2C56620');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649275ED078');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBC659D30DE');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1659D30DE');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1D99F8396');
        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE commission');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE depot');
        $this->addSql('DROP TABLE profil');
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('DROP TABLE tableau_frais');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE user');
    }
}
