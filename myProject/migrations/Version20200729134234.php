<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200729134234 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE id CASCADE');
        $this->addSql('CREATE SEQUENCE property_id_seq');
        $this->addSql('SELECT setval(\'property_id_seq\', (SELECT MAX(id) FROM property))');
        $this->addSql('ALTER TABLE property ALTER id SET DEFAULT nextval(\'property_id_seq\')');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE id INCREMENT BY 1 MINVALUE 100 START 100');
        $this->addSql('ALTER TABLE property ALTER id DROP DEFAULT');
    }
}
