<?php

class Magentotutorial_Helloworld_Model_Contact extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('helloworld/contact');
    }
} 