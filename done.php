<?php
    require 'src/boot/start.php';

    $title = 'Installation Complete';

    include 'src/layout/head.php';
?>

<header class="Banner cf">
    <h1 class="heading-alpha">Installation Complete</h1>
</header>
<div class="Page">
    <div class="Message Message--show Success">
        <h3 class="heading-delta">Get Started Now</h3>
        <p>If you can't wait to get started, then head over and login to the <a href="/oxygen">Oxygen</a> administration area.</p>
    </div>

    <div class="Message Message--show Success">
        <h3 class="heading-delta">Help &amp; Documentation</h3>
        <p>Help and documentation for the system will soon be available on <a href="https://github.com/oxygen-cms">GitHub</a>.</p>
    </div>

    <div class="Message Message--show Error">
        <h3 class="heading-delta">Important Security Advice</h3>
        <p>Please remove the `<code>install</code>` directory from the web root of your server.<br><strong>Failing to do so may allow malicious users to overwrite your current installation and wipe your database.</strong></p>
    </div>
</div>

<?php include 'src/layout/scripts.php'; ?>

<script src="assets/js/requirements.js"></script>

<?php include 'src/layout/foot.php'; ?>
