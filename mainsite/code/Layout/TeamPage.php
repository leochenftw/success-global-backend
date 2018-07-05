<?php
use SaltedHerring\Grid;
/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class TeamPage extends Page
{
    /**
     * Has_many relationship
     * @var array
     */
    private static $has_many = [
        'TeamMembers'           =>  'TeamMember'
    ];

    public function getData()
    {
        return  [
                    'title'         =>  $this->Title,
                    'content'       =>  $this->Content,
                    'hero'          =>  $this->Hero()->exists() ? $this->Hero()->getCropped()->SetWidth(1920)->URL : null,
                    'team_members'  =>  $this->TeamMembers()->getData()
                ];
    }

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        if ($this->exists()) {
            $fields->addFieldToTab(
                'Root.TeamMembers',
                Grid::make('TeamMembers', 'Team Members', $this->TeamMembers())
            );
        }
        return $fields;
    }
}

class TeamPage_Controller extends Page_Controller
{
    public function init()
    {
        parent::init();
    }
}
