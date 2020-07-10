<?php

namespace Fidesio\DonateService\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $columns = [
            'donatefee' => [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                'nullable' => true,
                '10,2',
                'default' => 0.00,
                'comment' => 'Donate fee',
            ],
            'base_donatefee' => [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                'nullable' => true,
                '10,2',
                'default' => 0.00,
                'comment' => 'Donate fee',
            ]

        ];
        $connection = $installer->getConnection();
        $arrayTable = [
            'sales_invoice',
            'sales_order',
            'quote',
            'quote_address',
            'quote_item',
            'sales_creditmemo'
        ];
        foreach ($columns as $name => $definition) {

            foreach ($arrayTable as $item) {
                $eavTable = $installer->getTable($item);
                $connection->addColumn($eavTable, $name, $definition);

            }

        }

        $installer->endSetup();
    }
}