<?php

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class MenuItemExtension extends DataExtension
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'ScrollTo'      =>  'Varchar(32)'
    ];

    /**
     * Update Fields
     * @return FieldList
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->push(
            TextField::create(
                'ScrollTo',
                'Scroll to section'
            )
        );
        return $fields;
    }
}
