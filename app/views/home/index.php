<?php
include __DIR__ . '/../header.php';
?>

<h1>Home view</h1>

<?php
echo "Hello " . $_SESSION['username'];
?>

<?php
include __DIR__ . '/../footer.php';
?>