<?php
use SaltedHerring\Debugger;
/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class Booking extends DataObject
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Title'             =>  'Varchar(16)',
        'FirstName'         =>  'Varchar(64)',
        'Surname'           =>  'Varchar(64)',
        'ContactNumber'     =>  'Varchar(24)',
        'Email'             =>  'Varchar(255)',
        'CurrentVisa'       =>  'Varchar(64)',
        'IntendVisa'        =>  'Varchar(64)',
        'CurrentSituation'  =>  'Text',
        'AdditionalInfo'    =>  'Text',
        'ExpiresAt'         =>  'SS_Datetime',
        'Paid'              =>  'Boolean'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'PassportBio'       =>  'Image',
        'VisaLabel'         =>  'Image'
    ];

    /**
     * Belongs_to relationship
     * @var array
     */
    private static $belongs_to = [
        'Slot'              =>  'ConsultationSlot'
    ];

    /**
     * Default sort ordering
     * @var array
     */
    private static $default_sort = ['ID' => 'DESC'];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields             =   parent::getCMSFields();
        $title              =   $fields->fieldByName('Root.Main.Title')->performReadonlyTransformation();
        $title->setTitle('Reference number');
        $fields->replaceField('Title', $title);
        // $fields->addFieldToTab(
        //     'Root.Main',
        //     DropdownField::create(
        //         'Slot',
        //         'Session',
        //         ConsultationSlot::get()->filter([
        //                                             'Title:GreaterThan' =>  time(),
        //                                             'BookingID'         =>  0
        //                                         ])->map(),
        //         $this->Slot()->ID
        //     )->setEmptyString('- select one -'),
        //     'Title'
        // );

        return $fields;
    }

    /**
     * Event handler called before writing to the database.
     */
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        if (empty($this->Title)) {
            $this->Title        =   strtoupper(substr(sha1(time() . rand()), 4, 6));
        }

        if (empty($this->ExpiresAt)) {
            $this->ExpiresAt    =   strtotime("+60 minutes");
        }
    }

    public function HTMLSituation()
    {
        return str_replace("\n", '<br />', $this->CurrentSituation);
    }

    public function HTMLAddtionalInfo()
    {
        return str_replace("\n", '<br />', $this->AdditionalInfo);
    }

    public function Pay()
    {
        if (!$this->Paid) {
            if ($session = $this->Slot()) {
                return $session->AjaxPay('POLi');
            }
        }

        return null;
    }

    /**
     * Event handler called before deleting from the database.
     */
    public function onBeforeDelete()
    {
        parent::onBeforeDelete();
        if ($session = $this->Slot()) {
            $session->BookingID     =   0;
            $session->write();
        }
    }

    public function getData()
    {
        return  [
                    'reference'     =>  $this->Title,
                    'expires_at'    =>  strtotime($this->ExpiresAt) * 1000,
                    'first_name'    =>  $this->FirstName,
                    'surname'       =>  $this->Surname,
                    'phone'         =>  $this->ContactNumber,
                    'email'         =>  $this->Email,
                    'current_visa'  =>  $this->CurrentVisa,
                    'intend_visa'   =>  $this->IntendVisa,
                    'current_stn'   =>  $this->CurrentSituation,
                    'more_info'     =>  $this->AdditionalInfo,
                    'amount'        =>  $this->Slot()->exists() ? $this->Slot()->Amount->Amount : 0,
                    'pay_link'      =>  $this->Pay(),
                    'paid'          =>  $this->Paid
                ];
    }

    /**
     * Event handler called after writing to the database.
     */
    public function onAfterWrite()
    {
        parent::onAfterWrite();

        if ($this->Paid) {
            $notification               =   new BookingNotification($this);
            $notification->send();

            $acknowledgement            =   new BookingAcknowledgement($this);
            $acknowledgement->send();
        }
    }
}
