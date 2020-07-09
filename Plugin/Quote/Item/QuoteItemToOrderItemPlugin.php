<?php
namespace Fidesio\DonateService\Plugin\Quote\Item;

use Magento\Framework\Serialize\SerializerInterface;


class QuoteItemToOrderItemPlugin
{

    public function aroundConvert(
        \Magento\Quote\Model\Quote\Item\ToOrderItem $subject,
        \Closure $proceed,
        \Magento\Quote\Model\Quote\Item\AbstractItem $item,
        $additional = []
    ) {
        /** @var $orderItem Item */
        $orderItem = $proceed($item, $additional);
        $orderItem->setDonatefee($item->getDonatefee());
        return $orderItem;
    }

}
