<?php

namespace Oxygen\Installer;

use Illuminate\Filesystem\Filesystem;
use Composer\Console\Application;
use Composer\Progress\FileProgress;
use Exception;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;
use ZipArchive;

class Installer {

    public function __construct() {
        ini_set('max_execution_time', 0);
        set_time_limit(0);

        $this->files = new Filesystem();
        $this->files->cleanDirectory(STORAGE_PATH);
        $this->output = new StreamOutput(fopen(LOG_PATH, 'a', false), OutputInterface::VERBOSITY_DEBUG);
        $this->progress = new FileProgress(PROGRESS_PATH, $this->output);
    }

    /**
     * Installs the package.
     */

    public function run() {
        $downloader = new ApplicationDownloader($this->progress, $this->output, $this->files);
        $downloader->run();

        $this->runComposer();
    }

    /**
     * Runs composer.
     *
     * @return void
     */

    protected function runComposer() {
        putenv('COMPOSER=' . realpath(INSTALL_PATH . 'composer.json'));

        $this->progress->section('Beginning Installation');
        $this->progress->indeterminate();

        $input = new ArrayInput(['command' => 'update', '--working-dir' => INSTALL_PATH]);
        $application = new Application();
        $application->setAutoExit(false);
        $application->setCatchExceptions(false);

        $result = $application->run($input, $this->output, $this->progress);
        if($result !== 0) {
            $this->progress->section('Failed');
            $this->progress->notification('<h2 class="heading-gamma">Installation Failed</h2>
            <p>The installation failed. Check the log above to see what went wrong.</p>', 'failed');
            $this->progress->stopPolling();
        } else {
            $this->progress->section('Complete');
            $this->progress->notification('<h2 class="heading-gamma">Installation Complete!</h2>
            <p>Oxygen is installed! But you now need to configure it...</p>
            <a href="configure.php" class="Button Button-color--blue">Configure</a>');
            $this->progress->stopPolling();
        }
    }


}