<?php

use yii\db\Query;

/**
 * Class m181019_083351_create_table_attachment
 */
class m181019_083351_create_table_attachment extends yii\db\Migration
{
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attachment}}', [
            'id' => $this->bigPrimaryKey(),
            'format' => $this->string(10)->notNull()->comment('文件格式'),
            'path' => $this->string(50)->notNull()->comment('hashed 相对路径'),
            'name' => $this->string(100)->comment('原始文件名'),
            'visible' => $this->boolean()->notNull()->defaultValue(1),
        ], $this->tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%attachment}}');

        echo "m181019_083351_create_table_attachment cannot be reverted.\n";

        return false;
    }
}
