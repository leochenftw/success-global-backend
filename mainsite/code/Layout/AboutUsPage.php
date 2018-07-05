<?php

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class AboutUsPage extends Page
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'FirstRowText'          =>  'HTMLText',
        'SecRowTextLeft'        =>  'HTMLText',
        'SecRowTextRight'       =>  'HTMLText'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'FirstRowImage'         =>  'Image'
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab(
            'Root.Main',
            [
                HtmlEditorField::create(
                    'FirstRowText',
                    'Intro'
                ),
                UploadField::create(
                    'FirstRowImage',
                    'Intro image'
                ),
                HtmlEditorField::create(
                    'SecRowTextLeft',
                    'Consultation'
                ),
                HtmlEditorField::create(
                    'SecRowTextRight',
                    'Fees'
                )
            ],
            'Content'
        );

        $fields->fieldByName('Root.Main.Content')->setTitle('More text');

        $this->extend('updateCMSFields', $fields);
        return $fields;
    }

    public function getData()
    {
        return  [
                    'title'     =>  $this->Title,
                    'intro'     =>  $this->FirstRowText,
                    'hero'      =>  $this->Hero()->exists() ? $this->Hero()->getCropped()->SetWidth(1920)->URL : null,
                    'image'     =>  $this->FirstRowImage()->exists() ? $this->FirstRowImage()->SetWidth(600)->URL : null,
                    'left_col'  =>  $this->SecRowTextLeft,
                    'right_col' =>  $this->SecRowTextRight,
                    'more_text' =>  $this->Content
                ];
    }
}

class AboutUsPage_Controller extends Page_Controller
{
    public function AjaxResponse()
    {
        if (Director::isLive()) {
            $data                       =   SaltedCache::read('PageDataCache', $this->ID);
        }

        if (empty($data)) {
            $data                       =   parent::AjaxResponse();
            $data                       =   array_merge($data, $this->getData());

            if (Director::isLive()) {
                SaltedCache::save('PageDataCache', $this->ID, $data);
            }
        }

        return $data;
    }
}
