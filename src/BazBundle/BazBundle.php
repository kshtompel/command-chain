<?php

namespace BazBundle;


use Symfony\Component\Console\Application;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class BazBundle
 *
 * @package BazBundle
 */
class BazBundle extends Bundle
{
    /**
     * Stub to prevent duplicate command register, because we using commands as service.
     *
     * @param Application $application
     */
    public function registerCommands(Application $application){}
}
