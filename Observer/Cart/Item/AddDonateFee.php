<?php
/**
 * Webkul Hello CustomPrice Observer
 *
 * @category    Webkul
 * @package     Webkul_Hello
 * @author      Webkul Software Private Limited
 *
 */
namespace Fidesio\DonateService\Observer\Cart\Item;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;

class AddDonateFee implements ObserverInterface
{
    protected $_request;

    protected $_helper;
    /**
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request){
        $this->_request = $request;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $item = $observer->getQuoteItem();
        $quote = $item->getQuote();
        $additionalOptions = array();

        if ($additionalOption = $item->getOptionByCode('donatefee')){
            $additionalOptions = (array) unserialize($additionalOption->getValue());
        }

        $post = $this->_request->getParam('donatefee');

        if(!empty($post)){

            $additionalOptions[] = [
                'label' => 'Donate fee',
                'value' => $post
            ];
        }

        if(count($additionalOptions) > 0){
            $item->addOption(array(
                'product_id' => $item->getProductId(),//Missing data
                'code' => 'donatefee',
                'value' => serialize($additionalOptions)
            ));
        }

        $items = $quote->getAllItems();
        $totalDonateFee = 0;
        foreach ($items as $i) {
            $additionalOption = $i->getOptionByCode('donatefee');
            if(!empty($additionalOption)) {
                $additionalOptionValue = unserialize($additionalOption->getValue());
                $donateFee = $additionalOptionValue[0]['value'];
                $totalDonateFee += $donateFee;
            }

        }

        // Logic to set fees only if the item print type combo is not already in the cart
        $quote->setDonatefee($totalDonateFee);
        return $this;
    }

}