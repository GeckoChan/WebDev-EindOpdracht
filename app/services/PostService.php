<?php
namespace app\services;
use app\repositories\PostRepository;

class PostService {
    public function getAllPosts(){
        $postRepository = new PostRepository();
        $posts = $postRepository->getAllPosts();
        return $posts;
    }

    public function getAllFriendPosts($account_id){
        $postRepository = new PostRepository();
        $posts = $postRepository->getAllFriendPosts($account_id);
        return $posts;
    }

    public function getPostById($post_id){
        $postRepository = new PostRepository();
        $post = $postRepository->getPostById($post_id);
        return $post;
    }

    public function insertPost($post){
        $postRepository = new PostRepository();
        return $postRepository->insertPost($post);
    }

    public function remove($post_id){
        $postRepository = new PostRepository();
        return $postRepository->remove($post_id);
    }

    public function update($post){
        $postRepository = new PostRepository();
        $postRepository->update($post);
    }
}


?>