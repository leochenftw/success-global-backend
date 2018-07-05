<?php

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class ServicePage extends Page
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
        'Abstract'      =>  'Text'
    ];


    /**
     * Creating Permissions
     * @return boolean
     */
    public function canCreate($member = null)
    {
        return Versioned::get_by_stage('ServiceCategory', 'Stage')->count() > 0;
    }

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields                     =   parent::getCMSFields();
        $fields->addFieldToTab(
            'Root.Main',
            TextareaField::create(
                'Abstract',
                'Abstract'
            ),
            'Content'
        );

        return $fields;
    }

    public function getData()
    {
        return  [
                    'title'         =>  $this->Title,
                    'abstract'      =>  str_replace("\n", '<br />', $this->Abstract),
                    'hero'          =>  $this->Hero()->exists() ? $this->Hero()->getCropped()->SetWidth(1920)->URL : null,
                    'link'          =>  $this->Link()
                ];
    }
}

class ServicePage_Controller extends Page_Controller
{
    public function init()
    {
        parent::init();
    }

    public function AjaxResponse()
    {
        if (Director::isLive()) {
            $data                       =   SaltedCache::read('PageDataCache', $this->ID);
        }

        if (empty($data)) {
            $data                       =   parent::AjaxResponse();
            $data                       =   array_merge($data, $this->getData());

            if (Director::isLive()) {
                SaltedCache::save('PageDataCache', $this->ID, $data);
            }
        }

        return $data;
    }
}
