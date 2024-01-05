<?php
include __DIR__ . '/../header.php';
?>

<h1>Registration view</h1>
<form id="registrationForm" method="POST">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="email">Email:</label>
    <input type="text" id="email" name="email" required><br><br>
    
    <label for="password">Password:</label>
    <input type="password" id="password1" name="password1" required><br><br>

    <label for="password">Password again:</label>
    <input type="password" id="password2" name="password2" required><br><br>
</form>


<button onclick="registration()">Registration</button>


<script>
function registration(){
    var username = document.getElementById('username').value;
    var email = document.getElementById('email').value;
    var password1 = document.getElementById('password1').value;
    var password2 = document.getElementById('password2').value;

    var data = {
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
    .then(response=>response.json())
    .then(response=> {
        console.log(response);
        if(response){
            alert('Registration successful');
        }else{
            alert('Invalid username or password OR accounts already exists');
        }
    })
    .catch(error=>console.error(error));

}
</script>
<?php
include __DIR__ . '/../footer.php';
?>