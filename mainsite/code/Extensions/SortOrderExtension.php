<?php

/**
 * @file SortOrderExtension.php
 * */
class SortOrderExtension extends DataExtension
{
    private static $db = array(
        'SortOrder' => 'Int'
    );

    /**
     * Default sort ordering
     * @var array
     */
    private static $default_sort = ['SortOrder' => 'ASC'];

    public function updateCMSFields(FieldList $fields)
    {
        $field = $fields->fieldByName('Root.Main');

        if ($field) {
            $fields->removeFieldsFromTab("Root.Main", array(
                'SortOrder'
            ));
        }
    }
}
