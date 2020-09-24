<?php

namespace Dev69\DonateService\Model\Invoice\Total;

use Magento\Sales\Model\Order\Invoice\Total\AbstractTotal;

class DonateFee extends AbstractTotal
{
    /**
     * @param \Magento\Sales\Model\Order\Invoice $invoice
     * @return $this
     */
    public function collect(\Magento\Sales\Model\Order\Invoice $invoice)
    {
        $invoice->setDonatefee(0);
        $invoice->setBaseDonatefee(0);

        $amount = $invoice->getOrder()->getDonatefee();
        $invoice->setDonatefee($amount);
        $amount = $invoice->getOrder()->getBaseDonatefee();
        $invoice->setBaseDonatefee($amount);

        $invoice->setGrandTotal($invoice->getGrandTotal() + $invoice->getDonatefee());
        $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $invoice->getDonatefee());

        return $this;
    }
}
