<?php
namespace Fidesio\DonateService\Block\Adminhtml\Sales\Order\Invoice;



class Donatefee extends \Magento\Framework\View\Element\Template
{
    protected $_config;
    protected $_order;
    protected $_source;
    protected $_helper;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Tax\Model\Config $taxConfig,
        \Fidesio\DonateService\Helper\Data $dataHelper,
        array $data = []
    ) {
        $this->_helper = $dataHelper;
        $this->_config = $taxConfig;
        parent::__construct($context, $data);
    }

    public function displayFullSummary()
    {
        return true;
    }

    public function getSource()
    {
        return $this->_source;
    }
    public function getStore()
    {
        return $this->_order->getStore();
    }
    public function getOrder()
    {
        return $this->_order;
    }
    public function getLabelProperties()
    {
        return $this->getParentBlock()->getLabelProperties();
    }

    public function getValueProperties()
    {
        return $this->getParentBlock()->getValueProperties();
    }
    public function initTotals()
    {
        $parent = $this->getParentBlock();
        $this->_order = $parent->getOrder();
        $this->_source = $parent->getSource();

        $store = $this->getStore();

        $fee = new \Magento\Framework\DataObject(
            [
                'code' => 'donatefee',
                'strong' => false,
                'value' => $this->_order->getDonatefee(),
                'base_value' => $this->_order->getDonatefee(),
                'label' => $this->_helper->getFeeLabel(),
            ]
        );
        $parent->addTotal($fee, 'donatefee');
        return $this;

    }

}