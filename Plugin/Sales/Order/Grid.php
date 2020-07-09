<?php

namespace Fidesio\DonateService\Plugin\Sales\Order;


class Grid
{

    public static $table = 'sales_order_grid';
    public static $leftJoinTable = 'donate_order';

    public function afterSearch($intercepter, $collection)
    {
        if ($collection->getMainTable() === $collection->getConnection()->getTableName(self::$table)) {

            $leftJoinTableName = $collection->getConnection()->getTableName(self::$leftJoinTable);

            $collection
                ->getSelect()
                ->joinLeft(
                    ['co'=>$leftJoinTableName],
                    "co.order_id = main_table.entity_id",
                    [
                        'amount' => 'co.amount'
                    ]
                );

            $where = $collection->getSelect()->getPart(\Magento\Framework\DB\Select::WHERE);

            $collection->getSelect()->setPart(\Magento\Framework\DB\Select::WHERE, $where);

            //echo $collection->getSelect()->__toString();die;


        }
        return $collection;


    }


}