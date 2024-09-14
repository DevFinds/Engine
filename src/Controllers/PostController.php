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
        $request = $this->Request();
        $file = $this->request()->file('PostThumb');
        $file = $file->move('uploads');
        $fileUrl = null;
        $uploadedFile = $request->file('PostThumb');

       
    }
            
}




