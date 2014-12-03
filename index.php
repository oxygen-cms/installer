<?php
    require 'src/boot/start.php';

    $title = 'Check Requirements';

    include 'src/layout/head.php';
?>

<header class="Banner Banner--main cf">
    <h1 class="heading-alpha">Welcome to Oxygen</h1>
    <p class="Banner-step">3</p>
    <p class="Banner-step">2</p>
    <p class="Banner-step Banner-step--active">1</p>
</header>
<div class="Page">
    <h2 class="heading-gamma">Checking System Requirements...</h2>
    <ul class="Requirement-list">
        <li class="Requirement Requirement--failed" data-requirement="enabled-js">JavaScript is Disabled. <br><br>For instructions on how to enable it, visit <a href="http://www.activatejavascript.org/">activatejavascript.org</a>.</li>
    </ul>

    <div class="Success Message RequirementsCheckMessage--success">
        <h2 class="heading-gamma">You're ready to go!</h2>
        <p>Congratulations, your system is compatible with Oxygen. You can now proceed with installation.</p>
        <a href="install.php" class="Button Button-color--blue">Install</a>
    </div>
    <div class="Error Message RequirementsCheckMessage--error Message--show">
        <h2 class="heading-gamma">Whoops, there's a problem!</h2>
        <p>Your system doesn't meet the requirements to run Oxygen.</p>
    </div>
</div>

<?php include 'src/layout/scripts.php'; ?>

<script src="assets/js/requirements.js"></script>

<?php include 'src/layout/foot.php'; ?>
