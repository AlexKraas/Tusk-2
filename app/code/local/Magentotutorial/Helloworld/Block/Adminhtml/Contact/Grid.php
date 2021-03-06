<?php

class Magentotutorial_Helloworld_Block_Adminhtml_Contact_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('contact_grid');
        $this->_controller = 'adminhtml_contact';
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('helloworld/contact_collection');
        $this->setCollection($collection);
        parent::_prepareCollection();
        //var_dump($collection);die('www');
        return $this;
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('helloworld');

        $this->addColumn('id', [
            'header' => $helper->__('Request #'),
            'index' => 'request_id',
        ]);

        $this->addColumn('name', [
            'header' => $helper->__('Contact Name'),
            'type' => 'text',
            'index' => 'name',
        ]);

        $this->addColumn('contact', [
            'header' => $helper->__('Comment'),
            'type' => 'text',
            'index' => 'contact',
        ]);
        $this->addExportType('*/*/exportCsv', $helper->__('CSV'));
        $this->addExportType('*/*/exportExcel', $helper->__('Excel XML'));
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', ['request_id' => $row->getRequestId()]);
    }

    public function getGridUrl($params = [])
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
}