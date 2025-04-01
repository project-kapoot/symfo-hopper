<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250330142258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id SERIAL NOT NULL, question_id INT NOT NULL, content VARCHAR(255) NOT NULL, is_correct BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DADD4A251E27F6BF ON answer (question_id)');
        $this->addSql('CREATE TABLE answer_user_response (answer_id INT NOT NULL, user_response_id INT NOT NULL, PRIMARY KEY(answer_id, user_response_id))');
        $this->addSql('CREATE INDEX IDX_9050CAD0AA334807 ON answer_user_response (answer_id)');
        $this->addSql('CREATE INDEX IDX_9050CAD052E8E1D5 ON answer_user_response (user_response_id)');
        $this->addSql('CREATE TABLE question (id SERIAL NOT NULL, quizz_id INT NOT NULL, content TEXT NOT NULL, explanation TEXT NOT NULL, time_max VARCHAR(255) NOT NULL, score_min INT NOT NULL, score_max INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B6F7494EBA934BCD ON question (quizz_id)');
        $this->addSql('COMMENT ON COLUMN question.time_max IS \'(DC2Type:dateinterval)\'');
        $this->addSql('CREATE TABLE quizz (id SERIAL NOT NULL, author_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, description TEXT NOT NULL, logo VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7C77973DF675F31B ON quizz (author_id)');
        $this->addSql('CREATE TABLE score (id SERIAL NOT NULL, session_quizz_id INT NOT NULL, player_id INT NOT NULL, final_score INT NOT NULL, rank INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_32993751313F2BA5 ON score (session_quizz_id)');
        $this->addSql('CREATE INDEX IDX_3299375199E6F5DF ON score (player_id)');
        $this->addSql('CREATE TABLE session_quizz (id SERIAL NOT NULL, presenter_id INT DEFAULT NULL, quizz_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, mode VARCHAR(255) NOT NULL, start_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A70A2FEBDDE4C635 ON session_quizz (presenter_id)');
        $this->addSql('CREATE INDEX IDX_A70A2FEBBA934BCD ON session_quizz (quizz_id)');
        $this->addSql('COMMENT ON COLUMN session_quizz.start_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN session_quizz.end_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE session_quizz_user (session_quizz_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(session_quizz_id, user_id))');
        $this->addSql('CREATE INDEX IDX_9B32400C313F2BA5 ON session_quizz_user (session_quizz_id)');
        $this->addSql('CREATE INDEX IDX_9B32400CA76ED395 ON session_quizz_user (user_id)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, global_score INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('CREATE TABLE user_response (id SERIAL NOT NULL, player_id INT NOT NULL, session_quizz_id INT NOT NULL, question_id INT NOT NULL, response_score INT NOT NULL, response_time INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DEF6EFFB99E6F5DF ON user_response (player_id)');
        $this->addSql('CREATE INDEX IDX_DEF6EFFB313F2BA5 ON user_response (session_quizz_id)');
        $this->addSql('CREATE INDEX IDX_DEF6EFFB1E27F6BF ON user_response (question_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE answer_user_response ADD CONSTRAINT FK_9050CAD0AA334807 FOREIGN KEY (answer_id) REFERENCES answer (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE answer_user_response ADD CONSTRAINT FK_9050CAD052E8E1D5 FOREIGN KEY (user_response_id) REFERENCES user_response (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quizz ADD CONSTRAINT FK_7C77973DF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_32993751313F2BA5 FOREIGN KEY (session_quizz_id) REFERENCES session_quizz (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_3299375199E6F5DF FOREIGN KEY (player_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session_quizz ADD CONSTRAINT FK_A70A2FEBDDE4C635 FOREIGN KEY (presenter_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session_quizz ADD CONSTRAINT FK_A70A2FEBBA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session_quizz_user ADD CONSTRAINT FK_9B32400C313F2BA5 FOREIGN KEY (session_quizz_id) REFERENCES session_quizz (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session_quizz_user ADD CONSTRAINT FK_9B32400CA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_response ADD CONSTRAINT FK_DEF6EFFB99E6F5DF FOREIGN KEY (player_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_response ADD CONSTRAINT FK_DEF6EFFB313F2BA5 FOREIGN KEY (session_quizz_id) REFERENCES session_quizz (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_response ADD CONSTRAINT FK_DEF6EFFB1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE answer DROP CONSTRAINT FK_DADD4A251E27F6BF');
        $this->addSql('ALTER TABLE answer_user_response DROP CONSTRAINT FK_9050CAD0AA334807');
        $this->addSql('ALTER TABLE answer_user_response DROP CONSTRAINT FK_9050CAD052E8E1D5');
        $this->addSql('ALTER TABLE question DROP CONSTRAINT FK_B6F7494EBA934BCD');
        $this->addSql('ALTER TABLE quizz DROP CONSTRAINT FK_7C77973DF675F31B');
        $this->addSql('ALTER TABLE score DROP CONSTRAINT FK_32993751313F2BA5');
        $this->addSql('ALTER TABLE score DROP CONSTRAINT FK_3299375199E6F5DF');
        $this->addSql('ALTER TABLE session_quizz DROP CONSTRAINT FK_A70A2FEBDDE4C635');
        $this->addSql('ALTER TABLE session_quizz DROP CONSTRAINT FK_A70A2FEBBA934BCD');
        $this->addSql('ALTER TABLE session_quizz_user DROP CONSTRAINT FK_9B32400C313F2BA5');
        $this->addSql('ALTER TABLE session_quizz_user DROP CONSTRAINT FK_9B32400CA76ED395');
        $this->addSql('ALTER TABLE user_response DROP CONSTRAINT FK_DEF6EFFB99E6F5DF');
        $this->addSql('ALTER TABLE user_response DROP CONSTRAINT FK_DEF6EFFB313F2BA5');
        $this->addSql('ALTER TABLE user_response DROP CONSTRAINT FK_DEF6EFFB1E27F6BF');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE answer_user_response');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE quizz');
        $this->addSql('DROP TABLE score');
        $this->addSql('DROP TABLE session_quizz');
        $this->addSql('DROP TABLE session_quizz_user');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_response');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
