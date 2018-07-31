<?php


class Magentotutorial_Helloworld_Adminhtml_ContactController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Contact requests'))->_title($this->__('My Contact'));
        $this->loadLayout();
        $this->_setActiveMenu('cms/my_contacts');
        $this->_addContent($this->getLayout()->createBlock('helloworld/adminhtml_contact'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock(helloworld/adminhtml_contact_grid)->toHtml()
        );
    }

    public function exportCsvAction()
    {
        $fileName = 'contacts.csv';
        $grid = $this->getLayout()->createBlock('helloworld/adminhtml_contact_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    public function exportExcelAction()
    {
        $fileName = 'contacts.xml';
        $grid = $this->getLayout()->createBlock('helloworld/adminhtml_contact_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

    // edit section

    public function newAction()
    {
        // the same form is used to create and edit
        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_title($this->__('Contact Request'));

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('request_id');
        $model = Mage::getModel('helloworld/contact');

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('helloworld')->__('This block no longer exists.'));
                $this->_redirect('');
                return;
            }
        }

        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Request'));


        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }


        Mage::register('contact_request', $model);


        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('techtalk/adminhtml_contact_edit'));
        $this->_setActiveMenu('cms/my_contacts')
            ->_addBreadcrumb($id ? Mage::helper('techtalk')->__('Edit Request') : Mage::helper('techtalk')->__('New Request'), $id ? Mage::helper('techtalk')->__('Edit Request') : Mage::helper('techtalk')->__('New Request'))
            ->renderLayout();
    }

    public function saveAction() {

    }

    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/my_contacts');
    }
}
