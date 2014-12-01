<?php

namespace Oxygen\Installer\Requirement;

class WritableRequirement implements RequirementInterface {

    /**
     * Checks if the PHP version is valid.
     *
     * @return array
     */

    public function passes() {
        $passes = is_writable(INSTALL_PATH);

        $message = $passes
            ? 'Install Path Writable'
            : INSTALL_PATH . ' Not Writable';

        return ['result' => $passes, 'message' => $message];
    }

}