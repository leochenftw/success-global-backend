<?php

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class TestimonialHighlight extends DataObject
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Title'             =>  'Varchar(32)',
        'Figure'            =>  'Varchar(16)',
        'isPercentage'      =>  'Boolean',
        'Icon'              =>  'Varchar(32)'
    ];

    /**
     * Default sort ordering
     * @var array
     */
    private static $default_sort = ['SortOrder' => 'ASC'];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'Page'              =>  'TestimonialsPage'
    ];

    /**
     * Defines extension names and parameters to be applied
     * to this object upon construction.
     * @var array
     */
    private static $extensions = [
        'SortOrderExtension'
    ];

    public function getData()
    {
        return  [
                    'title'     =>  $this->Title,
                    'figure'    =>  $this->Figure,
                    'percent'   =>  $this->isPercentage,
                    'icon'      =>  $this->Icon
                ];
    }
}
