<?php
use app\services\PostService;

class GetPostsController{
    public function index(){
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $postService = new PostService();
            $posts = $postService->getAllPosts();
            if ($posts){
                echo json_encode($posts);
            } else {
                echo json_encode(null);
            }
        } 
    }
}

?>