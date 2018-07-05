<?php

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class TeamMember extends DataObject
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Fullname'                  =>  'Varchar(128)',
        'Role'                      =>  'Varchar(32)',
        'Content'                   =>  'Text'
    ];

    /**
     * Defines summary fields commonly used in table columns
     * as a quick overview of the data for this dataobject
     * @var array
     */
    private static $summary_fields = [
        'Fullname'                  =>  'Name',
        'Role'                      =>  'Role'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'Portrait'                  =>  'SaltedCroppableImage',
        'Office'                    =>  'Branch',
        'Page'                      =>  'TeamPage'
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
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields                     =   parent::getCMSFields();

        $fields->addFieldsToTab(
            'Root.Main',
            [
                CroppableImageField::create('PortraitID', 'Portrait')->setCropperRatio(1/1),
                DropdownField::create('OfficeID', 'Office', Branch::get()->map()->toArray())->setEmptyString('- select one -')
            ]
        );

        $fields->removeByName([
            'PageID'
        ]);

        return $fields;
    }

    public function getData()
    {
        return  [
                    'fullname'      =>  $this->Fullname,
                    'role'          =>  $this->Role,
                    'content'       =>  str_replace("\n", '<br />', $this->Content),
                    'branch'        =>  $this->Office()->exists() ? $this->Office()->Title : 'Independent Contractors',
                    'portraits'     =>  $this->Portrait()->exists() ?
                                        [
                                            'thumbnail'     =>  $this->Portrait()->getCropped()->SetWidth(540)->URL,
                                            'original'      =>  $this->Portrait()->Original()->FillMax(720, 500)->URL
                                        ]:
                                        null
                ];
    }
}
