<?php
class CustomSiteConfig extends DataExtension
{
    public static $db = array(
        'GoogleSiteVerificationCode'    =>  'Varchar(128)',
        'GoogleAnalyticsCode'           =>  'Varchar(20)',
        'SiteVersion'                   =>  'Varchar(10)',
        'GoogleCustomCode'              =>  'HTMLText',
        'EmailRecipients'               =>  'Text',
        'FooterSlogan'                  =>  'Text'
    );

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'SiteLogo'                      =>  'Image'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab("Root.Google", new TextField('GoogleSiteVerificationCode', 'Google Site Verification Code'));
        $fields->addFieldToTab("Root.Google", new TextField('GoogleAnalyticsCode', 'Google Analytics Code'));
        $fields->addFieldToTab("Root.Google", new TextareaField('GoogleCustomCode', 'Custom Google Code'));
        // $fields->addFieldsToTab(
        //     'Root.Main',
        //     SaltedUploader::create(
        //         'SiteLogo',
        //         'Website logo'
        //     ), //->setCropperRatio(170/60),
        //     'Title'
        // );
        $fields->addFieldToTab(
            'Root.Main',
            TextField::create(
                'FooterSlogan',
                'Footer Slogan'
            )
        );
        $fields->addFieldsToTab(
            'Root.Main',
            [
                TextField::create(
                    'SiteVersion', 'Site Version'
                ),
                TextField::create(
                    'EmailRecipients',
                    'Email recipients'
                )->setDescription('Emails that will receive the enquiriy notifications from the website. Separate multiple recipient emails with ","')
            ]
        );
    }

    public function getNotificationRecipients()
    {
        $recipients     =   explode(',', $this->owner->EmailRecipients);
        foreach ($recipients as &$recipient)
        {
            $recipient  =   trim($recipient);
        }

        return implode(',', $recipients);
    }
}
