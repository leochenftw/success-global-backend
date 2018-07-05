<?php
use SaltedHerring\Grid;
/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class PointsOfDifferencePage extends Page
{
    /**
     * Has_many relationship
     * @var array
     */
    private static $has_many = [
        'Points'                    =>  'PointOfDifference'
    ];

    /**
     * DataObject create permissions
     * @param Member $member
     * @param array $context Additional context-specific data which might
     * affect whether (or where) this object could be created.
     * @return boolean
     */
    public function canCreate($member = null, $context = [])
    {
        return Versioned::get_by_stage('PointsOfDifferencePage', 'Stage')->count() == 0;
    }

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if ($this->exists()) {
            $fields->addFieldsToTab(
                'Root.PointsOfDifference',
                [
                    Grid::make('Points', 'Points of Difference', $this->Points())
                ]
            );
        }

        return $fields;
    }

    public function getData()
    {
        return  [
                    'title'         =>  $this->Title,
                    'content'       =>  $this->Content,
                    'hero'          =>  $this->Hero()->exists() ?
                                        $this->Hero()->getCropped()->SetWidth(1920)->URL :
                                        null,
                    'points'        =>  $this->Points()->getData()
                ];
    }
}

class PointsOfDifferencePage_Controller extends Page_Controller
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
