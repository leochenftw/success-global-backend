<?php

class PageHeroExtension extends DataExtension
{
    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'Hero'          =>  'SaltedCroppableImage'
    ];

    /**
     * Update Fields
     * @return FieldList
     */
    public function updateCMSFields(FieldList $fields)
    {
        $owner          =   $this->owner;
        $fields->addFieldToTab(
            'Root.PageHero',
            CroppableImageField::create('HeroID', 'Page Hero')->setCropperRatio(16/9)
        );

        return $fields;
    }

}
