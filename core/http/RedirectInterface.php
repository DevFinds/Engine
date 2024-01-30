<?php


namespace Core\http;

interface RedirectInterface
{
    public function to(string $url);
}
