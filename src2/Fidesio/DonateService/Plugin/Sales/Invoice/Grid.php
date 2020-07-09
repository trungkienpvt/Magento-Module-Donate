<?php
namespace Fidesio\DonateService\Plugin\Sales\Invoice;

use Magento\Framework\Message\ManagerInterface as MessageManager;
use Magento\Sales\Model\ResourceModel\Order\Grid\Collection as SalesOrderGridCollection;

class Grid
{
    private $messageManager;
    private $collection;

    public function __construct(
        MessageManager $messageManager,
        SalesOrderGridCollection $collection
    ) {
        $this->messageManager = $messageManager;
        $this->collection = $collection;
    }

    public function aroundGetReport(
        \Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory $subject,
        \Closure $proceed,
        $requestName
    ) {
        $result = $proceed($requestName);
        if ($requestName == 'sales_order_invoice_columns') {
            if ($result instanceof $this->collection
            ) {
                $select = $this->collection->getSelect();
                $select->joinLeft(
                    ["secondTable" => $this->collection->getTable("sales_invoice")],
                    'main_table.entity_id = secondTable.entity_id',
                    array('donate_amount')
                );
                return $this->collection;
            }
        }
        return $result;
    }
}