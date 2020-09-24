<?php
namespace Dev69\DonateService\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Store\Model\StoreManagerInterface;
use Dev69\DonateService\Helper\Data;

class Index extends Template
{
    public function __construct(Context $context, StoreManagerInterface $storeManager, Data $helperData)
    {
        $this->_storeManager = $storeManager;
        $this->_helperData = $helperData;
        parent::__construct($context);
    }

    public function showHelloWorld()
    {

        return $this->_helperData->HelloWorld();
    }
}
