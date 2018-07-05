<?php
use Ntb\RestAPI\BaseRestController;
use SaltedHerring\Debugger;
use SaltedHerring\Recaptcha;
/**
 * @file ConsultationAPI.php
 *
 * Controller to present the data from forms.
 * */
class ConsultationAPI extends BaseRestController
{
    private $first_name     =   null;
    private $last_name      =   null;
    private $email          =   null;
    private $message        =   null;
    private $g_response     =   null;

    private static $allowed_actions = [
        'get'               =>  true,
        'post'              =>  "->isAuthenticated"
    ];

    public function isAuthenticated()
    {

        return true;
        $request            =   $this->request;

        if ($csrf = $request->postVar('csrf')) {

            if (Director::isLive()) {
                if ($csrf != SecurityToken::getSecurityID()) {
                    return false;
                }
            }

            if (($this->first_name = $request->postVar('first_name')) &&
                ($this->last_name = $request->postVar('last_name')) &&
                ($this->email = $request->postVar('email')) &&
                ($this->message = $request->postVar('message')) &&
                ($this->g_response = $request->postVar('g-recaptcha-response'))) {

                return true;
            }
        }
        return false;
    }

    public function get($request)
    {
        return  ConsultationSlot::get()->filter(
                [
                    'Title:GreaterThan'             =>  time(),
                    'BookingID'                     =>  0
                ])->getData();
    }

    public function post($request)
    {
        if (Recaptcha::verify($this->g_response)) {

            $appointment_date_time                  =   $request->postVar('appointment_date_time');
            if ($appointment_date_time < 0) {
                return  $this->httpError(400, 'You need to pick a session');
            } elseif ($appointment_date_time > 0) {
                $appointment_date_time              =   ConsultationSlot::get()->byID($appointment_date_time);

                if (empty($appointment_date_time)) {
                    return $this->httpError(404, 'No such session');
                }

                if (strtotime($appointment_date_time->Title) <= time()) {
                    return $this->httpError(406, 'The session you tried to book no longer available');
                }

                if ($appointment_date_time->Booking()->exists()) {
                    return $this->httpError(406, 'The session you tried to book no longer available');
                }
            }

            $booking                                =   new Booking();
            $booking->FirstName                     =   $request->postVar('first_name');
            $booking->Surname                       =   $request->postVar('surname');
            $booking->ContactNumber                 =   $request->postVar('contact_number');
            $booking->Email                         =   $request->postVar('email');
            $booking->CurrentVisa                   =   $request->postVar('visa_current');
            $booking->IntendVisa                    =   $request->postVar('visa_intend');
            $booking->CurrentSituation              =   $request->postVar('current_situation');
            $booking->AdditionalInfo                =   $request->postVar('additional_info');

            $passport                               =   $request->postVar('passport_bio');
            $visa                                   =   $request->postVar('visa_label');

            if (!empty($passport['tmp_name'])) {
                $passport_image                     =   new Image();
                $directory                          =   Folder::find_or_make('passports');
                $name_ext                           =   explode('.', $passport['name']);
                $file_name                          =   substr(sha1(time() . rand() . $name_ext[0]), 0, 16);
                $file_extension                     =   count($name_ext) > 0 ? $name_ext[count($name_ext) - 1] : 'jpg';

                if (copy($passport['tmp_name'], $directory->getFullPath() . $file_name . '.' . $file_extension)) {
                    $passport_image->ParentID       =   $directory->ID;
                    $passport_image->Title          =   $name_ext[0];
                    $passport_image->Filename       =   $directory->getRelativePath() . $file_name . '.' . $file_extension;
                    $passport_image->write();
                    $booking->PassportBioID         =   $passport_image->ID;
                }
            }

            if (!empty($visa['tmp_name'])) {
                $visa_image                         =   new Image();
                $directory                          =   Folder::find_or_make('visa');
                $name_ext                           =   explode('.', $visa['name']);
                $file_name                          =   substr(sha1(time() . rand() . $name_ext[0]), 0, 16);
                $file_extension                     =   count($name_ext) > 0 ? $name_ext[count($name_ext) - 1] : 'jpg';

                if (copy($visa['tmp_name'], $directory->getFullPath() . $file_name . '.' . $file_extension)) {
                    $visa_image->ParentID           =   $directory->ID;
                    $visa_image->Title              =   $name_ext[0];
                    $visa_image->Filename           =   $directory->getRelativePath() . $file_name . '.' . $file_extension;
                    $visa_image->write();
                    $booking->VisaLabelID           =   $visa_image->ID;
                }
            }

            $booking->write();

            if (!empty($appointment_date_time)) {
                $appointment_date_time->BookingID           =   $booking->ID;
                $appointment_date_time->MerchantReference   =   $booking->Title;
                $appointment_date_time->write();
            }

            return  [
                        'reference'                 =>  $booking->Title,
                        'expires_at'                =>  strtotime("+5 minutes") * 1000,
                        'pay_link'                  =>  $booking->Pay(),
                        'paid'                      =>  false
                    ];
        }

        return $this->httpError(400, 'Robot?');
    }
}
