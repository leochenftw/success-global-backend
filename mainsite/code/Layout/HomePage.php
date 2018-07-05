<?php
use SaltedHerring\Grid;
use SaltedHerring\SaltedCache;
use SaltedHerring\Debugger;
class HomePage extends Page
{
    /**
     * Defines the allowed child page types
     * @var array
     */
    private static $allowed_children = [];
    /**
     * Has_many relationship
     * @var array
     */
    private static $has_many = [
        'CarouselItems'         =>  'CarouselItem'
    ];

    /**
     * Creating Permissions
     * @return boolean
     */
    public function canCreate($member = null)
    {
        return Versioned::get_by_stage('HomePage', 'Stage')->count() == 0;
    }

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab(
            'Root.Carousel',
            Grid::make('CarouselItems', 'Carousel', $this->CarouselItems())
        );

        $fields->removeByName([
            'PageHero'
        ]);

        return $fields;
    }
}

class HomePage_Controller extends Page_Controller
{
    public function init()
    {
        parent::init();
        // Debugger::inspect(Director::isLive() ? 'Yes' : 'No');
    }

    public function AjaxResponse()
    {
        if (Director::isLive()) {
            $data                       =   SaltedCache::read('PageDataCache', $this->ID);
        }

        if (empty($data)) {
            $data                       =   parent::AjaxResponse();
            $this->AttachCarousel($data);
            $this->AttachServices($data);
            $this->AttachAboutUs($data);
            $this->AttachTestimonials($data);
            $this->AttachTeam($data);


            $this->AttachVISACategories($data);
            $this->AttachPointsOfDifference($data);

            if (Director::isLive()) {
                SaltedCache::save('PageDataCache', $this->ID, $data);
            }
        }

        return $data;
    }

    private function AttachVISACategories(&$data)
    {
        $categories                     =   VisaType::get()->filter(['ParentTypeID' => 0]);
        $data['visa_categories']        =   $categories->getData();
    }

    private function AttachCarousel(&$data)
    {
        if ($this->CarouselItems()->count() > 0) {
            $carousel                   =   $this->CarouselItems();
            $items                      =   [];
            foreach ($carousel as $item)
            {
                $items[]                =   $item->getData();
            }

            $data['carousel']           =   $items;
        }
    }

    private function AttachServices(&$data)
    {
        if ($services = ServiceList::get()->first()) {
            $data['services']           =   $services->getData();
        }
    }

    private function AttachAboutUs(&$data)
    {
        if ($about = AboutUsPage::get()->first()) {
            $data['about_us']           =   $about->getData();
        }
    }

    private function AttachTestimonials(&$data)
    {
        if ($testimonials = TestimonialsPage::get()->first()) {
            $data['testimonials']       =   $testimonials->getData();
        }
    }

    private function AttachTeam(&$data)
    {
        if ($team = TeamPage::get()->first()) {
            $data['team']               =   $team->getData();
        }
    }

    private function AttachPointsOfDifference(&$data)
    {
        if ($diff = PointsOfDifferencePage::get()->first()) {
            $data['points_of_diff']     =   $diff->getData();
        }
    }
}
