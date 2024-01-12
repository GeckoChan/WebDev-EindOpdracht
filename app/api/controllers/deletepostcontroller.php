<?php
use app\services\PostService;

class DeletePostController {
    public function index(){
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $postService = new PostService();
            $json = file_get_contents('php://input');
            $data = json_decode($json);
            if($postService->remove($data->post_id)){
                echo json_encode(true);
            } else {
                echo json_encode(null);
            }
        }
    }
}
?>