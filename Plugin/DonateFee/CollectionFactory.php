<?php
namespace Fidesio\DonateService\Plugin\DonateFee;


class CollectionFactory
{

    public function aroundGetReport(
        \Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory $subject,
        \Closure $proceed,
        $requestName
    )
    {
        $result = $proceed($requestName);
        if ($requestName == 'sales_order_grid_data_source') {
            if ($result instanceof \Magento\Sales\Model\ResourceModel\Order\Grid\Collection) {

                $result->addExpressionFieldToSelect('donatefee', new \Zend_Db_Expr('IFNULL(mss.donatefee, "Head Office")'), []);
                $result->getSelect()->joinLeft(
                    ['so' => $result->getTable('sales_order')],
                    'so.increment_id = main_table.increment_id AND so.store_id = main_table.store_id',
                    ['so.placed_by']
                )
                    ->joinLeft(
                        ['au' => $result->getTable('admin_user')],
                        'au.user_id = so.placed_by',
                        ['au.storepickup_id']
                    )
                    ->joinLeft(
                        ['mss' => $result->getTable('magestore_storepickup_store')],
                        "mss.storepickup_id = au.storepickup_id",
                        [])
                ;
            }
        }
        return $result;
    }
}