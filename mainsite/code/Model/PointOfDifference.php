<?php


/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class PointOfDifference extends DataObject
{
    /**
     * Database fields
     * @var array
     */
    private static $db  = [
        'Title'                 =>  'Varchar(128)',
        'Content'               =>  'HTMLText'
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
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'Image'                 =>  'SaltedCroppableImage',
        'Page'                  =>  'PointsOfDifferencePage'
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields                 =   parent::getCMSFields();
        $fields->removeByName([
            'PageID',
            'ImageID'
        ]);

        $fields->addFieldToTab(
            'Root.Main',
            CroppableImageField::create(
                'ImageID',
                'Image'
            )->setCropperRatio(4/3),
            'Content'
        );

        return $fields;
    }

    public function getData()
    {
        return  [
                    'title'     =>  $this->Title,
                    'content'   =>  $this->Content,
                    'image'     =>  $this->Image()->exists() ?
                                    $this->Image()->getCropped()->URL :
                                    'https://via.placeholder.com/800x600',
                ];
    }
}
