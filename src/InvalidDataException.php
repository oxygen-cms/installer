<?php

namespace Oxygen\Installer;

use Exception;
use Illuminate\Support\MessageBag;

class InvalidDataException extends Exception {

    /**
     * The validation errors.
     *
     * @var MessageBag
     */

    protected $errors;

    /**
     * Constructs the InvalidDataException.
     *
     * @param MessageBag  $errors
     */

    public function __construct(MessageBag $errors) {
        parent::__construct($errors->first());
        $this->errors = $errors;
    }

    /**
     * Returns the error messages.
     *
     * @return array
     */

    public function getErrors() {
        return $this->errors;
    }

}
