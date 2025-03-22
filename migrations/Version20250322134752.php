<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250322134752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE question (id SERIAL NOT NULL, quiz_id INT DEFAULT NULL, time_max INT NOT NULL, text VARCHAR(255) NOT NULL, points INT NOT NULL, explanation TEXT NOT NULL, score_max INT NOT NULL, score_min INT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B6F7494E853CD175 ON question (quiz_id)');
        $this->addSql('CREATE TABLE question_multi_choice (id SERIAL NOT NULL, answers JSON NOT NULL, correct_answer INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE question_numerique (id SERIAL NOT NULL, correct_answer INT NOT NULL, tolerance DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE question_qcm (id SERIAL NOT NULL, answers JSON NOT NULL, correct_answer JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE quiz (id SERIAL NOT NULL, author_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A412FA92F675F31B ON quiz (author_id)');
        $this->addSql('CREATE TABLE session (id SERIAL NOT NULL, quiz_id INT NOT NULL, presenter_id INT NOT NULL, starting_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, mode VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D044D5D4853CD175 ON session (quiz_id)');
        $this->addSql('CREATE INDEX IDX_D044D5D4DDE4C635 ON session (presenter_id)');
        $this->addSql('CREATE TABLE "session_user" (session_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(session_id, user_id))');
        $this->addSql('CREATE INDEX IDX_4BE2D663613FECDF ON "session_user" (session_id)');
        $this->addSql('CREATE INDEX IDX_4BE2D663A76ED395 ON "session_user" (user_id)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('CREATE TABLE user_response (id SERIAL NOT NULL, question_id INT NOT NULL, session_id INT NOT NULL, responding_user_id INT NOT NULL, user_choice VARCHAR(255) DEFAULT NULL, response_time INT DEFAULT NULL, score INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DEF6EFFB1E27F6BF ON user_response (question_id)');
        $this->addSql('CREATE INDEX IDX_DEF6EFFB613FECDF ON user_response (session_id)');
        $this->addSql('CREATE INDEX IDX_DEF6EFFBB3A77197 ON user_response (responding_user_id)');
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
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D4DDE4C635 FOREIGN KEY (presenter_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "session_user" ADD CONSTRAINT FK_4BE2D663613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "session_user" ADD CONSTRAINT FK_4BE2D663A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_response ADD CONSTRAINT FK_DEF6EFFB1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_response ADD CONSTRAINT FK_DEF6EFFB613FECDF FOREIGN KEY (session_id) REFERENCES session (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_response ADD CONSTRAINT FK_DEF6EFFBB3A77197 FOREIGN KEY (responding_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE question DROP CONSTRAINT FK_B6F7494E853CD175');
        $this->addSql('ALTER TABLE quiz DROP CONSTRAINT FK_A412FA92F675F31B');
        $this->addSql('ALTER TABLE session DROP CONSTRAINT FK_D044D5D4853CD175');
        $this->addSql('ALTER TABLE session DROP CONSTRAINT FK_D044D5D4DDE4C635');
        $this->addSql('ALTER TABLE "session_user" DROP CONSTRAINT FK_4BE2D663613FECDF');
        $this->addSql('ALTER TABLE "session_user" DROP CONSTRAINT FK_4BE2D663A76ED395');
        $this->addSql('ALTER TABLE user_response DROP CONSTRAINT FK_DEF6EFFB1E27F6BF');
        $this->addSql('ALTER TABLE user_response DROP CONSTRAINT FK_DEF6EFFB613FECDF');
        $this->addSql('ALTER TABLE user_response DROP CONSTRAINT FK_DEF6EFFBB3A77197');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE question_multi_choice');
        $this->addSql('DROP TABLE question_numerique');
        $this->addSql('DROP TABLE question_qcm');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE "session_user"');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_response');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
