<?php
use SaltedHerring\Debugger;
/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class NZAUS extends BuildTask
{
    /**
     * @var bool $enabled If set to FALSE, keep it from showing in the list
     * and from being executable through URL or CLI.
     */
    protected $enabled = true;

    /**
     * @var string $title Shown in the overview on the TaskRunner
     * HTML or CLI interface. Should be short and concise, no HTML allowed.
     */
    protected $title = 'NZAUS';

    /**
     * @var string $description Describe the implications the task has,
     * and the changes it makes. Accepts HTML formatting.
     */
    protected $description = '';

    /**
     * This method called via the TaskRunner
     *
     * @param SS_HTTPRequest $request
     */
    public function run($request)
    {
        $services   =   Versioned::get_by_stage('ServicePage', 'Stage');
        foreach ($services as $service)
        {
            if ($service->Title == 'NZ') {
                $service->Title = 'New Zealand';
                $service->writeToStage('Stage');
                $service->writeToStage('Live');
            }

            if ($service->Title == 'AUS') {
                $service->Title = 'Australia';
                $service->writeToStage('Stage');
                $service->writeToStage('Live');
            }
        }
    }
}
