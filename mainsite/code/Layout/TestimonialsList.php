<?php

use SaltedHerring\Grid;
/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class TestimonialsPage extends Page
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'NumPerLoad'            =>  'Int'
    ];
    /**
     * Defines extension names and parameters to be applied
     * to this object upon construction.
     * @var array
     */
    private static $extensions = [
        'PageHeroExtension'
    ];

    /**
     * Has_many relationship
     * @var array
     */
    private static $has_many = [
        'Highlights'            =>  'TestimonialHighlight',
        'Testimonials'          =>  'Testimonial'
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
                TextField::create(
                    'NumPerLoad',
                    'Number of testimonials per page load'
                )->setDescription('If leave empty or set to 0, it will load 5 items each time.'),
                Grid::make('Highlights', 'Highlights', $this->Highlights())
            ],
            'Content'
        );
        $fields->addFieldToTab(
            'Root.GoogleReviews',
            Grid::make('Testimonials', 'Google reviews', $this->Testimonials(), false)
        );
        return $fields;
    }

    public function getData($request = [])
    {
        return  [
                    'title'         =>  $this->Title,
                    'content'       =>  $this->Content,
                    'hero'          =>  $this->Hero()->exists() ? $this->Hero()->Cropped()->SetWidth(1920)->URL : null,
                    'testimonials'  =>  $this->Testimonials()->Paginate(empty($this->NumPerLoad) ? 5 : $this->NumPerLoad, $request),
                    'section_url'   =>  !empty($request) ? '/' : rtrim($this->Link(), '/'),
                    'highlights'    =>  $this->Highlights()->getData()
                ];
    }
}

class TestimonialsPage_Controller extends Page_Controller
{
    public function AjaxResponse()
    {
        $data                       =   parent::AjaxResponse();
        $data['testimonials']       =   $this->getData($this->request);
        return $data;
    }
}
