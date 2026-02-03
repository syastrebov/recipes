<?php

declare(strict_types=1);

namespace migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

final class Version20260203131256 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create circuit_breaker table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('circuit_breaker');

        $table->addColumn('prefix', Types::STRING, ['length' => 255, 'notnull' => true]);
        $table->addColumn('name', Types::STRING, ['length' => 255, 'notnull' => true]);
        $table->addColumn('state', Types::STRING, [
            'length' => 10,
            'notnull' => false,
            'default' => 'closed',
        ]);
        $table->addColumn('state_timestamp', Types::INTEGER, ['notnull' => false]);
        $table->addColumn('failed_attempts', Types::INTEGER, ['notnull' => true, 'default' => 0]);
        $table->addColumn('half_open_attempts', Types::INTEGER, ['notnull' => true, 'default' => 0]);

        $table->setPrimaryKey(['prefix', 'name']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('circuit_breaker');
    }
}
