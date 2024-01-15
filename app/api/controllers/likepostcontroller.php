<?php
use app\services\LikeService;

class LikePostController {
    public function index(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $likeService = new LikeService();
            $json = file_get_contents('php://input');
            $data = json_decode($json);

            $reponse = $likeService->likePost($data->post_id, $_SESSION['account_id']);
            if($reponse){
                echo json_encode($reponse);
            } else {
                echo json_encode(0);
            }
        }
    }
}

?>