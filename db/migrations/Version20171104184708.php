<?php

namespace Bookshelf\Migration;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171104184708 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $user_table = $schema->createTable('user');
        $user_table->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $user_table->addColumn('name', 'string', ['length' => 255, 'collation' => 'utf8mb4_bin']);
        $user_table->addColumn('username', 'string', ['length' => 64, 'collation' => 'utf8mb4_bin']);
        $user_table->addColumn('password', 'string', ['length' => 255, 'collation' => 'utf8mb4_bin']);
        $user_table->addColumn('date_created', 'datetime');
        $user_table->addColumn('date_updated', 'datetime');
        $user_table->setPrimaryKey(['id']);
        $user_table->addUniqueIndex(['username']);
        $user_table->addOption('charset', 'utf8mb4');
        $user_table->addOption('collate', 'utf8mb4_bin');

        $book_table = $schema->createTable('book');
        $book_table->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $book_table->addColumn('name', 'string', ['length' => 255, 'collation' => 'utf8mb4_bin']);
        $book_table->addColumn('date_created', 'datetime');
        $book_table->addColumn('date_updated', 'datetime');
        $book_table->addColumn('added_by', 'integer', ['unsigned' => true]);
        $book_table->setPrimaryKey(['id']);
        $book_table->addForeignKeyConstraint($user_table, ['added_by'], ['id']);
        $book_table->addOption('charset', 'utf8mb4');
        $book_table->addOption('collate', 'utf8mb4_bin');

        $author_table = $schema->createTable('author');
        $author_table->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $author_table->addColumn('name', 'string', ['length' => 255, 'collation' => 'utf8mb4_bin']);
        $author_table->addColumn('date_created', 'datetime');
        $author_table->addColumn('date_updated', 'datetime');
        $author_table->setPrimaryKey(['id']);
        $author_table->addOption('charset', 'utf8mb4');
        $author_table->addOption('collate', 'utf8mb4_bin');

        // Map books -> authors. A book can have more than one author.
        $book_author_table = $schema->createTable('book_author');
        $book_author_table->addColumn('book_id', 'integer', ['unsigned' => true]);
        $book_author_table->addColumn('author_id', 'integer', ['unsigned' => true]);
        $book_author_table->addForeignKeyConstraint($book_table, ['book_id'], ['id'], [
            'onUpdate' => 'CASCADE',
            'onDelete' => 'CASCADE',
        ]);
        $book_author_table->addForeignKeyConstraint($author_table, ['author_id'], ['id'], [
            'onUpdate' => 'CASCADE',
            'onDelete' => 'CASCADE',
        ]);
        $book_author_table->setPrimaryKey(['book_id', 'author_id']);

        // Log for books read.
        $read_log_table = $schema->createTable('read_log');
        $read_log_table->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement' => true]);
        $read_log_table->addColumn('note', 'text', ['collation' => 'utf8mb4_bin']);
        $read_log_table->addColumn('book_id', 'integer', ['unsigned' => true]);
        $read_log_table->addColumn('user_id', 'integer', ['unsigned' => true]);
        $read_log_table->addColumn('date_read', 'datetime');
        $read_log_table->addColumn('date_created', 'datetime');
        $read_log_table->addColumn('date_updated', 'datetime');
        $read_log_table->setPrimaryKey(['id']);
        $read_log_table->addForeignKeyConstraint($user_table, ['user_id'], ['id']);
        $read_log_table->addForeignKeyConstraint($book_table, ['book_id'], ['id']);
        $read_log_table->addOption('charset', 'utf8mb4');
        $read_log_table->addOption('collate', 'utf8mb4_bin');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('book_author');
        $schema->dropTable('read_log');
        $schema->dropTable('book');
        $schema->dropTable('author');
        $schema->dropTable('user');
    }
}
