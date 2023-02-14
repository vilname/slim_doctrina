<?php

declare(strict_types=1);

namespace App\Data\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214094339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE subscribers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE subscribers (id INT NOT NULL, email VARCHAR(255) NOT NULL, created TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2FCD16ACE7927C74 ON subscribers (email)');
        $this->addSql('COMMENT ON COLUMN subscribers.created IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE subscribers_id_seq CASCADE');
        $this->addSql('DROP TABLE subscribers');
    }
}
