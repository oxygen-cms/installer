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
        $this->output = new StreamOutput(fopen(LOG_PATH, 'a', false), OutputInterface::VERBOSITY_DEBUG);
        $this->progress = new FileProgress(PROGRESS_PATH, $this->output);
    }

    /**
     * Installs the package.
     */

    public function run() {
        $this->files->cleanDirectory(STORAGE_PATH);

        $downloader = new ApplicationDownloader($this->progress, $this->files);
        $downloader->run();

        putenv('COMPOSER=' . realpath(INSTALL_PATH . 'composer.json'));

        $this->progress->section('Beginning Installation');
        $this->progress->indeterminate();

        $input = new ArrayInput(['command' => 'update', 'working-dir' => INSTALL_PATH]);
        $application = new Application();
        $application->setAutoExit(false);
        $application->setCatchExceptions(false);

        try {
            $application->run($input, $this->output, $this->progress);
            $this->progress->notification('Installation Complete');
            $this->progress->section('Complete');
            $this->progress->stopPolling();
        } catch(Exception $e) {
            $this->progress->notification($e->getMessage(), 'failed');
            $this->progress->stopPolling();
        }
    }



}