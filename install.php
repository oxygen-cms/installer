<?php
    require 'src/boot/start.php';

    $title = 'Installing';

    include 'src/layout/head.php';
?>

<header class="Banner cf">
    <h1 class="heading-alpha">Install</h1>
    <p class="Banner-step">3</p>
    <p class="Banner-step Banner-step--active">2</p>
    <p class="Banner-step ">1</p>
</header>
<div class="Body">

    <div class="Block Block--padded">

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

        <br>
        <h2 class="heading-gamma">Installation Log</h2>
        <br>

        <textarea id="install-log" rows="15" readonly>Contacting server...</textarea>

    </div>

</div>

<?php include 'src/layout/scripts.php'; ?>

<script src="assets/js/installer.js"></script>

<?php include 'src/layout/foot.php'; ?>

