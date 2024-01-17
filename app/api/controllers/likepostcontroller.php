<?php
use app\services\LikeService;

class LikePostController {
    public function index(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $likeService = new LikeService();
            $json = file_get_contents('php://input');
            $data = json_decode($json);

            if (!isset($data->post_id)) {
                echo json_encode(null);
                return;
            }

            $post_id = filter_var($data->post_id, FILTER_VALIDATE_INT);
            if ($post_id === false) {
                echo json_encode(null);
                return;
            }

            $reponse = $likeService->likePost($post_id, $_SESSION['account_id']);
            if($reponse){
                echo json_encode($reponse);
            } else {
                echo json_encode(0);
            }
        }
    }
}
