<?php
include __DIR__ . '/../header.php';
?>

<h1>My Account view</h1>

<?php
if (isset($_SESSION['username'])){
    echo $_SESSION['username'] . "#" . $_SESSION['account_id'];
    echo "<br>";
    echo $_SESSION['email'];
} else {
    echo "You are not logged in";
}
?>

<?php
include __DIR__ . '/../footer.php';
?>