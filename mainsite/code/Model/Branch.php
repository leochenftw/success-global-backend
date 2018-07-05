<?php

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class Branch extends DataObject
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Title'             =>  'Varchar(64)',
        'Physical'          =>  'Text',
        'POBox'             =>  'Text',
        'Email'             =>  'Varchar(256)',
        'Lat'               =>  'Varchar(32)',
        'Lng'               =>  'Varchar(32)',
        'MapURL'            =>  'Text'
    ];

    /**
     * Has_many relationship
     * @var array
     */
    private static $has_many = [
        'ContactNumbers'    =>  'ContactNumber'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'ContactPage'       =>  'ContactPage'
    ];

    /**
     * Defines extension names and parameters to be applied
     * to this object upon construction.
     * @var array
     */
    private static $extensions = [
        'SortOrderExtension'
    ];

    public function getData()
    {
        return  [
                    'title'         =>  $this->Title,
                    'physical'      =>  str_replace("\n", '<br />', $this->Physical),
                    'pobox'         =>  str_replace("\n", '<br />', $this->POBox),
                    'email'         =>  $this->Email,
                    'lat'           =>  $this->Lat,
                    'lng'           =>  $this->Lng,
                    'url'           =>  $this->MapURL,
                    'options'       =>  $this->ContactNumbers()->getData()
                ];
    }
}
