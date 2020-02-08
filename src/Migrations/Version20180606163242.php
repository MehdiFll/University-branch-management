<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180606163242 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE etudiant ADD filiere_id INT NOT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_717E22E3180AA129 ON etudiant (filiere_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_717E22E3A76ED395 ON etudiant (user_id)');
        $this->addSql('ALTER TABLE module ADD prof_id INT NOT NULL, ADD filiere_id INT NOT NULL');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628ABC1F7FE FOREIGN KEY (prof_id) REFERENCES professeur (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('CREATE INDEX IDX_C242628ABC1F7FE ON module (prof_id)');
        $this->addSql('CREATE INDEX IDX_C242628180AA129 ON module (filiere_id)');
        $this->addSql('ALTER TABLE note ADD module_id INT NOT NULL, ADD etudiant_id INT NOT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14AFC2B591 ON note (module_id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14DDEAB1A3 ON note (etudiant_id)');
        $this->addSql('ALTER TABLE professeur ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE professeur ADD CONSTRAINT FK_17A55299A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_17A55299A76ED395 ON professeur (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3180AA129');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3A76ED395');
        $this->addSql('DROP INDEX IDX_717E22E3180AA129 ON etudiant');
        $this->addSql('DROP INDEX UNIQ_717E22E3A76ED395 ON etudiant');
        $this->addSql('ALTER TABLE etudiant DROP filiere_id, DROP user_id');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628ABC1F7FE');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628180AA129');
        $this->addSql('DROP INDEX IDX_C242628ABC1F7FE ON module');
        $this->addSql('DROP INDEX IDX_C242628180AA129 ON module');
        $this->addSql('ALTER TABLE module DROP prof_id, DROP filiere_id');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14AFC2B591');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14DDEAB1A3');
        $this->addSql('DROP INDEX IDX_CFBDFA14AFC2B591 ON note');
        $this->addSql('DROP INDEX IDX_CFBDFA14DDEAB1A3 ON note');
        $this->addSql('ALTER TABLE note DROP module_id, DROP etudiant_id');
        $this->addSql('ALTER TABLE professeur DROP FOREIGN KEY FK_17A55299A76ED395');
        $this->addSql('DROP INDEX UNIQ_17A55299A76ED395 ON professeur');
        $this->addSql('ALTER TABLE professeur DROP user_id');
    }
}
