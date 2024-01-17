<?php
include __DIR__ . '/../header.php';
?>

<div id="overal-Container" class="container-fluid row" style="position: relative; top: 10vh;">
    <div id="myAccountContainer" class="col-md-10">
    </div>
    <div id="myFriendsContainer" class="col-md-2">
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
        if (globalAccount == null){ // logged out
            loggedOutElements();
        } else { // logged in
            loggedInElements();
            fetchFriends();
        }
    });

function loggedInElements() {
    var myAccountContainer = document.getElementById('myAccountContainer');
    myAccountContainer.innerHTML = '';
    myAccountContainer.innerHTML = `<h1>My Account</h1>
    <p>Username: ${globalAccount.username}</p>
    <p>Email: ${globalAccount.email}</p>
    <button class="btn btn-primary" onclick="window.location.href = '/login'">Go to logout <i class="fas fa-sign-out-alt"></i></button>
    <button class="btn btn-primary" onclick="window.location.href = '/registration'">Update account info <i class="fas fa-edit"></i></button>
    <button class="btn btn-danger" onclick="deleteAccount()" >Delete Account <i class="fas fa-trash"></i></button>`;

    var myFriendsContainer = document.getElementById('myFriendsContainer');
    myFriendsContainer.innerHTML = '';
    myFriendsContainer.innerHTML = `<h1>My Friends</h1>`;

}

function loggedOutElements() {
    var myAccountContainer = document.getElementById('myAccountContainer');
    myAccountContainer.innerHTML = '';
    myAccountContainer.innerHTML = `<h1>You are not logged in!</h1>
    <button onclick="window.location.href = '/login'">Go to login</button>`;

}

function deleteAccount() {
    fetch('/api/deleteaccount', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json; charset=utf-8'
        }
    })
    .then(response => { 
        response.clone().text().then(text => console.log("response deleteAccount = " + text)); // debug
        return response.json();
    })
    .then(response => {
        if (response != null) {
            alert('test');
            //window.location.href = '/login'; 
        } else {
            alert('Please retry again later!');
        }
    })
    .catch(error => console.log(error));
}

function fetchFriends() {
    var data = {
        account_id: globalAccount.account_id
    }
    fetch('/api/friends', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json; charset=utf-8'
        },
        body: JSON.stringify(data)
    })
    .then(response => { 
    response.clone().text().then(text => console.log("response fetchFriends = " + text)); // debug
    return response.json();
    })
    .then(friends => {
        displayFriends(friends);
    })
    .catch(error => console.log(error));
}

function displayFriends(friends) {
    var myFriendsContainer = document.getElementById('myFriendsContainer');
    myFriendsContainer.innerHTML = '<h1>My Friends</h1>';

    if (friends == null) {
        myFriendsContainer.innerHTML += `<p>You currently have no friends :3</p>`;
        return;
    }

    friends.forEach(friend => {
        myFriendsContainer.innerHTML += `<p>${friend.username}#${friend.account_id}</p><br>`;
    });
}

</script>

<?php
include __DIR__ . '/../footer.php';
?>