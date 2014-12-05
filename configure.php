<?php
    require 'src/boot/start.php';

    $title = 'Configuration';

    include 'src/layout/head.php';
?>

<header class="Banner cf">
    <h1 class="heading-alpha">Configure</h1>
    <p class="Banner-step Banner-step--active">3</p>
    <p class="Banner-step">2</p>
    <p class="Banner-step">1</p>
</header>
<div class="Page">

    <div class="Block">

        <div class="Row--visual">
            <div class="ButtonTabGroup TabSwitcher-tabs" role="tablist">
                <button
                    type="button"
                    class="Button Button-color--white" role="tab" data-switch-to-tab="database" data-default-tab>
                    Database
                </button>
                <button
                    type="button"
                    class="Button Button-color--white" role="tab" data-switch-to-tab="accounts">
                    Accounts
                </button>
            </div>
        </div>

        <div class="TabSwitcher-content">

            <form action="doConfigureDatabase.php" method="POST" class="Form--sendAjax" data-tab="database">

                <div class="Row--visual">
                    <h2 class="heading-gamma">Database</h2>
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

                <div class="Row">
                    <label for="database.database" class="Form-label flex-item">Database Name</label>
                    <input type="text" name="database[database]" id="database.database" class="Form-content flex-item">
                </div>

                <div class="Form-footer Row--visual">
                    <button type="submit" class="Button Button-color--green">Configure</button>
                </div>

            </form>

            <form action="doConfigureAccount.php" method="POST" class="Form--sendAjax" data-tab="accounts">

                <div class="Row--visual">
                    <h2 class="heading-gamma">Accounts</h2>
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
                    <button type="submit" class="Button Button-color--green">Create</button>
                </div>
            </form>

        </div>

</div>

<?php include 'src/layout/scripts.php'; ?>

<script src="assets/js/configure.js"></script>

<?php include 'src/layout/foot.php'; ?>

