<?php
namespace Fidesio\DonateService\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\Data\Form\Element\Text;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;
use Fidesio\DonateService\Block\Adminhtml\Form\Field\TaxColumn;

/**
 * Class Ranges
 */
class Amount extends AbstractFieldArray
{
    /**
     * @var TaxColumn
     */
    private $amountRenderer;

    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
        $this->addColumn('amounts', ['label' => __('Amount'), 'class' => 'required-entry validate-currency-dollar']);

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }


}
