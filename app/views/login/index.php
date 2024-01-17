<?php
include __DIR__ . '/../header.php';
?>

<div id="overal-Container" style="position: relative; top: 10vh; margin-left: 1%;">
    <h1>Login view</h1>

    <div id="loginContainer">
    </div>
</div>

<script>
var globalAccount = null;

fetch('/api/session', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json; charset=utf-8'
        }
    })
    .then(response => response.json())
    .then(sessionData => {
        globalAccount = sessionData;
        if (globalAccount == null){
            addLoginElements();
        } else {
            addLogoutElements();
        }
    });

function addLoginElements(){
    var loginContainer = document.getElementById('loginContainer');
    loginContainer.innerHTML = '';
    loginContainer.innerHTML = `
        <form id="loginForm" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        </form>
        <button class="btn btn-primary" onclick="login()" id="loginButton">Login</button>
        <button class="btn btn-primary" onclick="window.location.href = '/registration'">Registration</button>
    `;
}

function addLogoutElements(){
    var loginContainer = document.getElementById('loginContainer');
    loginContainer.innerHTML = '';
    loginContainer.innerHTML = `
        <button class="btn btn-primary" onclick="logout()">Logout</button>
    `;
}

function removeLoginElements(){
    var loginForm = document.getElementById('loginForm');
    loginForm.remove();
    var loginButton = document.getElementById('loginButton');
    loginButton.remove();
}

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

            var loginLink = document.querySelector('a[href="/login"]').parentElement;
            loginLink.insertAdjacentHTML('beforebegin', `
                <li class="nav-item">
                    <a class="nav-link" href="/accounts">Accounts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/myaccount">My Account</a>
                </li>
            `);
            addLogoutElements();
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
    .then(function() {
        var accountsLink = document.querySelector('a[href="/accounts"]');
        var myAccountLink = document.querySelector('a[href="/myaccount"]');
        accountsLink.parentElement.remove();
        myAccountLink.parentElement.remove();
        addLoginElements();
    })
}
</script>


<?php
include __DIR__ . '/../footer.php';
?>