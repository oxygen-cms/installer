<?php

namespace Oxygen\Installer\Requirement;

interface RequirementInterface {

    /**
     * Returns true if the requirement passes, else will return an error message explaining the problem.
     *
     * @return array
     */

    public function passes();

} 