<?php
use app\services\PostService;

class DeletePostController {
    public function index(){
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $postService = new PostService();
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

            if($postService->remove($post_id)){
                echo json_encode(true);
            } else {
                echo json_encode(null);
            }
        }
    }
}
?>