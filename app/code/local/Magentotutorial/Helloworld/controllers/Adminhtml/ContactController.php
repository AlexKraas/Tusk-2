<?php


class Magentotutorial_Helloworld_Adminhtml_ContactController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Contact requests'))->_title($this->__('My Contact'));
        $this->loadLayout();
        $this->_setActiveMenu('cms/My Contact');
        $this->_addContent($this->getLayout()->createBlock('helloworld/adminhtml_contact'));
        $this->renderLayout();

    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('helloworld/adminhtml_contact_grid')->toHtml()
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

    public function newAction()
    {

        $this->_forward('edit');
    }

    public function editAction()
    {
        $this->_title($this->__('Contact requests'));


        $id = (int)$this->getRequest()->getParam('request_id');
        $model = Mage::getModel('helloworld/contact')->load($id);


        if ($id) {
            $model->load($id);
            if (!$model->getRequestId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('helloworld')->__('This block no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        $this->_title($model->getRequestId() ? $model->getTitle() : $this->__('New Requet'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register('current_contact', $model);

        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('helloworld/adminhtml_contact_edit'));
        $this->_setActiveMenu('cms/My Contact')
            ->_addBreadcrumb($id ? Mage::helper('helloworld')->__('Edit Request') : Mage::helper('helloworld')->__('New Request'),
                $id ? Mage::helper('helloworld')->__('Edit Request') : Mage::helper('helloworld')->__('New Request'))
            ->renderLayout();
    }

    public function saveAction()
    {

        if ($data = $this->getRequest()->getPost()) {
            try {

                $helper = Mage::helper('helloworld');

                $model = Mage::getModel('helloworld/contact');

                $model->setData($data)->setId($this->getRequest()->getParam('request_id'));

                $model->save();
                $id = $model->getId();

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Comment was saved success'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array(
                    'id' => $this->getRequest()->getParam('request_id')
                ));
            }
            return;
        }
        Mage::getSingleton('adminhtml/session')->addError($this->__('Unable to find item to save'));


        $this->_redirect('*/*/');
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/My Contact');
    }

    public function deleteAction()
    {
        $tipId = $this->getRequest()->getParam('request_id', false);

        try {
            Mage::getModel('helloworld/contact')->setId($tipId)->delete();
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('helloworld')->__('Comment success deleted'));

            return $this->_redirect('*/*/');
        } catch (Mage_Core_Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        } catch (Exception $e) {
            Mage::logException($e);
            Mage::getSingleton('adminhtml/session')->addError($this->__('Somethings went wrong'));
        }

        $this->_redirect('*/*/');
    }
}