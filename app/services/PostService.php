<?php
namespace app\services;
use app\repositories\PostRepository;

class PostService {
    public function getAll(){
        $postRepository = new PostRepository();
        $posts = $postRepository->getAll();
        return $posts;
    }

    public function insert($post){
        $postRepository = new PostRepository();
        $postRepository->insert($post);
    }

    public function remove($post_id){
        $postRepository = new PostRepository();
        $postRepository->remove($post_id);
    }

    public function update($post){
        $postRepository = new PostRepository();
        $postRepository->update($post);
    }
}


?>