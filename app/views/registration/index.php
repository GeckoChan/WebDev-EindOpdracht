<?php
include __DIR__ . '/../header.php';
?>

<style>
    .form-group {
        display: flex;
        justify-content: space-between;
    }
    label, input {
        display: inline-block;
    }
</style>

<div id="overal-Container" style="position: relative; top: 10vh">
    <h1 id='registrationH1'>Registration</h1>
    <form id="registrationForm" method="POST" onsubmit="event.preventDefault();" style="width: 20%;">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required maxlength="20">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required maxlength="128">
        </div>
        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password1" name="password1" required maxlength="128">
        </div>

        <div class="form-group">
            <label for="password">Password again:</label>
            <input type="password" id="password2" name="password2" required maxlength="128">
        </div>
        <button id="formButton" onclick="registration()">Registration</button>
    </form>
</div>

<script>
let globalAccount = null;

fetch('/api/session', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json; charset=utf-8'
        }
    })
    .then(response => response.json())
    .then(sessionData => {
        globalAccount = sessionData;
        if (globalAccount != null){
            updateAccountView();
        }
    });

function updateAccountView(){
    const registrationH1 = document.getElementById('registrationH1');
    registrationH1.innerHTML = 'Update Account';
    const formButton = document.getElementById('formButton');
    formButton.innerHTML = 'Update';
    formButton.onclick = updateAccount;
}

function updateAccount(){
    const registrationForm = document.getElementById('registrationForm');
    if (!registrationForm.checkValidity()) {
        alert('Please fill out all fields correctly.');
        return;
    }

    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password1 = document.getElementById('password1').value;
    const password2 = document.getElementById('password2').value;


    if (password1 !== password2){
        alert('Passwords do not match');
        return;
    }
    const data = {
        account_id: globalAccount.account_id,
        username: username,
        email: email,
        password1: password1,
        password2: password2
    };

    fetch('/api/updateaccount', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json; charset=utf-8'
    },
    body: JSON.stringify(data)
    })
    .then(response => { 
    response.clone().text().then(text => console.log("response updateaccount = " + text)); // debug
    return response.json();
    })
    .then(response=> {
        if(response){
            alert('update successful');
        }else{
            alert('Update failed, Account already exists or passwords do not match');
        }
    })
    .catch(error => {
        console.error('There has been a problem with your fetch operation: ', error);
        alert('There was a problem with the update. Please try again later.');
    });
}

function registration(){
    const registrationForm = document.getElementById('registrationForm');
    if (!registrationForm.checkValidity()) {
        alert('Please fill out all fields correctly.');
        return;
    }

    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password1 = document.getElementById('password1').value;
    const password2 = document.getElementById('password2').value;

    if (password1 !== password2){
        alert('Passwords do not match');
        return;
    }
    const data = {
        username: username,
        email: email,
        password1: password1,
        password2: password2
    };

    fetch('/api/registration', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json; charset=utf-8'
    },
    body: JSON.stringify(data)
    })
    .then(response => { 
    response.clone().text().then(text => console.log("response registration = " + text)); // debug
    return response.json();
    })
    .then(response=> {
        if(response){
            alert('Registration successful');
            window.location.href = '/login';
        }else{
            alert('Regristation failed, Account already exists or passwords do not match');
        }
    })
    .catch(error => {
        console.error('There has been a problem with your fetch operation: ', error);
        alert('There was a problem with the registration. Please try again later.');
    });

}
</script>
<?php
include __DIR__ . '/../footer.php';
?>