<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250331102321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer_user_response (answer_id INT NOT NULL, user_response_id INT NOT NULL, PRIMARY KEY(answer_id, user_response_id))');
        $this->addSql('CREATE INDEX IDX_9050CAD0AA334807 ON answer_user_response (answer_id)');
        $this->addSql('CREATE INDEX IDX_9050CAD052E8E1D5 ON answer_user_response (user_response_id)');
        $this->addSql('CREATE TABLE score (id SERIAL NOT NULL, session_quizz_id INT NOT NULL, player_id INT NOT NULL, final_score INT NOT NULL, rank INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_32993751313F2BA5 ON score (session_quizz_id)');
        $this->addSql('CREATE INDEX IDX_3299375199E6F5DF ON score (player_id)');
        $this->addSql('ALTER TABLE answer_user_response ADD CONSTRAINT FK_9050CAD0AA334807 FOREIGN KEY (answer_id) REFERENCES answer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE answer_user_response ADD CONSTRAINT FK_9050CAD052E8E1D5 FOREIGN KEY (user_response_id) REFERENCES user_response (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_32993751313F2BA5 FOREIGN KEY (session_quizz_id) REFERENCES session_quizz (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_3299375199E6F5DF FOREIGN KEY (player_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE question ADD content TEXT NOT NULL');
        $this->addSql('ALTER TABLE question ALTER explanation TYPE TEXT');
        $this->addSql('ALTER TABLE quizz ALTER description TYPE TEXT');
        $this->addSql('ALTER TABLE "user" ADD global_score INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_response ALTER response_time TYPE INT');
        $this->addSql('ALTER TABLE user_response RENAME COLUMN score TO response_score');
        $this->addSql('COMMENT ON COLUMN user_response.response_time IS NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE answer_user_response DROP CONSTRAINT FK_9050CAD0AA334807');
        $this->addSql('ALTER TABLE answer_user_response DROP CONSTRAINT FK_9050CAD052E8E1D5');
        $this->addSql('ALTER TABLE score DROP CONSTRAINT FK_32993751313F2BA5');
        $this->addSql('ALTER TABLE score DROP CONSTRAINT FK_3299375199E6F5DF');
        $this->addSql('DROP TABLE answer_user_response');
        $this->addSql('DROP TABLE score');
        $this->addSql('ALTER TABLE question DROP content');
        $this->addSql('ALTER TABLE question ALTER explanation TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE quizz ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_response ALTER response_time TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE user_response RENAME COLUMN response_score TO score');
        $this->addSql('COMMENT ON COLUMN user_response.response_time IS \'(DC2Type:dateinterval)\'');
        $this->addSql('ALTER TABLE "user" DROP global_score');
    }
}
