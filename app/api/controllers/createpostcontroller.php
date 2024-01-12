<?php
use app\services\PostService;
use app\models\Post;
use app\models\Account;

class CreatePostController {
    public function index(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postService = new PostService();
            $post = new Post();
            
            $json = file_get_contents('php://input');
            $data = json_decode($json);
            $post->setContent($data->content);

            $account = new Account();
            $account->setAccountId($_SESSION['account_id']);
            $post->setCreatedBy($account);


            if ($postService->insertPost($post)){
                echo json_encode(true);
            } else {
                echo json_encode(null);
            }
        }
    }    
}

?>