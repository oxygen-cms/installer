<?php

require 'src/boot/start.php';

$name = $_GET['name'];

function getRequirement($name) {
    $name = 'Oxygen\Installer\Requirement\\' . ucfirst($name) . 'Requirement';
    return new $name();
}

$result = getRequirement($name)->passes();

echo json_encode($result);