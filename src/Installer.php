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
        $this->files = new Filesystem();
        $this->files->cleanDirectory(STORAGE_PATH);
        $this->output = new StreamOutput(fopen(LOG_PATH, 'a', false), OutputInterface::VERBOSITY_DEBUG);
        $this->progress = new FileProgress(PROGRESS_PATH, $this->output);
    }

    /**
     * Installs the package.
     */

    public function run() {
        $downloader = new ApplicationDownloader($this->progress, $this->files);
        $downloader->run();

        putenv('COMPOSER=' . realpath(INSTALL_PATH . 'composer.json'));

        $this->progress->section('Beginning Installation');
        $this->progress->indeterminate();

        $input = new ArrayInput(['command' => 'update', '--working-dir' => INSTALL_PATH]);
        $application = new Application();
        $application->setAutoExit(false);
        $application->setCatchExceptions(false);

        $application->run($input, $this->output, $this->progress);
        $this->progress->section('Complete');
        $this->progress->notification('<h2>Installation Complete!</h2>
        <p>Oxygen is installed! But you now need to configure it...</p>
        <a href="configure.php" class="Button">Configure</a>');
        $this->progress->stopPolling();
    }



}