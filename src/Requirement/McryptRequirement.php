<?php

namespace Oxygen\Installer\Requirement;

class McryptRequirement implements RequirementInterface {

    /**
     * Checks if the PHP version is valid.
     *
     * @return array
     */

    public function passes() {
        $passes = extension_loaded('mcrypt');

        $message = $passes
            ? 'Mcrypt Extension Loaded'
            : 'Mycrypt Extension Not Loaded';

        return ['result' => $passes, 'message' => $message];
    }

}