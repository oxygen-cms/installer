<?php

namespace Oxygen\Installer;

use FilesystemIterator;
use Illuminate\Filesystem\Filesystem;
use Composer\Progress\ProgressInterface;
use Exception;
use ZipArchive;

class ApplicationDownloader {

    /**
     * Downloads the application.
     *
     * @param \Composer\Progress\ProgressInterface $progress
     * @param \Illuminate\Filesystem\Filesystem    $filesystem
     */

    public function __construct(ProgressInterface $progress, Filesystem $filesystem) {
        $this->progress = $progress;
        $this->files = $filesystem;
    }

    /**
     * Downloads the application.
     *
     * @throws \Exception
     */

    public function run() {
        $this->downloadApplication();
        $this->extractApplication();
        $this->moveApplication();
    }

    /**
     * Updates progress information.
     *
     * @param $resource
     * @param $download_size
     * @param $downloaded
     * @param $upload_size
     * @param $uploaded
     */

    protected function onDownloadProgress($resource, $download_size, $downloaded, $upload_size, $uploaded) {
        if($download_size > 0) {
            $this->progress->total($download_size);
        }

        $percentage = round($downloaded / ($download_size ?: 1) * 100);

        $this->progress->write($percentage . ($download_size ? '%' : ' bytes downloaded'), $downloaded);
    }

    /**
     * Downloads the application.
     *
     */

    protected function downloadApplication() {
        $this->progress->section('Downloading Application');
        $this->progress->indeterminate();

        $this->zipPath = STORAGE_PATH . '/application.zip';

        set_time_limit(0);
        $fp = fopen($this->zipPath, 'w+'); //This is the file where we save the    information
        $ch = curl_init('https://api.github.com/repos/laravel/laravel/zipball');//Here is the file we are downloading, replace spaces with %20
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FILE, $fp); // write curl response to file
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, [$this, 'onDownloadProgress']);
        curl_setopt($ch, CURLOPT_NOPROGRESS, 0); // needed to make progress function work
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_exec($ch); // get curl response
        curl_close($ch);
        fclose($fp);
    }

    /**
     * Extracts the application.
     *
     * @throws \Exception
     */

    protected function extractApplication() {
        $this->progress->write('Extracting Application...');

        $zip = new ZipArchive();
        if($zip->open($this->zipPath) === true) {
            for($i = 0; $i < $zip->numFiles; $i++) {
                $stat = $zip->statIndex($i);
                if(!isset($this->oldPath) && $stat['size'] === 0) {
                    $this->oldPath = $stat['name'];
                }
            }
            $zip->extractTo(STORAGE_PATH);
            $zip->close();
            $this->files->delete($this->zipPath);
        } else {
            throw new Exception('Zip archive could not be opened');
        }
    }

    /**
     * Moves the application.
     *
     * @throws \Exception
     */

    protected function moveApplication() {
        $this->progress->write('Moving Application');

        if(!isset($this->oldPath)) {
            throw new Exception('Extracted archive not found');
        }

        $oldPath = STORAGE_PATH . '/' . $this->oldPath;
        $files = scandir($oldPath);
        $newPath = INSTALL_PATH;
        foreach($files as $name) {
            $path = $newPath . $name;
            if(file_exists($path)) {
                if(is_dir($path)) {
                    $this->files->deleteDirectory($path);
                } else {
                    $this->files->delete($path);
                }

            }

            if($name != '.' && $name != '..') {
                $this->files->move($oldPath . $name, $newPath . $name);
            }
        }

        $this->files->deleteDirectory($oldPath);
    }

}