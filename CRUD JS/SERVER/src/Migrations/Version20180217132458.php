<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180217132458 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tipos (id INT AUTO_INCREMENT NOT NULL, tipo ENUM(\'Hibrida_Mixta\',\'Hibrida_Indica\',\'Hibrida_Sativa\',\'Sativa\',\'Indica\',\'Ruderalis\',\'Legendaria\'), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE variedades CHANGE id_tipo id_tipo INT DEFAULT NULL, CHANGE id_pais id_pais INT DEFAULT NULL');
        $this->addSql('ALTER TABLE variedades ADD CONSTRAINT FK_8AD7940FFB0D0145 FOREIGN KEY (id_tipo) REFERENCES tipos (id)');
        $this->addSql('ALTER TABLE variedades ADD CONSTRAINT FK_8AD7940FF57D32FD FOREIGN KEY (id_pais) REFERENCES paises (id)');
        $this->addSql('CREATE INDEX IDX_8AD7940FFB0D0145 ON variedades (id_tipo)');
        $this->addSql('CREATE INDEX IDX_8AD7940FF57D32FD ON variedades (id_pais)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE variedades DROP FOREIGN KEY FK_8AD7940FFB0D0145');
        $this->addSql('DROP TABLE tipos');
        $this->addSql('ALTER TABLE variedades DROP FOREIGN KEY FK_8AD7940FF57D32FD');
        $this->addSql('DROP INDEX IDX_8AD7940FFB0D0145 ON variedades');
        $this->addSql('DROP INDEX IDX_8AD7940FF57D32FD ON variedades');
        $this->addSql('ALTER TABLE variedades CHANGE id_tipo id_tipo INT NOT NULL, CHANGE id_pais id_pais INT NOT NULL');
    }
}
