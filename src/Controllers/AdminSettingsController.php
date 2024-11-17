<?php


namespace Source\Controllers;

use DirectoryIterator;
use Core\Config\Config;
use Core\Controller\Controller;

class AdminSettingsController extends Controller
{
    private Config $config;

    public function __construct()
    {
    }

    public function settings()
    {
        $config = $this->getConfig();
        $themes_dir_directories = APP_PATH . '/themes';
        $themes_list = [];
        foreach (new DirectoryIterator($themes_dir_directories) as $directory) {
            if ($directory->isDir() && !$directory->isDot()) {
                array_push($themes_list, $directory->getFilename());
            }
        }
        $this->render("admin/dashboard/settings", ['config' => $config, 'themes' => $themes_list]);
    }
}
