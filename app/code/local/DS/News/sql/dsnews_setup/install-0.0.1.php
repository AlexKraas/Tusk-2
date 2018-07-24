<?php

$installer = $this;
$tableNews = $installer->getTable('dsnews/table_news');
INSERT INTO `ds_news_entities` VALUES
    (NULL, 'News 1', 'News 1 Content', '2013-10-16 17:45'),
    (NULL, 'News 2', 'News 2 Content', '2013-11-07 04:12'),
    (NULL, 'News 3', 'News 3 Content', '2014-01-12 15:55');


$installer->startSetup();

$installer->getConnection()->dropTable($tableNews);
$table = $installer->getConnection()
    ->newTable($tableNews)
    ->addColumn('news_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ))
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, '255', array(
        'nullable'  => false,
        ))
    ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => false,
        ))
    ->addColumn('created', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(
        'nullable'  => false,
    ));
	
$installer->getConnection()->createTable($table);

$installer->endSetup();
