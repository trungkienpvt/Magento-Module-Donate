<?php

namespace Fidesio\DonateService\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Checkout\Model\Cart;
use Magento\Catalog\Model\ProductFactory;
use Fidesio\DonateService\Model\Config\Backend\Image as DonateImage;

class Data extends AbstractHelper
{

    /**
     * Custom fee config path
     */
    const CONFIG_CUSTOM_IS_ENABLED = 'donatefee/donatefee/status';
    const CONFIG_CUSTOM_FEE = 'donatefee/donatefee/amounts';
    const CONFIG_FEE_LABEL = 'donatefee/donatefee/title';
    const CONFIG_FEE_DESCRIPTION = 'donatefee/donatefee/description';
    const CONFIG_FEE_IMAGE = 'donatefee/donatefee/image';

    protected $storeManager;
    protected $urlInterface;
    protected $scopeConfig;
    protected $currency;
    private $cart;
    private $productFactory;

    public function __construct(
        Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\UrlInterface $urlInterface,
        \Magento\Directory\Model\Currency $currency,
        Cart $cart,
        ProductFactory $productFactory
    ) {
        $this->productFactory = $productFactory;
        $this->cart = $cart;
        $this->storeManager = $storeManager;
        $this->urlInterface = $urlInterface;
        $this->scopeConfig = $scopeConfig;
        $this->currency = $currency;
        parent::__construct($context);
    }

    /**
     * @return mixed
     */
    public function isModuleEnabled()
    {

        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $isEnabled = $this->scopeConfig->getValue(self::CONFIG_CUSTOM_IS_ENABLED, $storeScope);
        return $isEnabled;
    }

    /**
     * Get custom fee
     *
     * @return mixed
     */
    public function getdonatefee()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $fee = $this->scopeConfig->getValue(self::CONFIG_CUSTOM_FEE, $storeScope);
        return $fee;
    }

    /**
     * Get custom fee
     *
     * @return mixed
     */
    public function getFeeLabel()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $feeLabel = $this->scopeConfig->getValue(self::CONFIG_FEE_LABEL, $storeScope);
        return $feeLabel;
    }

    public function getFeeDescription()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $feeDescription = $this->scopeConfig->getValue(self::CONFIG_FEE_DESCRIPTION, $storeScope);
        return $feeDescription;
    }


    public function getAmountFromConfig()
    {
        $amount = json_decode($this->scopeConfig->getValue(self::CONFIG_CUSTOM_FEE));
        $arrReturn = [];
        if (!empty($amount)) {
            foreach ((array)($amount) as $item) {
                $arrReturn[] = ['value' => $item->amounts, 'label' => $item->amounts];
            }
            return ($arrReturn);
        }
        return false;
    }

    public function getImageFromConfig()
    {
        $image = $this->scopeConfig->getValue(self::CONFIG_FEE_IMAGE);
        if (!empty($image)) {
            return $this->urlInterface->getBaseUrl() . 'media/' . DonateImage::UPLOAD_DIR . '/' . $image;
        }
    }


    public function getCurrentCurrencyCode()
    {
        return $this->storeManager->getStore()->getCurrentCurrencyCode();
    }

    public function getCurrentCurrencySymbol()
    {
        return $this->currency->getCurrencySymbol();
    }

    public function getAddCustomProduct($productId)
    {
        $product = $this->productFactory->load($productId);

        $cart = $this->cart;

        $params = [];
        $options = [];
        $params['qty'] = 1;
        $params['product'] = $productId;

        foreach ($product->getOptions() as $o) {
            foreach ($o->getValues() as $value) {
                $options[$value['option_id']] = $value['option_type_id'];

            }
        }

        $params['options'] = $options;
        $cart->addProduct($product, $params);
        $cart->save();
    }
}
