<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20201214073635 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Creating records table.';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE record (id INT AUTO_INCREMENT NOT NULL, ident VARCHAR(32) NOT NULL, value VARCHAR(255) NOT NULL, version INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE data');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE data (ident VARCHAR(32) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, value VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, version INT UNSIGNED NOT NULL, UNIQUE INDEX ident (ident)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = MyISAM COMMENT = \'\' ');
        $this->addSql('DROP TABLE record');
    }
}
