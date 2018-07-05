<?php

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class ContactNumber extends DataObject
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Title'         =>  'Varchar(32)',
        'Phone'         =>  'Varchar(32)',
        'IconClass'     =>  'Varchar(64)',
        'Protocol'      =>  'Varchar(32)',
        'CallParams'    =>  'Varchar(256)'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'Branch'    =>  'Branch'
    ];

    public function getData()
    {
        return  [
                    'title'         =>  $this->Title,
                    'phone'         =>  $this->Phone,
                    'icon'          =>  $this->IconClass,
                    'protocol'      =>  empty($this->Protocol) ? 'tel:' : $this->Protocol,
                    'params'        =>  $this->CallParams
                ];
    }
}
