<?php

namespace Core;

class Render
{

    public function page($controller)
    {
        include_once APP_PATH . "/themes/Basic/pages/" . strtolower($controller) . ".php";
    }
}
