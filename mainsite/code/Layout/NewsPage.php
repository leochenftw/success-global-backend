<?php

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class NewsPage extends Page
{
    private static $show_in_sitetree = false;
    /**
     * Defines the allowed child page types
     * @var array
     */
    private static $allowed_children = [];
    /**
     * Defines whether a page can be in the root of the site tree
     * @var boolean
     */
    private static $can_be_root = false;

    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Date'          =>  'Date'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'Image'         =>  'Image'
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab(
            'Root.Main',
            UploadField::create(
                'Image',
                'Image'
            ),
            'Content'
        );

        return $fields;
    }

    public function getData()
    {
        return  [
                    'title'     =>  $this->Title,
                    'url'       =>  $this->Link(),
                    'thumb'     =>  $this->Image()->exists() ? $this->Image()->FillMax(140,140)->URL : null,
                    'date'      =>  !empty($this->Date) ? $this->Date : $this->Created
                ];
    }
}

class NewsPage_Controller extends Page_Controller
{
    public function init()
    {
        parent::init();
    }
}
