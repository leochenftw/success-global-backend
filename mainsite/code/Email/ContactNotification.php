<?php
use SaltedHerring\Debugger;
class ContactNotification extends Email
{
    public function __construct($name = 'Leo Chen', $email = 'leo@leochen.co.nz', $message = 'Test, please ignore')
    {
        $from               =   Config::inst()->get('Email', 'admin_email');
        $to                 =   SiteConfig::current_site_config()->getNotificationRecipients();
        $subject            =   'Enquiry via Success Global website';

        parent::__construct($from, $to, $subject);

        $this->replyTo      =   $email;
        $this->Bcc          =   'leochenftw@gmail.com';
        $this->setTemplate('ContactNotification');

        $this->populateTemplate(ArrayData::create([
            'Title'         =>  $subject,
            'Name'          =>  $name,
            'DateTime'      =>  date("Y-m-d H:i:s"),
            'Email'         =>  $email,
            'baseURL'       =>	Director::absoluteURL(Director::baseURL()),
            'CSSURL'        =>  Director::absoluteURL(Director::baseURL()) . 'mainsite/templates/Email/css/email.css',
            'Content'       =>  $message
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
