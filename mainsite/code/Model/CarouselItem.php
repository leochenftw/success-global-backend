<?php

class CarouselItem extends DataObject
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Title'         =>  'Varchar(128)',
        'Content'       =>  'Text'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'Background'    =>  'SaltedCroppableImage',
        'Link'          =>  'Link',
        'Page'          =>  'HomePage'
    ];

    /**
     * Defines extension names and parameters to be applied
     * to this object upon construction.
     * @var array
     */
    private static $extensions = [
        'SortOrderExtension'
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields         =   parent::getCMSFields();
        $fields->addFieldToTab(
            'Root.Main',
            CroppableImageField::create('BackgroundID', 'Background')->setCropperRatio(16/9)
        );

        $fields->addFieldToTab(
            'Root.Main',
            LinkField::create(
                'LinkID',
                'Link'
            )
        );

        $fields->removeByName([
            'PageID'
        ]);

        return $fields;
    }

    public function getBG()
    {
        return  $this->Background()->exists() ?
                (
                    $this->Background()->Cropped()->exists() ?
                    $this->Background()->Cropped() :
                    $this->Background()->Original()
                ) :
                null;
    }

    public function getBGURL()
    {
        if ($bg = $this->getBG()) {
            return $bg->URL;
        }

        return null;
    }

    public function getData()
    {
        $link                       =   $this->Link();
        return  [
                    'title'         =>  $this->Title,
                    'content'       =>  $this->Content,
                    'background'    =>  $this->getBGURL(),
                    'link'          =>  !empty($link) ?
                                        [
                                            'title'     =>  $link->Title,
                                            'url'       =>  $link->getLinkURL(),
                                            'new_tab'   =>  !empty($link->OpenInNewWindow) ? true : false
                                        ] :
                                        null
                ];
    }
}
