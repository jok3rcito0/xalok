<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220061748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE driver (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, trip_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, license BOOLEAN NOT NULL, CONSTRAINT FK_11667CD9A5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_11667CD9A5BC2E0E ON driver (trip_id)');
        $this->addSql('CREATE TABLE trip (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date DATE NOT NULL)');
        $this->addSql('CREATE TABLE trip_vehicle (trip_id INTEGER NOT NULL, vehicle_id INTEGER NOT NULL, PRIMARY KEY(trip_id, vehicle_id), CONSTRAINT FK_2D6CA12BA5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2D6CA12B545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_2D6CA12BA5BC2E0E ON trip_vehicle (trip_id)');
        $this->addSql('CREATE INDEX IDX_2D6CA12B545317D1 ON trip_vehicle (vehicle_id)');
        $this->addSql('CREATE TABLE vehicle (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, brand VARCHAR(150) NOT NULL, model VARCHAR(150) NOT NULL, plate VARCHAR(30) NOT NULL, license_required BOOLEAN NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE driver');
        $this->addSql('DROP TABLE trip');
        $this->addSql('DROP TABLE trip_vehicle');
        $this->addSql('DROP TABLE vehicle');
    }
}
