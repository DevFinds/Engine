<?php


namespace Source\Services;

use Source\Models\Post;
use Core\Database\DatabaseInterface;

class PostService
{
	public function __construct(
        private DatabaseInterface $db
    )
    {
        
    }

    /**
     * @return array<Post>
     */

    public function getPosts(): array
    {
        return $this->db->get('posts');
        $posts = array_map(fn($post) => 
        new Post(
            $post['id'],
            $post['title'],
            $post['description'],
            $post['content'],
            $post['author'],
            $post['date'],
            $post['image']
        ),
        
        $posts);
        return $posts;
    }
}