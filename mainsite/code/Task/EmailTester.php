<?php
use SaltedHerring\Debugger;
/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class EmailTester extends BuildTask
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
    protected $title = 'Email Tester';

    /**
     * @var string $description Describe the implications the task has,
     * and the changes it makes. Accepts HTML formatting.
     */
    protected $description = 'Test emails. Please use this task from CLI';

    /**
     * This method called via the TaskRunner
     *
     * @param SS_HTTPRequest $request
     */
    public function run($request)
    {
        if ($request->getHeader('User-Agent') != 'CLI') {
            print '<span style="color: red; font-weight: bold; font-size: 24px;">This task is for CLI use only</span><br />';
            print '<em style="font-size: 14px;"><strong>Usage</strong>: sake dev/tasks/' . get_class($this) . ' EMAIL_CLASS</em>';
            return false;
        }

        if (!empty($request->getVar('args'))) {
            $args               =   $request->getVar('args');

            if (count($args) < 1) {
                print 'missing arguments';
                print PHP_EOL;
                print 'Usage: sake dev/tasks/' . get_class($this) . ' EMAIL_CLASS</em>';
                print PHP_EOL;
                print PHP_EOL;

                return false;
            }

            $email_class        =   $args[0];

            $email              =   $email_class::create();
            $email->send();

            return true;
        }

        print 'Class not given';
        print PHP_EOL;
        print 'Usage: sake dev/tasks/' . get_class($this) . ' EMAIL_CLASS</em>';
        print PHP_EOL;
        print PHP_EOL;
    }
}
