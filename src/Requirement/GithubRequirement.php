<?php

namespace Oxygen\Installer\Requirement;

class GithubRequirement implements RequirementInterface {

    /**
     * Checks if the server can connect to Github
     *
     * @return array
     */

    public function passes() {
        $url = 'https://api.github.com/';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $passes = $response ? true : false;

        $message = '<a href="' . $url . '">github.com</a>' . ($passes
            ? ' Is Reachable'
            : ' Is Not Reachable');

        return ['result' => $passes, 'message' => $message];
    }

}