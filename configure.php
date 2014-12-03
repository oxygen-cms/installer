<?php
    require 'src/boot/start.php';

    $title = 'Configure';

    include 'src/layout/head.php';
?>

<header class="Banner cf">
    <h1 class="heading-alpha">Configure</h1>
    <p class="Banner-step Banner-step--active">3</p>
    <p class="Banner-step">2</p>
    <p class="Banner-step">1</p>
</header>
<div class="Page">

    <form action="doConfigure.php" method="POST">

        <div class="Block">

            <div class="Row--visual">
                <h2 class="heading-beta">Database</h2>
            </div>

            <div class="Row">
                <label for="database.driver" class="Form-label flex-item">Driver</label>
                <select name="database[driver]" id="database.driver" class="Form-content flex-item">
                    <option value="mysql">MySQL</option>
                    <option value="pgsql">Postgres</option>
                    <option value="sqlite">SQLite</option>
                    <option value="sqlsrv">SQL Server</option>
                </select>
            </div>

            <div class="Row" data-hide-if="sqlite">
                <label for="database.host" class="Form-label flex-item">Host</label>
                <input type="text" name="database[host]" id="database.host" class="Form-content flex-item" value="localhost">
            </div>

            <div class="Row" data-hide-if="sqlite">
                <label for="database.port" class="Form-label flex-item">Port</label>
                <input type="number" name="database[port]" id="database.port" class="Form-content flex-item">
            </div>

            <div class="Row" data-hide-if="sqlite">
                <label for="database.username" class="Form-label flex-item">Username</label>
                <input type="text" name="database[username]" id="database.username" class="Form-content flex-item">
            </div>

            <div class="Row" data-hide-if="sqlite">
                <label for="database.password" class="Form-label flex-item">Password</label>
                <input type="password" name="database[password]" id="database.password" class="Form-content flex-item">
            </div>

            <div class="Row" data-hide-if="sqlite">
                <label class="Form-label flex-item">Mode</label>
                <div class="Form-content flex-item">
                    <input type="radio" name="database[mode]" id="database.mode.createNew" value="createNew">
                    <label for="database.mode.createNew">Create A New Database Automatically</label><br>
                    <input type="radio" name="database[mode]" id="database.mode.useExisting" value="useExisting">
                    <label for="database.mode.useExisting">Use An Existing Database</label><br>
                </div>
            </div>

            <div class="Row">
                <label for="database.database" class="Form-label flex-item">Database Name</label>
                <input type="text" name="database[database]" id="database.database" class="Form-content flex-item">
            </div>

            <div class="Row--visual">
                <h2 class="heading-beta">Accounts</h2>
            </div>

            <div class="Row">
                <label for="account.username" class="Form-label flex-item">Username</label>
                <input type="text" name="account[username]" id="account.username" class="Form-content flex-item">
            </div>

            <div class="Row">
                <label for="account.password" class="Form-label flex-item">Password</label>
                <input type="password" name="account[password]" id="account.password" class="Form-content flex-item">
            </div>

            <div class="Row">
                <label for="account.fullName" class="Form-label flex-item">Full Name</label>
                <input type="text" name="account[fullName]" id="account.fullName" class="Form-content flex-item">
            </div>

            <div class="Row">
                <label for="account.email" class="Form-label flex-item">Email Address</label>
                <input type="email" name="account[email]" id="account.email" class="Form-content flex-item">
            </div>

            <div class="Form-footer Row--visual">
                <button type="submit" class="Button Button-color--green">Done</button>
            </div>
        </div>
    </form>

</div>

<?php include 'src/layout/scripts.php'; ?>

<script src="assets/js/configure.js"></script>

<?php include 'src/layout/foot.php'; ?>

