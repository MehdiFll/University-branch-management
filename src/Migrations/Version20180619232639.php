<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180619232639 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE planning (id INT AUTO_INCREMENT NOT NULL, filiere_id INT NOT NULL, titre VARCHAR(60) NOT NULL, contenu LONGTEXT NOT NULL, date_debut VARCHAR(30) NOT NULL, date_fin VARCHAR(30) NOT NULL, INDEX IDX_D499BFF6180AA129 (filiere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE planning ADD CONSTRAINT FK_D499BFF6180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628ABC1F7FE FOREIGN KEY (prof_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE professeur ADD CONSTRAINT FK_17A55299A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE planning');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3180AA129');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3A76ED395');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628ABC1F7FE');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628180AA129');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14AFC2B591');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14DDEAB1A3');
        $this->addSql('ALTER TABLE professeur DROP FOREIGN KEY FK_17A55299A76ED395');
        $this->addSql('ALTER TABLE user CHANGE password password VARCHAR(250) NOT NULL COLLATE latin1_swedish_ci');
    }
}
