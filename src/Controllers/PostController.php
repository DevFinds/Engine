<?php


namespace Source\Controllers;

use Core\Controller\Controller;

class PostController extends Controller
{
    public function post_creation()
    {
        $this->render('admin/post/create');
    }

    public function create_new_post()
    {
        $file = $this->request()->file('PostThumb');
        dd($file->move('uploads'));
    }
}
