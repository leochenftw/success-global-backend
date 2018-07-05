<?php
use Cocur\Slugify\Slugify;
use \Yurun\Util\Chinese;
use \Yurun\Util\Chinese\Pinyin;
use SaltedHerring\Debugger;
class SlugExtension extends DataExtension
{
    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'Slug'                  =>  'Varchar(256)'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $field                  =   $fields->fieldByName('Root.Main.Slug');
        $fields->replaceField('Slug', $field->performReadonlyTransformation());
    }

    /**
     * Event handler called before writing to the database.
     */
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        $slugify                =   new Slugify();
        if ($this->owner->hasField('Title')) {
            $title              =   $this->owner->Title;
            $title_segments     =   Chinese::toPinyin($title, Pinyin::CONVERT_MODE_PINYIN);
            if (!empty($title_segments['pinyin'][0])) {
                $title          =   implode(' ', $title_segments['pinyin'][0]);
            }
            $slug               =   $this->testSlug($slugify->slugify($title));
            $this->owner->Slug  = $slug;
        }
    }

    private function testSlug($slug)
    {
        $i                      =   0;
        $slugTrial              =   $slug;
        $class                  =   $this->owner->ClassName;
        while ($class::get()->filter(['Slug' => $slugTrial])->exclude(array('ID' => $this->owner->ID))->count() > 0)
        {
            $i++;
            $slugTrial          =   $slug . '-' . $i;
        }

        if ($i > 0) {
            $slug = $slug . '-' . $i;
        }

        return $slug;
    }
}
