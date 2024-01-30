<?php


namespace Core;

interface RenderInterface
{
    public function page($controller);
    public function component($component_name);
}
