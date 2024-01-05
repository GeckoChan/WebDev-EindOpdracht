<?php
include __DIR__ . '/../header.php';
?>


<h1>Login view</h1>

<form id="loginForm" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>
    
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>
</form>
<button onclick="login()">Login</button>
<button onclick="logout()">Logout</button>
<button onclick="window.location.href = '/registration'">Registration</button>



<script>
function login(){
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    var data = {
        username: username,
        password: password
    };
    console.log(data);

    fetch('/api/login', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json; charset=utf-8'
    },
    body: JSON.stringify(data)
    })
    .then(response=>response.json())
    .then(response=> {
        console.log(response);
        if(response){
            alert('Login successful');
        }else{
            alert('Invalid username or password');
        }
    })
    .catch(error=>console.error(error));
}

function logout(){
    fetch('/api/logout', {
        method: 'POST',
    })
}
</script>


<?php
include __DIR__ . '/../footer.php';
?>