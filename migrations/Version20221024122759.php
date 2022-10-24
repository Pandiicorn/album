<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221024122759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(55) NOT NULL, description LONGTEXT DEFAULT NULL, creat_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', update_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album_picture (album_id INT NOT NULL, picture_id INT NOT NULL, INDEX IDX_430C129B1137ABCF (album_id), INDEX IDX_430C129BEE45BDBF (picture_id), PRIMARY KEY(album_id, picture_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album_picture ADD CONSTRAINT FK_430C129B1137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE album_picture ADD CONSTRAINT FK_430C129BEE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture CHANGE user_id user_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album_picture DROP FOREIGN KEY FK_430C129B1137ABCF');
        $this->addSql('ALTER TABLE album_picture DROP FOREIGN KEY FK_430C129BEE45BDBF');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE album_picture');
        $this->addSql('ALTER TABLE picture CHANGE user_id user_id INT DEFAULT NULL');
    }
}
