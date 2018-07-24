<?php

class Magentotutorial_Helloworld_Block_View extends Mage_Core_Block_Template
{
    public function getRequestedRecord()
    {
        return Mage::getModel('helloworld/contact')->load(1);
    }
}
	