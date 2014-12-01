<?php

namespace Oxygen\Installer\Requirement;

class PackagistRequirement implements RequirementInterface {

    /**
     * Checks if the server can connect to Packagist
     *
     * @return array
     */

    public function passes() {
        $url = 'https://packagist.org/packages.json';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $passes = $response ? true : false;

        $message = '<a href="' . $url . '">packagist.org</a>' . ($passes
            ? ' Is Reachable'
            : ' Is Not Reachable');

        return ['result' => $passes, 'message' => $message];
    }

}