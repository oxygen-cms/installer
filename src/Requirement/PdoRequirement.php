<?php

namespace Oxygen\Installer\Requirement;

class PdoRequirement implements RequirementInterface {

    /**
     * Checks if the PHP version is valid.
     *
     * @return array
     */

    public function passes() {
        $passes = defined('PDO::ATTR_DRIVER_NAME');

        $message = $passes
            ? 'PDO Extension Loaded'
            : 'PDO Extension Not Loaded';

        return ['result' => $passes, 'message' => $message];
    }

}