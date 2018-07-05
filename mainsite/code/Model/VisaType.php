<?php

use SaltedHerring\Grid;

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class VisaType extends DataObject
{
    /**
     * Defines summary fields commonly used in table columns
     * as a quick overview of the data for this dataobject
     * @var array
     */
    private static $summary_fields = [
        'Title'         =>  'VISA Category',
        'ListSubTypes'  =>  'Sub Categories'
    ];

    /**
     * Default sort ordering
     * @var array
     */
    private static $default_sort = ['SortOrder' => 'ASC'];

    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Title'         =>  'Varchar(128)'
    ];

    /**
     * Defines extension names and parameters to be applied
     * to this object upon construction.
     * @var array
     */
    private static $extensions = [
        'SortOrderExtension'
    ];

    /**
     * Has_many relationship
     * @var array
     */
    private static $has_many = [
        'SubTypes'      =>  'VisaType.ParentType'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'ParentType'    =>  'VisaType'
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        if (!$this->exists() || !$this->ParentType()->exists()) {
            $fields->removeByName([
                'ParentTypeID'
            ]);
        }

        if ($this->exists()) {
            $fields->removeByName([
                'SubTypes'
            ]);

            $fields->addFieldToTab(
                'Root.Main',
                Grid::make('SubTypes', 'Sub categories', $this->SubTypes())
            );
        }

        return $fields;
    }

    public function ListSubTypes()
    {
        if ($this->SubTypes()->exists()) {
            return implode(', ', $this->SubTypes()->column('Title'));
        }

        return '- No sub category -';
    }

    public function getData()
    {
        return  [
                    'title'     =>  $this->Title,
                    'subs'      =>  $this->SubTypes()->exists() ? $this->SubTypes()->getData() : null
                ];
    }
}
