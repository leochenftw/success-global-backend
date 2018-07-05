<?php

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class ConsultationSlotAdmin extends ModelAdmin
{
    /**
     * Managed data objects for CMS
     * @var array
     */
    private static $managed_models  =   [
                                            'ConsultationSlot',
                                            'Booking'
                                        ];

    /**
     * Menu icon for Left and Main CMS
     * @var string
     */
    private static $menu_icon       =   'mainsite/images/calendar.svg';

    /**
     * URL Path for CMS
     * @var string
     */
    private static $url_segment     =   'session-bookings';

    /**
     * Menu title for Left and Main CMS
     * @var string
     */
    private static $menu_title      =   'Sessions & Bookings';

    public function getList()
    {
        $list                       =   parent::getList();

        return $list;
    }
}
