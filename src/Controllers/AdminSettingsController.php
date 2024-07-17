<?php


namespace Source\Controllers;

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
        $this->render("admin/dashboard/settings", ['config' => $config]);
    }
}
