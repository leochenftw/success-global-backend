<?php

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class VisaTypeAdmin extends ModelAdmin
{
    /**
     * Managed data objects for CMS
     * @var array
     */
    private static $managed_models  =   [
                                            'VisaType'
                                        ];

    /**
     * Menu icon for Left and Main CMS
     * @var string
     */
    private static $menu_icon       =   'mainsite/images/visa.svg';

    /**
     * URL Path for CMS
     * @var string
     */
    private static $url_segment     =   'visa-categories';

    /**
     * Menu title for Left and Main CMS
     * @var string
     */
    private static $menu_title      =   'VISA Categories';

    public function getList()
    {
        $list                       =   parent::getList();

        $list                       =   $list->filter(['ParentTypeID' => 0]);

        return $list;
    }
}
