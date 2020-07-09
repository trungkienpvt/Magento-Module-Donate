<?php

namespace Fidesio\DonateService\Block;

use \Fidesio\DonateService\Helper\Data;
use \Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;
use Fidesio\DonateService\Model\Config\Backend\Image as DonateImage;
class Donation extends Template
{

    protected $storeManager;
    protected $urlInterface;
    protected $scopeConfig;
    protected $amount;
    protected $helper;

    public function __construct(
        Context $context, array $data = [],
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $urlInterface,
        \Fidesio\DonateService\Helper\Data $helper

    )

    {
        parent::__construct($context, $data);
        $this->storeManager = $storeManager;
        $this->urlInterface = $urlInterface;
        $this->scopeConfig = $scopeConfig;
        $this->helper = $helper;
    }

    public function getAmountFromConfig()
    {
        return $this->helper->getAmountFromConfig();

    }

    public function getImageFromConfig()
    {
        return $this->helper->getImageFromConfig();

    }
    public function getDescriptionFromConfig() {
        return $this->helper->getDescriptionFromConfig();
    }

    public function getCurrentCurrency() {
        return $this->helper->getCurrentCurrencyCode();
    }
    public function getCurrentCurrencySymbol() {
        return $this->helper->getCurrentCurrencySymbol();
    }



}