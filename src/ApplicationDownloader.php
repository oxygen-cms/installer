<?php

namespace Oxygen\Installer;

use FilesystemIterator;
use Illuminate\Filesystem\Filesystem;
use Composer\Progress\ProgressInterface;
use Exception;
use Symfony\Component\Console\Output\OutputInterface;
use ZipArchive;

class ApplicationDownloader {

    /**
     * Downloads the application.
     *
     * @param \Composer\Progress\ProgressInterface $progress
     * @param \Illuminate\Filesystem\Filesystem    $filesystem
     */

    public function __construct(ProgressInterface $progress, OutputInterface $output, Filesystem $filesystem) {
        $this->progress = $progress;
        $this->output = $output;
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

        $fp = fopen($this->zipPath, 'w+');
        $ch = curl_init(DOWNLOAD_URL);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, [$this, 'onDownloadProgress']);
        curl_setopt($ch, CURLOPT_NOPROGRESS, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_exec($ch);
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

        $this->moveDirectory(realpath(STORAGE_PATH . '/' . $this->oldPath), realpath(INSTALL_PATH));
    }

    /**
     * Moves a directory recursively.
     */

    protected function moveDirectory($oldPath, $newPath) {
        $files = scandir($oldPath);
        foreach($files as $name) {
            if($name != '.' && $name != '..') {
                $oldFile = $oldPath . '/' . $name;
                $newFile = $newPath . '/' . $name;

                if($this->files->exists($newFile) && $this->files->isDirectory($newFile)) {
                    $this->moveDirectory($oldFile, $newFile);
                } else {
                    $this->files->move($oldFile, $newFile);
                }
            }
        }

        $this->files->deleteDirectory($oldPath);
    }

}