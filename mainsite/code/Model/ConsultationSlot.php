<?php
use SaltedHerring\Debugger;
/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class ConsultationSlot extends PGOrder
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Title'         =>  'SS_Datetime',
        'Duration'      =>  'Int'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'Booking'       =>  'Booking'
    ];

    /**
     * Defines summary fields commonly used in table columns
     * as a quick overview of the data for this dataobject
     * @var array
     */
    private static $summary_fields = [
        'Title'         =>  'Date time',
        'SessionStatus' =>  'Status'
    ];

    /**
     * Has_many relationship
     * @var array
     */
    private static $has_many = [
        'Payments'      =>  'PoliPayment'
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields         =   parent::getCMSFields();
        $date_field     =   $fields->fieldByName('Root.Main.Title');
        $date_field->getDateField()->setConfig('showcalendar', true);
        $fields->removeByName([
            'BookingID'
        ]);

        $fields->fieldByName('Root.Main.Duration')->setDescription('number in minutes. e.g. input <strong>30</strong> for 30 minutes');

        $fields->addFieldsToTab(
            'Root.Main',
            [
                $fields->fieldByName('Root.MerchantInfo.Amount'),
                LiteralField::create(
                    'Booking',
                    '<div id="Booking_Link" class="field text">
                        <label class="left" for="Booking_Link_Label">Booking Status</label>
                        <div class="middleColumn" style="padding: 8px 0;">' .
                            ($this->Booking()->exists() ?
                            '<a href="/admin/session-bookings/Booking/EditForm/field/Booking/item/' . $this->BookingID . '/edit">View Booking</a>' :
                            '- not yet booked -') . '
                        </div>
                    </div>'
                )
            ]
        );

        $fields->removeByName([
            'CustomerID'
        ]);

        return $fields;
    }

    public function validate()
    {
        $result         =   parent::validate();

        $search         =   ConsultationSlot::get()->filter([
                                'Title:GreaterThanOrEqual' => strtotime('-29 minutes', strtotime($this->Title)),
                                'Title:LessThan' => strtotime($this->Title)
                            ]);
        if ($search->count() > 0) {
            $result->error('You already have a session within 30 minutes');
        }

        return $result;
    }

    public function getData()
    {
        return  [
                    'id'        =>  $this->ID,
                    'dt'        =>  strtotime($this->Title) * 1000,
                    'duration'  =>  $this->Duration,
                    'amount'    =>  $this->Amount->Amount
                ];
    }

    public function SessionStatus()
    {
        if ($this->Booking()->exists()) {
            return 'Sold';
        }

        return  'Open';
    }

    public function onPaymentUpdate($success)
    {
        if ($this->Booking()->exists()) {
            $booking            =   $this->Booking();
            $booking->Paid      =   true;
            $booking->write();
        }
    }

}
