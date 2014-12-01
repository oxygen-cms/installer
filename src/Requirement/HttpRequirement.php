<?php

namespace Oxygen\Installer\Requirement;

class HttpRequirement implements RequirementInterface {

    /**
     * Checks if the PHP version is valid.
     *
     * @return array
     */

    public function passes() {
        $stream = ini_get('allow_url_fopen');
        $curl = function_exists('curl_init') && defined('CURLOPT_FOLLOWLOCATION');

        $message = $curl
            ? 'cURL Library Enabled'
            : ($stream ? 'PHP Streams Enabled' : 'cURL Library and PHP Streams Disabled');

        return ['result' => $curl || $stream, 'message' => $message];
    }

}