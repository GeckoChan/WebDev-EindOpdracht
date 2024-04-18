<!DOCTYPE html>
<html lang="en">

<head>
    <title>Webdev-EindOpdracht</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <main>
        <header class="d-flex justify-content-center py-3 bg-dark position-fixed w-100" style="height: 10vh;">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Home</a>
                        </li>
                        <?php if (isset($_SESSION['account_id'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/accounts">Accounts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/myaccount">My Account</a>
                            </li>
                        <?php endif; ?>
                        <?php if (!isset($_SESSION['account_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Login</a>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/api/getposts">Post Api</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>