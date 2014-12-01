<?php
    require 'src/boot/start.php';

    include 'src/layout/head.php';
?>

<header class="Header cf">
    <h1>Installing</h1>
    <p class="Header-step">3</p>
    <p class="Header-step Header-step--active">2</p>
    <p class="Header-step ">1</p>
</header>
<div class="Body">

    <div class="ProgressBar" id="install-progress"><span class="ProgressBar-fill" style="width: 100%;"></span></div>
    <div class="ProgressBar-message cf">
        <span class="ProgressBar-message-item"></span>
            <span class="ProgressBar-message-section">
                Step
                <span class="ProgressBar-message-section-count">0</span>
                -
                <span class="ProgressBar-message-section-message">Contacting Server</span>
            </span>
    </div>

    <h2>Installation Log</h2>

    <textarea id="install-log" rows="15" readonly>Contacting server...</textarea>

    <div class="Success Message InstallMessage--success">
        <h2>Installation Complete!</h2>
        <p>Oxygen is installed. You now need to configure it.</p>
        <a href="configure.php" class="Button">Configure</a>
    </div>

</div>

<?php include 'src/layout/scripts.php'; ?>

<script src="assets/js/progress.js"></script>
<script src="assets/js/installer.js"></script>

<?php include 'src/layout/foot.php'; ?>

