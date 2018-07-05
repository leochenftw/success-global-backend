<?php
use SaltedHerring\Debugger;
class BookingNotification extends Email
{
    private $booking        =   null;
    public function __construct($booking = null)
    {
        $this->booking      =   !empty($booking) ?
                                $booking :
                                Booking::get()->first();
        $from               =   Config::inst()->get('Email', 'admin_email');
        $to                 =   empty($booking) ?
                                Config::inst()->get('Email', 'developer_email') :
                                SiteConfig::current_site_config()->getNotificationRecipients();
        $subject            =   'Consultation Booking';

        parent::__construct($from, $to, $subject);

        $this->replyTo      =   $this->booking->Email;

        if (!empty($booking)) {
            $this->Bcc      =   Config::inst()->get('Email', 'developer_email');
        }

        $name               =   $this->booking->FirstName . ' ' . $this->booking->Surname;

        if ($this->booking->PassportBio()->exists()) {
            $this->attachFile($this->booking->PassportBio()->getRelativePath(), $name . "'s passport." . $this->booking->PassportBio()->getExtension());
        }

        if ($this->booking->VisaLabel()->exists()) {
            $this->attachFile($this->booking->VisaLabel()->getRelativePath(), $name . "'s visa." . $this->booking->VisaLabel()->getExtension());
        }


        $this->setTemplate('BookingNotification');

        $this->populateTemplate(ArrayData::create([
            'Title'         =>  $subject,
            'baseURL'       =>	Director::absoluteURL(Director::baseURL()),
            'CSSURL'        =>  Director::absoluteURL(Director::baseURL()) . 'mainsite/templates/Email/css/email.css',
            'Booking'       =>  $this->booking
        ]));

	}

    public function send($messageID = null)
    {
        Requirements::clear();

        $this->parseVariables();

        if(empty($this->from)) $this->from = Email::config()->admin_email;

        $headers = $this->customHeaders;

        if($messageID) $headers['X-SilverStripeMessageID'] = project() . '.' . $messageID;

        if(project()) $headers['X-SilverStripeSite'] = project();


        $to = $this->to;
        $from = $this->from;
        $subject = $this->subject;
        if($sendAllTo = $this->config()->send_all_emails_to) {
            $subject .= " [addressed to $to";
            $to = $sendAllTo;
            if($this->cc) $subject .= ", cc to $this->cc";
            if($this->bcc) $subject .= ", bcc to $this->bcc";
            $subject .= ']';
            unset($headers['Cc']);
            unset($headers['Bcc']);

        } else {
            if($this->cc) $headers['Cc'] = $this->cc;
            if($this->bcc) $headers['Bcc'] = $this->bcc;
        }


        if($ccAllTo = $this->config()->cc_all_emails_to) {
            if(!empty($headers['Cc']) && trim($headers['Cc'])) {
                $headers['Cc'] .= ', ' . $ccAllTo;
            } else {
                $headers['Cc'] = $ccAllTo;
            }
        }

        if($bccAllTo = $this->config()->bcc_all_emails_to) {
            if(!empty($headers['Bcc']) && trim($headers['Bcc'])) {
                $headers['Bcc'] .= ', ' . $bccAllTo;
            } else {
                $headers['Bcc'] = $bccAllTo;
            }
        }

        if($sendAllfrom = $this->config()->send_all_emails_from) {
            if($from) $subject .= " [from $from]";
            $from = $sendAllfrom;
        }

        Requirements::restore();

        $emogrifier = new \Pelago\Emogrifier();

        $html       =   $this->body;
        $css_path   =   realpath(Director::baseFolder() . '/mainsite/templates/Email/css/email.css');
        $css        =   file_get_contents($css_path);

        $emogrifier->setHtml($html);
        $emogrifier->setCss($css);
        $emogrifier->disableStyleBlocksParsing();

        $mergedHtml = $emogrifier->emogrify();

        // Debugger::inspect($mergedHtml);

        return self::mailer()->sendHTML($to, $from, $subject, $mergedHtml, $this->attachments, $headers,
            $this->plaintext_body);
    }
}
