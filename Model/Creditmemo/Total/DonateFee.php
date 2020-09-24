<?php

namespace Dev69\DonateService\Model\Creditmemo\Total;

use Magento\Sales\Model\Order\Creditmemo\Total\AbstractTotal;

class DonateFee extends AbstractTotal
{
    /**
     * @param \Magento\Sales\Model\Order\Creditmemo $creditmemo
     * @return $this
     */
    public function collect(\Magento\Sales\Model\Order\Creditmemo $creditmemo)
    {
        $creditmemo->setDonatefee(0);
        $creditmemo->setBaseDonatefee(0);

        $amount = $creditmemo->getOrder()->getDonatefee();
        $creditmemo->setDonatefee($amount);

        $amount = $creditmemo->getOrder()->getBaseDonatefee();
        $creditmemo->setBaseDonatefee($amount);

        $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $creditmemo->getDonatefee());
        $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $creditmemo->getBaseDonatefee());

        return $this;
    }
}
