<?php

use yii\db\Query;

/**
 * Class m181023_025110_add_column_category_to_table_attachment
 */
class m181023_025110_add_column_category_to_table_attachment extends yii\db\Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%attachment}}', 'category', $this->string(50)->notNull()->comment('分类')->after('id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%attachment}}', 'category');
    }
}
