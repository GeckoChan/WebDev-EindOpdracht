<?php
use app\services\PostService;
use app\models\Post;
use app\models\Account;

class CreatePostController {
    public function index(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postService = new PostService();
            $json = file_get_contents('php://input');
            $data = json_decode($json);
            
            if (!isset($data->content)) {
                echo json_encode(null);
                return;
            }

            $post = new Post();
            $content = htmlspecialchars($data->content, ENT_QUOTES, 'UTF-8');
            $post->setContent($content);

            $account = new Account();
            $account->setAccountId($_SESSION['account_id']);
            $post->setCreatedBy($account);

            $response = null;
            switch ($_SERVER['HTTP_X_CUSTOM_HEADER']) {
                case 'CreatePost':
                    $response = $postService->insertPost($post) ? true : null;
                    break;
                case 'CreateReaction':
                    $post->setParentPostId($data->parent_post_id);
                    $response = $postService->insertReaction($post) ? true : null;
                    break;
                default:
                    break;
            }
            echo json_encode($response);
        }
    }    
}

?>