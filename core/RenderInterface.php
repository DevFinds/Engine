<?php


namespace Core;

interface RenderInterface
{
    public function page($controller);
    public function component($component_name);
    public function enqueue_all_scripts();
    public function enqueue_all_styles();
    public function enqueue_selected_styles(array $styles_list = []);
    public function enqueue_selected_scripts(array $scripts_list = []);
}
