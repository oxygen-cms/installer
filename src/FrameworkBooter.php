<?php

namespace Oxygen\Installer;

use Exception;
use Illuminate\Foundation\Application;

class FrameworkBooter {

    /**
     * Boots the main framework.
     *
     * @return Application
     */

    public function boot() {
        require INSTALL_PATH . '/bootstrap/autoload.php';

        $app = require_once INSTALL_PATH . '/bootstrap/start.php';
        $app->boot();

        return $app;
    }

}