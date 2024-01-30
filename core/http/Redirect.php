<?php

namespace Core\http;

use Core\http\RedirectInterface;



class Redirect implements RedirectInterface
{

    public function to(string $url)
    {
        header("Location: $url");
        exit;
    }
}
