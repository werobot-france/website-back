<?php

use Phinx\Migration\AbstractMigration;

class CreatePostsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('posts')
            ->addColumn('title', 'string')
            ->addColumn('content', 'text')
            ->addColumn('slug', 'string')
            ->addColumn('image', 'text')
            ->addColumn('locale', 'string')
            ->addColumn('identifier', 'string', ['null' => true])
            ->addColumn('description', 'string', ['null' => true])
            ->addColumn('user_id', 'string', ['null' => true])
            ->addColumn('created_at', 'datetime', ['null' => true])
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->create();

        $this->table('posts')
            ->changeColumn('id','string')
            ->update();
    }
}
