<?php

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class Testimonial extends DataObject
{
    /**
     * Default sort ordering
     * @var array
     */
    private static $default_sort = ['Created' => 'DESC'];
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Quoter'            =>  'Varchar(128)',
        'Content'           =>  'Text',
        'Rating'            =>  'Int'
    ];
    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'QuoterPortrait'    =>  'Image',
        'Page'              =>  'TestimonialsPage'
    ];

    /**
     * Defines summary fields commonly used in table columns
     * as a quick overview of the data for this dataobject
     * @var array
     */
    private static $summary_fields = [
        'Quoter'            =>  'Quoter',
        'Rating'            =>  'Rating',
        'Content'           =>  'Testimonial'
    ];

    public function getTitle()
    {
        return $this->Title();
    }

    public function Title()
    {
        return $this->Quoter;
    }

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName([
            'PageID',
            'Rating'
        ]);

        $fields->addFieldToTab(
            'Root.Main',
            DropdownField::create(
                'Rating',
                'Rating',
                [
                    '1'             =>  '1',
                    '2'             =>  '2',
                    '3'             =>  '3',
                    '4'             =>  '4',
                    '5'             =>  '5',
                ]
            )->setEmptyString('- select one -'),
            'Quoter'
        );

        return $fields;
    }

    public function getData()
    {
        return  [
                    'quoter'        =>  $this->Quoter,
                    'rating'        =>  $this->Rating,
                    'content'       =>  str_replace("\n", '<br />', $this->Content),
                    'portrait'      =>  $this->QuoterPortrait()->exists() ? $this->QuoterPortrait()->FillMax(200,200)->URL : null
                ];
    }
}
