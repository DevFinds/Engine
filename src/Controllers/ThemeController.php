<?php


namespace Source\Controllers;

use Core\Controller\Controller;
use Directory;
use DirectoryIterator;

class ThemeController extends Controller
{

    public function index()
    {
        $this->render('theme');
    }

    public function switch_theme()
    {
        $request = $this->request();
        $theme = $request->allInputs('theme');

        $this->getConfig()->setJson('app.theme', $theme);
    }

    public function getThemesDirectories()
    {
        $themes_dir_directories = APP_PATH . '/themes';
        $themes_list = [];
        foreach(new DirectoryIterator($themes_dir_directories) as $directory) {
            if ($directory->isDir() && !$directory->isDot()) {
                array_push($themes_list, $directory->getFilename());
            }
        }
        $this->render('/admin/dashboard/settings/switch-theme', ['themes_list' => $themes_list]);
    }

}
