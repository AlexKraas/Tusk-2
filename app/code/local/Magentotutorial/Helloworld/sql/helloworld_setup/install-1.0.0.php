<?php

$installer = $this;
$installer->startSetup();

$table = $installer->getConnection()
    ->newTable($this->getTable('helloworld/contact'))
    ->addColumn('mycontact_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true
    ))
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable' => false
    ))
    ->addColumn('comment', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
        'nullable' => false
    ));

$installer->getConnection()->createTable($table);
