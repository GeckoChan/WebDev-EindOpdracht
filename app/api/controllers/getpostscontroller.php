<?php
use app\services\PostService;

class GetPostsController{
    public function index(){
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $postService = new PostService();
            $response = null;
            if (!isset($_SERVER['HTTP_X_CUSTOM_HEADER'])) {
                $response = $postService->getAllPosts();
                echo json_encode($response);
                return;
            }

            switch ($_SERVER['HTTP_X_CUSTOM_HEADER']) {
                case 'FetchAllPosts':
                    $response = $postService->getAllPosts();
                    break;
                case 'FetchAllFriendPosts':
                    $response = $postService->getAllFriendPosts($_SESSION['account_id']);
                    break;
                case 'FetchPostById':
                    $post_id = $_GET['post_id'];
                    $response = $postService->getPostById($post_id);
                    break;
                case 'FetchReactionsForPost':
                    $parent_post_id = $_GET['post_id'];
                    $response = $postService->getReactionsForPost($parent_post_id);
                    break;
                default:
                    break;
            }

            echo json_encode($response);
        } 
    }
}
?>

           