<?php
namespace Fidesio\DonateService\Block;

use \Magento\Framework\View\Element\Template;
use \Magento\Framework\View\Element\Template\Context;
use \Magento\Store\Model\StoreManagerInterface;
use Fidesio\DonateService\Helper\Data;

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
