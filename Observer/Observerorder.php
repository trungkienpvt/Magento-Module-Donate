<?php
namespace Fidesio\DonateService\Observer;
class Observeorder implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $quote = $observer->getEvent()->getQuote();
        $donateFee = $quote->getDonateFee();
        $extensions = $quote->getExtensionAttributes();
        $extensions->setDonateFee($donateFee);
        $quote->setExtensionAttributes($extensions);

        return $this;
    }
}