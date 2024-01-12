<?php
require __DIR__ . '/controller.php';

class PostController extends Controller {
    public function index() {
        require __DIR__ . '/../views/post/index.php';
    }
}
?>