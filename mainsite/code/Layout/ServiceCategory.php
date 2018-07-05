<?php

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class ServiceCategory extends Page
{
    private static $show_in_sitetree = false;
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Subtitle'      =>  'Varchar(512)',
        'Abstract'      =>  'Text'
    ];
    /**
     * Defines whether a page can be in the root of the site tree
     * @var boolean
     */
    private static $can_be_root = false;
    /**
     * Defines the allowed child page types
     * @var array
     */
    private static $allowed_children = [
        'ServicePage'
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
        return Versioned::get_by_stage('ServiceList', 'Stage')->count() > 0;
    }

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'Background'                =>  'SaltedCroppableImage'
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
                TextField::create(
                    'Subtitle',
                    'Subtitle'
                ),
                TextareaField::create(
                    'Abstract',
                    'Abstract'
                )
            ],
            'URLSegment'
        );

        // $children_pages             =   $fields->fieldByName('Root.ChildPages.ChildPages');
        // $fields->removeByName('ChildPages');
        //
        // $fields->addFieldToTab(
        //     'Root.Main',
        //     $children_pages
        // );

        $fields->addFieldsToTab(
            'Root.PreviewTile',
            [
                CroppableImageField::create(
                    'BackgroundID',
                    'Background'
                )->setCropperRatio(4/3)
            ]
        );

        return $fields;
    }

    /**
     * Event handler called after writing to the database.
     */
    public function onAfterWrite()
    {
        parent::onAfterWrite();
        if ($this->Children()->filter(['Title' => 'New Zealand'])->count() == 0) {
            $nz                     =   ServicePage::create();
            $nz->Title              =   'New Zealand';
            $nz->ParentID           =   $this->ID;
            $nz->write();
            $nz->doPublish();
        }

        if ($this->Children()->filter(['Title' => 'Australia'])->count() == 0) {
            $nz                     =   ServicePage::create();
            $nz->Title              =   'Australia';
            $nz->ParentID           =   $this->ID;
            $nz->write();
            $nz->doPublish();
        }
    }

    public function getData()
    {
        $children                   =   $this->Children();
        return  [
                    'title'         =>  $this->Title,
                    'subtitle'      =>  $this->Subtitle,
                    'abstract'      =>  str_replace("\n", '<br />', $this->Abstract),
                    'background'    =>  $this->Background()->exists() ?
                                        $this->Background()->getCropped()->URL :
                                        'https://via.placeholder.com/800x600',
                    'url'           =>  $this->Link(),
                    'content'       =>  $this->Content,
                    'hero'          =>  $this->Hero()->exists() ? $this->Hero()->getCropped()->SetWidth(1920)->URL : null,
                    'services'      =>  $children->getData()
                ];
    }
}

class ServiceCategory_Controller extends Page_Controller
{
    public function init()
    {
        parent::init();
    }

    public function AjaxResponse()
    {
        if (Director::isLive()) {
            $data                   =   SaltedCache::read('PageDataCache', $this->ID);
        }

        if (empty($data)) {
            $data                   =   parent::AjaxResponse();
            $data                   =   array_merge($data, $this->getData());

            if (Director::isLive()) {
                SaltedCache::save('PageDataCache', $this->ID, $data);
            }
        }

        return $data;
    }
}
