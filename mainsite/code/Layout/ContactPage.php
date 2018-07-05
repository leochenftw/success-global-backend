<?php
use SaltedHerring\Grid;
/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class ContactPage extends Page
{
    /**
     * Has_many relationship
     * @var array
     */
    private static $has_many = [
        'Branches'      =>  'Branch'
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        if ($this->exists()) {
            $fields->addFieldToTab(
                'Root.Branches',
                Grid::make('Branches', 'Branches', $this->Branches())
            );
        }
        return $fields;
    }

    public function getData()
    {
        return  [
                    'title'     =>  $this->Title,
                    'hero'      =>  $this->Hero()->exists() ? $this->Hero()->getCropped()->SetWidth(1920)->URL : null,
                    'content'   =>  $this->Content,
                    'branches'  =>  $this->Branches()->getData()
                ];
    }
}

class ContactPage_Controller extends Page_Controller
{
    public function init()
    {
        parent::init();
    }
}
