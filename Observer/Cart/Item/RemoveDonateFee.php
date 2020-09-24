<?php
/**
 * Webkul Hello CustomPrice Observer
 *
 * @category    Webkul
 * @package     Webkul_Hello
 * @author      Webkul Software Private Limited
 *
 */
namespace Dev69\DonateService\Observer\Cart\Item;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\RequestInterface;

class RemoveDonateFee implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {


        $item = $observer->getEvent()->getQuoteItem();
        $quote = $item->getQuote();
        $items = $quote->getAllItems();
        $totalDonateFee = 0;
        foreach ($items as $i) {
            $additionalOption = $i->getOptionByCode('donatefee');
            if (!empty($additionalOption)) {
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
