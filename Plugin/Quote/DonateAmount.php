<?php

namespace Dev69\DonateService\Plugin\Quote;

use Magento\Quote\Model\Cart\ShippingMethodConverter;
use Magento\Quote\Api\Data\ShippingMethodInterface;
use Magento\Quote\Api\Data\ShippingMethodExtensionFactory;

class DonateAmount
{
    /**
     * Hook into setShippingMethod.
     * As this is magic function processed by __call method we need to hook around __call
     * to get the name of the called method. after__call does not provide this information.
     *
     * @param Address $subject
     * @param callable $proceed
     * @param string $method
     * @param mixed $vars
     * @return Address
     */
    public function around__call($subject, $proceed, $method, $vars)
    {
        $result = $proceed($method, $vars);
        if ($method == 'setDonate' && $subject->getExtensionAttributes()) {
            $amountValue = $subject->getExtensionAttributes()->getDonate();
            if (!empty($amountValue)) {
                $subject->setDonate($subject->getExtensionAttributes()->getDonate());
            }
        }
        return $result;
    }
}
