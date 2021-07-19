<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateShortUrls extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('short_urls', [
            'id' => false,
            'primary_key' => ['id']
        ]);
        $table->addColumn('id', 'string', [
            'default' => null,
            'limit' => 5,
            'null' => false,
        ]);
        $table->addColumn('url', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->create();
    }
}
