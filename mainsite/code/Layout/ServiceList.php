<?php

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class ServiceList extends Page
{
    /**
     * Belongs_to relationship
     * @var array
     */
    private static $defaults = [
        'Title'     =>  'Our Expertise'
    ];

    /**
     * Defines the allowed child page types
     * @var array
     */
    private static $allowed_children = [
        'ServiceCategory'
    ];

    /**
     * Defines extension names and parameters to be applied
     * to this object upon construction.
     * @var array
     */
    private static $extensions = [
        'Lumberjack'
    ];

    /**
     * Creating Permissions
     * @return boolean
     */
    public function canCreate($member = null)
    {
        return Versioned::get_by_stage('ServiceList', 'Stage')->count() == 0;
    }
    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName([
            'Content'
        ]);
        return $fields;
    }

    public function getData()
    {
        $children                   =   $this->Children();
        return  [
                    'title'         =>  $this->Title,
                    'content'       =>  $this->Content,
                    'hero'          =>  $this->Hero()->exists() ? $this->Hero()->getCropped()->SetWidth(1920)->URL : null,
                    'categories'    =>  $children->getData()
                ];
    }
}

class ServiceList_Controller extends Page_Controller
{
    public function init()
    {
        parent::init();
    }
}
