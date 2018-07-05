<?php

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class PaymentModelExtension extends DataExtension
{
    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'Order'         =>  'ConsultationSlot'
    ];
}
