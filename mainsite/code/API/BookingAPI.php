<?php
use Ntb\RestAPI\BaseRestController;
use SaltedHerring\Debugger;
/**
 * @file BookingAPI.php
 *
 * Controller to present the data from forms.
 * */
class BookingAPI extends BaseRestController
{
    private static $allowed_actions = [
        'get'               =>    true
    ];

    public function get($request)
    {
        $booking            =   Booking::get()->filter(['Title' => $request->param('ref')])->first();

        return !empty($booking) ? $booking->getData() : null;
    }
}
