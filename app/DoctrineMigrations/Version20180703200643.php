<?php
/**
 * Created by PhpStorm.
 * User: mkardakov
 * Date: 7/3/18
 * Time: 11:15 AM
 */

namespace Application\Migrations;


use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20180703200643 extends AbstractMigration
{

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('INSERT INTO tag (id, title, color) VALUES(1, "General", "FF00CC"), (2, "Travelling", "0000bb"');
        $this->addSql('INSERT INTO goal (title, description, created_at) 
        VALUES("Be stronger", "Add some muscles", NOW()), 
        ("Be smarter", "Dead some books and watch TED", NOW()), ("Find a hobby", "Should I come back at music life?", NOW())'
        );
        $this->addSql('INSERT INTO goals_tags (goal_id, tag_id) VALUES(1, 1), (2, 1), (2, 2), (3, 2)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DELETE FROM goals_tags');
        $this->addSql('DELETE FROM tag');
        $this->addSql('DELETE FROM goal');
    }
}