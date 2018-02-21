<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180221095233 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE paises (id INT AUTO_INCREMENT NOT NULL, iso VARCHAR(2) NOT NULL, pais VARCHAR(120) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipos (id INT AUTO_INCREMENT NOT NULL, tipo ENUM(\'Hibrida_Mixta\',\'Hibrida_Indica\',\'Hibrida_Sativa\',\'Sativa\',\'Indica\',\'Ruderalis\',\'Legendaria\'), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variedades (id INT AUTO_INCREMENT NOT NULL, id_tipo INT DEFAULT NULL, id_pais INT DEFAULT NULL, nombre VARCHAR(120) NOT NULL, tiempo_floracion INT DEFAULT NULL, interior TINYINT(1) NOT NULL, exterior TINYINT(1) NOT NULL, thc NUMERIC(10, 2) DEFAULT NULL, cbd NUMERIC(10, 2) DEFAULT NULL, genetica VARCHAR(120) DEFAULT NULL, description LONGTEXT DEFAULT NULL, file VARCHAR(150) DEFAULT NULL, INDEX IDX_8AD7940FFB0D0145 (id_tipo), INDEX IDX_8AD7940FF57D32FD (id_pais), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE variedades ADD CONSTRAINT FK_8AD7940FFB0D0145 FOREIGN KEY (id_tipo) REFERENCES tipos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variedades ADD CONSTRAINT FK_8AD7940FF57D32FD FOREIGN KEY (id_pais) REFERENCES paises (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE variedades DROP FOREIGN KEY FK_8AD7940FF57D32FD');
        $this->addSql('ALTER TABLE variedades DROP FOREIGN KEY FK_8AD7940FFB0D0145');
        $this->addSql('DROP TABLE paises');
        $this->addSql('DROP TABLE tipos');
        $this->addSql('DROP TABLE variedades');
    }
}
