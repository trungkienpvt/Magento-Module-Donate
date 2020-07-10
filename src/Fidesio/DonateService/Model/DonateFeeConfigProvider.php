<?php
namespace Fidesio\DonateService\Model;

use Magento\Checkout\Model\ConfigProviderInterface;

class DonateFeeConfigProvider implements ConfigProviderInterface
{
    /**
     * @var \Fidesio\DonateService\Helper\Data
     */
    protected $dataHelper;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param \Fidesio\DonateService\Helper\Data $dataHelper
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Fidesio\DonateService\Helper\Data $dataHelper,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Psr\Log\LoggerInterface $logger

    )
    {
        $this->dataHelper = $dataHelper;
        $this->checkoutSession = $checkoutSession;
        $this->logger = $logger;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        $customFeeConfig = [];
        $enabled = $this->dataHelper->isModuleEnabled();
        $customFeeConfig['fee_label'] = $this->dataHelper->getFeeLabel();
        $quote = $this->checkoutSession->getQuote();
        $subtotal = $quote->getSubtotal();
        $customFeeConfig['custom_fee_amount'] = $this->dataHelper->getAmountFromConfig();
        $customFeeConfig['show_hide_customfee_block'] = ($enabled && $quote->getDonatefee()) ? true : false;
        return $customFeeConfig;
    }
}
