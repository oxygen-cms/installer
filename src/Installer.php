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
        $stage = isset($_POST['stage']) ? $_POST['stage'] : null;
        if($stage === null && isset($_GET['stage'])) {
            $stage = $_GET['stage'];
        }

        if($stage === 'download' || $stage === null) {
            $downloader = new ApplicationDownloader($this->progress, $this->output, $this->files);
            $downloader->run();
        }

        if($stage === 'composer' || $stage === null) {
            $this->runComposer();
        }

        if($stage === 'publishAssets' || $stage === null) {
            $this->publishAssets();
        }
    }

    /**
     * Runs composer.
     *
     * @throws \Oxygen\Installer\InstallationException if the installation fails
     * @return void
     */

    protected function runComposer() {
        putenv('COMPOSER=' . realpath(INSTALL_PATH . '/composer.json'));

        $this->progress->section('Beginning Installation');
        $this->progress->indeterminate();

        $input = new ArrayInput([
            'command' => 'update',
            '--working-dir' => INSTALL_PATH,
            '--no-interaction' => true
        ]);
        $application = new Application();
        $application->setAutoExit(false);
        $application->setCatchExceptions(false);

        $result = $application->run($input, $this->output, $this->progress);
        if($result !== 0) {
            throw new InstallationException($result);
        }
    }

    /**
     * Publishes assets.
     *
     * @return void
     */

    protected function publishAssets() {
        $this->progress->section('Publishing Assets');
        $this->progress->indeterminate();

        $this->progress->write('Booting Framework');
        $booter = new FrameworkBooter();
        $app = $booter->boot();

        $app->register('Illuminate\Foundation\Providers\PublisherServiceProvider');
        $publisher = $app->make('asset.publisher');

        $this->progress->write('Listing Packages');
        $vendorPath = base_path() . '/vendor';
        $vendorLength = strlen($vendorPath);
        foreach(glob($vendorPath . '/*/*', GLOB_ONLYDIR) as $directory) {
            // Check that that package has assets
            if(!is_dir($directory . '/public')) {
                continue;
            }

            $packages[] = substr($directory, $vendorLength + 1);
        }

        $this->progress->total(count($packages));

        foreach($packages as $package) {
            $this->progress->write('Publishing assets for ' . $package);

            $publisher->publishPackage($package, $vendorPath);

            $this->output->writeln('Published assets for ' . $package);
        }
    }

}