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
                    class="Button Button-color--white" role="tab" data-switch-to-tab="queue">
                    Queue
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

            <form action="doConfigureQueue.php" method="POST" class="Form--sendAjax" data-tab="queue">

                <div class="Row--visual">
                    <h2 class="heading-gamma">Queue</h2>
                </div>

                <div class="Row">
                    <label for="queue.driver" class="Form-label flex-item">Driver</label>
                    <select name="queue[driver]" id="queue.driver" class="Form-content flex-item">
                        <option value="sync" selected>Sync</option>
                        <option value="beanstalkd">Beanstalkd</option>
                        <option value="sqs">Amazon SQS</option>
                        <option value="iron">IronMQ</option>
                        <option value="redis">Redis</option>
                    </select>
                </div>

                <div class="Row--visual" data-hide-if="sync,sqs,beanstalkd,redis" style="display: none;">
                    <a href="https://hud.iron.io/users/new" target="_blank" class="Button Button-color--blue">Create an IronMQ Account</a>
                </div>

                <div class="Row" data-hide-if="sync,sqs,redis" style="display: none;">
                    <label for="queue.host" class="Form-label flex-item">Host</label>
                    <input type="text" name="queue[host]" id="queue.host" class="Form-content flex-item">
                </div>

                <div class="Row" data-hide-if="sync,beanstalkd,iron,redis" style="display: none;">
                    <label for="queue.key" class="Form-label flex-item">Key</label>
                    <input type="text" name="queue[key]" id="queue.key" class="Form-content flex-item">
                </div>

                <div class="Row" data-hide-if="sync,beanstalkd,iron,redis" style="display: none;">
                    <label for="queue.secret" class="Form-label flex-item">Secret</label>
                    <input type="text" name="queue[secret]" id="queue.secret" class="Form-content flex-item">
                </div>

                <div class="Row" data-hide-if="sync,beanstalkd,sqs,redis" style="display: none;">
                    <label for="queue.project" class="Form-label flex-item">Project ID</label>
                    <input type="text" name="queue[project]" id="queue.project" class="Form-content flex-item">
                </div>

                <div class="Row" data-hide-if="sync,beanstalkd,sqs,redis" style="display: none;">
                    <label for="queue.token" class="Form-label flex-item">Token</label>
                    <input type="text" name="queue[token]" id="queue.token" class="Form-content flex-item">
                </div>

                <div class="Row" data-hide-if="sync" style="display: none;">
                    <label for="queue.queue" class="Form-label flex-item">Name</label>
                    <input type="text" name="queue[queue]" id="queue.queue" class="Form-content flex-item">
                </div>

                <div class="Row" data-hide-if="sync,beanstalkd,iron,redis" style="display: none;">
                    <label for="queue.region" class="Form-label flex-item">Region</label>
                    <input type="text" name="queue[region]" id="queue.region" class="Form-content flex-item" value="us-east-1">
                </div>

                <div class="Row" data-hide-if="sync,sqs,iron,redis" style="display: none;">
                    <label for="queue.ttr" class="Form-label flex-item">Seconds To Run</label>
                    <input type="number" name="queue[ttr]" id="queue.ttr" class="Form-content flex-item" value="60">
                </div>

                <div class="Row" data-hide-if="sync,sqs,beanstalkd,redis" style="display: none;">
                    <label class="Form-label flex-item">Encrypt</label>
                    <input class="Form-content flex-item" name="queue[encrypt]" type="hidden" value="false">
                    <input class="Form-content flex-item Form-toggle" id="queue.encrypt" checked="checked" name="queue[encrypt]" type="checkbox" value="true">
                    <label for="queue.encrypt" class="Form-toggle-label">
                        <span class="on">Yes</span>
                        <span class="off">No</span>
                    </label>
                </div>

                <div class="Row" data-hide-if="sync,sqs,beanstalkd,redis" style="display: none;">
                    <label class="Form-label flex-item">Create Queue Automatically</label>
                    <input class="Form-content flex-item" name="queue[make]" type="hidden" value="false">
                    <input class="Form-content flex-item Form-toggle" id="queue.make" checked="checked" name="queue[make]" type="checkbox" value="true">
                    <label for="queue.make" class="Form-toggle-label">
                        <span class="on">Yes</span>
                        <span class="off">No</span>
                    </label>
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

