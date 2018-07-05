<?php
use Ntb\RestAPI\BaseRestController;
use SaltedHerring\Debugger;
use SaltedHerring\Recaptcha;
/**
 * @file ContactAPI.php
 *
 * Controller to present the data from forms.
 * */
class ContactAPI extends BaseRestController
{
    private $first_name     =   null;
    private $last_name      =   null;
    private $email          =   null;
    private $message        =   null;
    private $g_response     =   null;

    private static $allowed_actions = [
        'post'              =>    "->isAuthenticated"
    ];

    public function isAuthenticated()
    {
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

    public function post($request)
    {
        if (Recaptcha::verify($this->g_response)) {

            $notification               =   new ContactNotification(
                                                $this->first_name . (!empty($this->last_name) ? ( ' ' . $this->last_name) : ''),
                                                $this->email,
                                                $this->message
                                            );
            $notification->send();

            $acknowledgement            =   new AcknowledgementEmail($this->first_name, $this->email, $this->message);
            $acknowledgement->send();

            return  [
                        'first_name'    =>  $this->first_name,
                        'last_name'     =>  $this->last_name,
                        'email'         =>  $this->email,
                        'message'       =>  $this->message
                    ];
        }

        return $this->httpError(400, 'Robot?');
    }
}
