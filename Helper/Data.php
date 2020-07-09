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
    )
    {
        $this->productFactory = $productFactory;
        $this->cart = $cart;
        $this->storeManager = $storeManager;
        $this->urlInterface = $urlInterface;
        $this->scopeConfig = $scopeConfig;
        $this->currency = $currency;
        parent::__construct($context);

    }

    public function getAmountFromConfig()
    {
        $amount = json_decode($this->scopeConfig->getValue('fidesio_donate_section/fidesio_donate_dynamic_config/amounts'));
        $arrReturn = [];
        if (!empty($amount)) {
            foreach ((array)($amount) as $item) {
                $arrReturn[] = array('value' => $item->amounts, 'label' => $item->amounts);
            }
            return ($arrReturn);
        }
        return false;

    }

    public function getImageFromConfig()
    {
        $image = $this->scopeConfig->getValue('fidesio_donate_section/fidesio_donate_dynamic_config/upload_image_id');
        if (!empty($image))
            return $this->urlInterface->getBaseUrl() . 'media/' . DonateImage::UPLOAD_DIR . '/' . $image;

    }

    public function getDescriptionFromConfig()
    {
        $description = $this->scopeConfig->getValue('fidesio_donate_section/fidesio_donate_dynamic_config/editor_textarea');
        return $description;
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

        $params = array();
        $options = array();
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