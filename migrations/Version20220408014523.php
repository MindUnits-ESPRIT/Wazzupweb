<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220408014523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE escalope (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY commentaire_ibfk_2');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY commentaire_ibfk_1');
        $this->addSql('ALTER TABLE commentaire CHANGE Id_Publication Id_Publication INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCFCD65D81 FOREIGN KEY (Id_Publication) REFERENCES publication (Id_Publication)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC4EF6594B FOREIGN KEY (Id_Utilisateur) REFERENCES utilisateurs (ID_Utilisateur)');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY user_event');
        $this->addSql('ALTER TABLE evenement CHANGE ID_Utilisateur ID_Utilisateur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EFD8812BE FOREIGN KEY (ID_Utilisateur) REFERENCES utilisateurs (ID_Utilisateur)');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY facture_user');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY facture_paiement');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY facture_offre');
        $this->addSql('ALTER TABLE facture CHANGE id_offre id_offre INT DEFAULT NULL, CHANGE ID_Utilisateur ID_Utilisateur INT DEFAULT NULL, CHANGE ID_paiement ID_paiement INT DEFAULT NULL');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE86641028C61A8C FOREIGN KEY (ID_paiement) REFERENCES paiement (ID_paiement)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664104103C75F FOREIGN KEY (id_offre) REFERENCES offre_publicitaire (id_offre)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410FD8812BE FOREIGN KEY (ID_Utilisateur) REFERENCES utilisateurs (ID_Utilisateur)');
        $this->addSql('ALTER TABLE interets DROP FOREIGN KEY id_utilisateur');
        $this->addSql('ALTER TABLE interets CHANGE ID_Utilisateur ID_Utilisateur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE interets ADD CONSTRAINT FK_BD1B1903FD8812BE FOREIGN KEY (ID_Utilisateur) REFERENCES utilisateurs (ID_Utilisateur)');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY msg_user');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY msg_collab');
        $this->addSql('ALTER TABLE message CHANGE ID_Uitlisateur ID_Uitlisateur INT DEFAULT NULL, CHANGE ID_Collab ID_Collab INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F7257BDC0 FOREIGN KEY (ID_Uitlisateur) REFERENCES utilisateurs (ID_Utilisateur)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F91BB4C88 FOREIGN KEY (ID_Collab) REFERENCES salle_collaboration (ID_Collab)');
        $this->addSql('ALTER TABLE offre_publicitaire DROP FOREIGN KEY offre_user');
        $this->addSql('ALTER TABLE offre_publicitaire CHANGE ID_Utilisateur ID_Utilisateur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offre_publicitaire ADD CONSTRAINT FK_36940D8AFD8812BE FOREIGN KEY (ID_Utilisateur) REFERENCES utilisateurs (ID_Utilisateur)');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY jointure_profile');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FFD8812BE FOREIGN KEY (ID_Utilisateur) REFERENCES utilisateurs (ID_Utilisateur)');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY prjt_collab');
        $this->addSql('ALTER TABLE projet CHANGE ID_Collab ID_Collab INT DEFAULT NULL');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA991BB4C88 FOREIGN KEY (ID_Collab) REFERENCES salle_collaboration (ID_Collab)');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY publication_ibfk_1');
        $this->addSql('ALTER TABLE publication CHANGE Id_Utilisateur Id_Utilisateur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C67794EF6594B FOREIGN KEY (Id_Utilisateur) REFERENCES utilisateurs (ID_Utilisateur)');
        $this->addSql('ALTER TABLE publication_signaler DROP FOREIGN KEY signaler_Foreign_uti');
        $this->addSql('ALTER TABLE publication_signaler DROP FOREIGN KEY signaler_Foreign_pub');
        $this->addSql('ALTER TABLE publication_signaler CHANGE Id_utilisateur Id_utilisateur INT DEFAULT NULL, CHANGE Id_publication Id_publication INT DEFAULT NULL');
        $this->addSql('ALTER TABLE publication_signaler ADD CONSTRAINT FK_21916E63C86AD69C FOREIGN KEY (Id_utilisateur) REFERENCES utilisateurs (ID_Utilisateur)');
        $this->addSql('ALTER TABLE publication_signaler ADD CONSTRAINT FK_21916E637A4AD256 FOREIGN KEY (Id_publication) REFERENCES publication (Id_Publication)');
        $this->addSql('ALTER TABLE rencontre DROP FOREIGN KEY rencontre_event');
        $this->addSql('ALTER TABLE rencontre CHANGE ID_Event ID_Event INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rencontre ADD CONSTRAINT FK_460C35ED22213F59 FOREIGN KEY (ID_Event) REFERENCES evenement (ID_Event)');
        $this->addSql('ALTER TABLE salle_cinema DROP FOREIGN KEY cinema_event');
        $this->addSql('ALTER TABLE salle_cinema CHANGE Chat Chat LONGTEXT NOT NULL, CHANGE ID_Event ID_Event INT DEFAULT NULL');
        $this->addSql('ALTER TABLE salle_cinema ADD CONSTRAINT FK_E000D84B22213F59 FOREIGN KEY (ID_Event) REFERENCES evenement (ID_Event)');
        $this->addSql('ALTER TABLE salle_collaboration DROP FOREIGN KEY collab_user');
        $this->addSql('ALTER TABLE salle_collaboration CHANGE Chat Chat LONGTEXT DEFAULT NULL, CHANGE ID_Utilisateur ID_Utilisateur INT DEFAULT NULL');
        $this->addSql('ALTER TABLE salle_collaboration ADD CONSTRAINT FK_A4FFD0F3FD8812BE FOREIGN KEY (ID_Utilisateur) REFERENCES utilisateurs (ID_Utilisateur)');
        $this->addSql('ALTER TABLE collab_members DROP FOREIGN KEY collabmembers_u');
        $this->addSql('ALTER TABLE collab_members DROP FOREIGN KEY collabmembers_collab');
        $this->addSql('ALTER TABLE collab_members DROP FOREIGN KEY collabmembers_u');
        $this->addSql('ALTER TABLE collab_members ADD CONSTRAINT FK_6768D3AF91BB4C88 FOREIGN KEY (ID_Collab) REFERENCES salle_collaboration (ID_Collab)');
        $this->addSql('ALTER TABLE collab_members ADD CONSTRAINT FK_6768D3AFE9B1998A FOREIGN KEY (ID_Utlisateur) REFERENCES utilisateurs (ID_Utilisateur)');
        $this->addSql('DROP INDEX member_id ON collab_members');
        $this->addSql('CREATE INDEX IDX_6768D3AFE9B1998A ON collab_members (ID_Utlisateur)');
        $this->addSql('ALTER TABLE collab_members ADD CONSTRAINT collabmembers_u FOREIGN KEY (ID_Utlisateur) REFERENCES utilisateurs (ID_Utilisateur) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateurs CHANGE sponsor sponsor TINYINT(1) DEFAULT NULL, CHANGE desactivated desactivated TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, dob VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, genre VARCHAR(12) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, numtel VARCHAR(12) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, avatar VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, password_requested_at DATETIME DEFAULT NULL, token VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, activated TINYINT(1) NOT NULL, nbsignal VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, evaluation INT NOT NULL, sponsor TINYINT(1) NOT NULL, desactivated TINYINT(1) NOT NULL, creation_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE escalope');
        $this->addSql('ALTER TABLE collab_members DROP FOREIGN KEY FK_6768D3AF91BB4C88');
        $this->addSql('ALTER TABLE collab_members DROP FOREIGN KEY FK_6768D3AFE9B1998A');
        $this->addSql('ALTER TABLE collab_members DROP FOREIGN KEY FK_6768D3AFE9B1998A');
        $this->addSql('ALTER TABLE collab_members ADD CONSTRAINT collabmembers_u FOREIGN KEY (ID_Utlisateur) REFERENCES utilisateurs (ID_Utilisateur) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE collab_members ADD CONSTRAINT collabmembers_collab FOREIGN KEY (ID_Collab) REFERENCES salle_collaboration (ID_Collab) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP INDEX idx_6768d3afe9b1998a ON collab_members');
        $this->addSql('CREATE INDEX member_id ON collab_members (ID_Utlisateur)');
        $this->addSql('ALTER TABLE collab_members ADD CONSTRAINT FK_6768D3AFE9B1998A FOREIGN KEY (ID_Utlisateur) REFERENCES utilisateurs (ID_Utilisateur)');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCFCD65D81');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC4EF6594B');
        $this->addSql('ALTER TABLE commentaire CHANGE Message Message VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Id_Publication Id_Publication INT NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT commentaire_ibfk_2 FOREIGN KEY (Id_Publication) REFERENCES publication (Id_Publication) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT commentaire_ibfk_1 FOREIGN KEY (Id_Utilisateur) REFERENCES utilisateurs (ID_Utilisateur) ON UPDATE SET NULL ON DELETE SET NULL');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EFD8812BE');
        $this->addSql('ALTER TABLE evenement CHANGE Nom_Event Nom_Event VARCHAR(50) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Date_Event Date_Event VARCHAR(50) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Type_Event Type_Event VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Event_Visibilite Event_Visibilite VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Description Description VARCHAR(50) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE ID_Utilisateur ID_Utilisateur INT NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT user_event FOREIGN KEY (ID_Utilisateur) REFERENCES utilisateurs (ID_Utilisateur) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE86641028C61A8C');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664104103C75F');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410FD8812BE');
        $this->addSql('ALTER TABLE facture CHANGE id_offre id_offre INT NOT NULL, CHANGE file file VARCHAR(30) DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE ID_paiement ID_paiement INT NOT NULL, CHANGE ID_Utilisateur ID_Utilisateur INT NOT NULL');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT facture_user FOREIGN KEY (ID_Utilisateur) REFERENCES utilisateurs (ID_Utilisateur) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT facture_paiement FOREIGN KEY (ID_paiement) REFERENCES paiement (ID_paiement) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT facture_offre FOREIGN KEY (id_offre) REFERENCES offre_publicitaire (id_offre) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE interets DROP FOREIGN KEY FK_BD1B1903FD8812BE');
        $this->addSql('ALTER TABLE interets CHANGE nom_interet nom_interet VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE ID_Utilisateur ID_Utilisateur INT NOT NULL');
        $this->addSql('ALTER TABLE interets ADD CONSTRAINT id_utilisateur FOREIGN KEY (ID_Utilisateur) REFERENCES utilisateurs (ID_Utilisateur) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F7257BDC0');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F91BB4C88');
        $this->addSql('ALTER TABLE message CHANGE body body TEXT NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE ID_Uitlisateur ID_Uitlisateur INT NOT NULL, CHANGE ID_Collab ID_Collab INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT msg_user FOREIGN KEY (ID_Uitlisateur) REFERENCES utilisateurs (ID_Utilisateur) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT msg_collab FOREIGN KEY (ID_Collab) REFERENCES salle_collaboration (ID_Collab) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_publicitaire DROP FOREIGN KEY FK_36940D8AFD8812BE');
        $this->addSql('ALTER TABLE offre_publicitaire CHANGE nom_offre nom_offre VARCHAR(30) DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE contenu_offre contenu_offre TEXT DEFAULT NULL COLLATE `utf8mb4_general_ci`, CHANGE ID_Utilisateur ID_Utilisateur INT NOT NULL');
        $this->addSql('ALTER TABLE offre_publicitaire ADD CONSTRAINT offre_user FOREIGN KEY (ID_Utilisateur) REFERENCES utilisateurs (ID_Utilisateur) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE paiement CHANGE Methode_paiement Methode_paiement VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FFD8812BE');
        $this->addSql('ALTER TABLE profile CHANGE profile_pic profile_pic VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE bio bio VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT jointure_profile FOREIGN KEY (ID_Utilisateur) REFERENCES utilisateurs (ID_Utilisateur) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA991BB4C88');
        $this->addSql('ALTER TABLE projet CHANGE Nom_Projet Nom_Projet VARCHAR(20) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Description_Projet Description_Projet VARCHAR(800) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE URL_trello URL_trello VARCHAR(60) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE ID_Collab ID_Collab INT NOT NULL');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT prjt_collab FOREIGN KEY (ID_Collab) REFERENCES salle_collaboration (ID_Collab) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C67794EF6594B');
        $this->addSql('ALTER TABLE publication CHANGE Description Description VARCHAR(100) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Fichier Fichier VARCHAR(150) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Visibilite Visibilite VARCHAR(255) DEFAULT \'True\' NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Id_Utilisateur Id_Utilisateur INT NOT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT publication_ibfk_1 FOREIGN KEY (Id_Utilisateur) REFERENCES utilisateurs (ID_Utilisateur) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE publication_signaler DROP FOREIGN KEY FK_21916E63C86AD69C');
        $this->addSql('ALTER TABLE publication_signaler DROP FOREIGN KEY FK_21916E637A4AD256');
        $this->addSql('ALTER TABLE publication_signaler CHANGE Type Type VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Id_utilisateur Id_utilisateur INT NOT NULL, CHANGE Id_publication Id_publication INT NOT NULL');
        $this->addSql('ALTER TABLE publication_signaler ADD CONSTRAINT signaler_Foreign_uti FOREIGN KEY (Id_utilisateur) REFERENCES utilisateurs (ID_Utilisateur) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE publication_signaler ADD CONSTRAINT signaler_Foreign_pub FOREIGN KEY (Id_publication) REFERENCES publication (Id_Publication) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rencontre DROP FOREIGN KEY FK_460C35ED22213F59');
        $this->addSql('ALTER TABLE rencontre CHANGE Type_Rencontre Type_Rencontre VARCHAR(255) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE URL_Invitation URL_Invitation VARCHAR(50) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE ID_Event ID_Event INT NOT NULL');
        $this->addSql('ALTER TABLE rencontre ADD CONSTRAINT rencontre_event FOREIGN KEY (ID_Event) REFERENCES evenement (ID_Event) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salle_cinema DROP FOREIGN KEY FK_E000D84B22213F59');
        $this->addSql('ALTER TABLE salle_cinema CHANGE Nom_Salle Nom_Salle VARCHAR(50) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE URL_Film URL_Film VARCHAR(50) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE URL_Salle URL_Salle VARCHAR(50) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Chat Chat LONGTEXT NOT NULL COLLATE `utf8mb4_bin`, CHANGE ID_Event ID_Event INT NOT NULL');
        $this->addSql('ALTER TABLE salle_cinema ADD CONSTRAINT cinema_event FOREIGN KEY (ID_Event) REFERENCES evenement (ID_Event) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE salle_collaboration DROP FOREIGN KEY FK_A4FFD0F3FD8812BE');
        $this->addSql('ALTER TABLE salle_collaboration CHANGE Nom_Collab Nom_Collab VARCHAR(20) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE URL_Collab URL_Collab VARCHAR(60) NOT NULL COLLATE `utf8mb4_general_ci`, CHANGE Chat Chat LONGTEXT DEFAULT NULL COLLATE `utf8mb4_bin`, CHANGE ID_Utilisateur ID_Utilisateur INT NOT NULL');
        $this->addSql('ALTER TABLE salle_collaboration ADD CONSTRAINT collab_user FOREIGN KEY (ID_Utilisateur) REFERENCES utilisateurs (ID_Utilisateur) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateurs CHANGE nom nom VARCHAR(30) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, CHANGE prenom prenom VARCHAR(30) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, CHANGE datenaissance datenaissance VARCHAR(30) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, CHANGE genre genre VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE num_tel num_tel VARCHAR(12) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, CHANGE email email VARCHAR(50) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, CHANGE avatar avatar VARCHAR(200) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE mdp mdp VARCHAR(220) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, CHANGE type_user type_user VARCHAR(255) CHARACTER SET utf8 DEFAULT \'User\' NOT NULL COLLATE `utf8_general_ci`, CHANGE Token Token VARCHAR(200) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE sponsor sponsor TINYINT(1) DEFAULT 0, CHANGE desactivated desactivated TINYINT(1) DEFAULT 0');
    }
}
