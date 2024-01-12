<?php
use app\services\PostService;

class GetPostsController{
    public function index(){
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $postService = new PostService();

            if($_SERVER['HTTP_X_CUSTOM_HEADER'] == 'FetchAllPosts'){
                $posts = $postService->getAllPosts();
                if ($posts){
                    echo json_encode($posts);
                } else {
                    echo json_encode(null);
                }
            } else if ($_SERVER['HTTP_X_CUSTOM_HEADER'] == 'FetchAllFriendPosts'){
                $posts = $postService->getAllFriendPosts($_SESSION['account_id']);
                if ($posts){
                    echo json_encode($posts);
                } else {
                    echo json_encode(null);
                }
            } else if ($_SERVER['HTTP_X_CUSTOM_HEADER'] == 'FetchPostById'){
                $post_id = $_GET['post_id'];
                $post = $postService->getPostById($post_id);
                if ($post){
                    echo json_encode($post);
                } else {
                    echo json_encode(null);
                }
            } else {
                echo json_encode(null);
            }

        } 

    }
}

?>