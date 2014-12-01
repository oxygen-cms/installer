<?php
    require 'src/start.php';

    include 'src/layout/head.php';
?>

<header class="Header Header--main cf">
    <h1>Welcome to Oxygen</h1>
    <p class="Header-step">3</p>
    <p class="Header-step">2</p>
    <p class="Header-step Header-step--active">1</p>
</header>
<div class="Body">
    <h2>Checking System Requirements...</h2>
    <ul class="Requirement-list">
        <li class="Requirement Requirement--failed" data-requirement="enabled-js">JavaScript is Disabled. <br><br>For instructions on how to enable it, visit <a href="http://www.activatejavascript.org/">activatejavascript.org</a>.</li>
    </ul>

    <div class="Success RequirementsCheckMessage RequirementsCheckMessage--success">
        <h2>You're ready to go!</h2>
        <p>Congratulations, your system is compatible with Oxygen. You can now proceed with installation.</p>
        <a href="install.php" class="Button">Install</a>
    </div>
    <div class="Error RequirementsCheckMessage RequirementsCheckMessage--error RequirementsCheckMessage--show">
        <h2>Whoops, there's a problem!</h2>
        <p>Your system doesn't meet the requirements to run Oxygen.</p>
    </div>
</div>

<?php include 'src/layout/scripts.php'; ?>

<script src="assets/js/requirements.js"></script>

<?php include 'src/layout/foot.php'; ?>
