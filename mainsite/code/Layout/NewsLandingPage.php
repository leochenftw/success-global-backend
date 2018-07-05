<?php

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class NewsLandingPage extends Page
{
    /**
     * Defines the allowed child page types
     * @var array
     */
    private static $allowed_children = [
        'NewsPage'
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
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        return $fields;
    }

    public function getData()
    {
        $children           =   $this->Children()->limit(4);

        return $children->getData();
    }
}

class NewsLandingPage_Controller extends Page_Controller
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
            $data['hero']           =   $this->Hero()->exists() ?
                                        $this->Hero()->getCropped()->SetWidth(1920)->URL :
                                        'https://via.placeholder.com/1920x800';
            $data['newsitems']      =   [];
            $newsitems              =   $this->Children()->limit(10);
            foreach ($newsitems as $newsitem)
            {
                $data['newsitems'][]=   [
                                            'title'     =>  $newsitem->Title,
                                            'slug'      =>  $newsitem->URLSegment,
                                            'content'   =>  $newsitem->Content,
                                            'thumb'     =>  $newsitem->Image()->exists() ?
                                                            $newsitem->Image()->SetWidth(470)->URL :
                                                            null,
                                            'date'      =>  !empty($newsitem->Date) ?
                                                            $newsitem->Date :
                                                            $newsitem->Created
                                        ];
            }

            if (Director::isLive()) {
                SaltedCache::save('PageDataCache', $this->ID, $data);
            }
        }

        return $data;
    }
}
