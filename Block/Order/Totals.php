<?php
namespace Dev69\DonateService\Block\Order;

class Totals extends \Magento\Framework\View\Element\AbstractBlock
{
    public function initTotals()
    {

        $orderTotalsBlock = $this->getParentBlock();
        $order = $orderTotalsBlock->getOrder();
        if ($order->getDonatefee() > 0) {
            $orderTotalsBlock->addTotal(new \Magento\Framework\DataObject([
                'code'       => 'donatefee',
                'label'      => __('Donate Fee'),
                'value'      => $order->getDonatefee(),
                'base_value' => $order->getBaseDonatefee(),
            ]), 'subtotal');
        }
    }
}
