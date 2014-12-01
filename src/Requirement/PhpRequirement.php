<?php

namespace Oxygen\Installer\Requirement;

class PhpRequirement implements RequirementInterface {

    /**
     * Checks if the PHP version is valid.
     *
     * @return array
     */

    public function passes() {
        $passes = version_compare(PHP_VERSION , "5.4", ">=");

        $message = $passes
            ? 'PHP 5.4 or Later'
            : 'Your version of PHP is too old. Oxygen requires PHP 5.4 or Later';

        return ['result' => $passes, 'message' => $message];
    }

}