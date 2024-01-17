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
        if (globalAccount == null){ // logged out
            loggedOutElements();
        } else { // logged in
            loggedInElements();
            fetchFriends();
        }
    });

function loggedInElements() {
    const myAccountContainer = document.getElementById('myAccountContainer');
    myAccountContainer.innerHTML = '';
    myAccountContainer.innerHTML = `<h1>My Account</h1>
    <p>Username: ${globalAccount.username}</p>
    <p>Email: ${globalAccount.email}</p>
    <button class="btn btn-primary" onclick="logout()">Logout <i class="fas fa-sign-out-alt"></i></button>
    <button class="btn btn-primary" onclick="window.location.href = '/registration'">Update account info <i class="fas fa-edit"></i></button>
    <button class="btn btn-danger" onclick="deleteAccount()" >Delete Account <i class="fas fa-trash"></i></button>`;

    const myFriendsContainer = document.getElementById('myFriendsContainer');
    myFriendsContainer.innerHTML = '';
    myFriendsContainer.innerHTML = `<h1>My Friends</h1>`;

}

function loggedOutElements() {
    const myAccountContainer = document.getElementById('myAccountContainer');
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
    const data = {
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
    const myFriendsContainer = document.getElementById('myFriendsContainer');
    myFriendsContainer.innerHTML = '<h1>My Friends</h1>';

    if (friends == null) {
        myFriendsContainer.innerHTML += `<p>You currently have no friends :3</p>`;
        return;
    }

    myFriendsContainer.innerHTML += `<p>You currently have ${friends.length} friend(s)</p>`;
    friends.forEach(friend => {
        myFriendsContainer.innerHTML += `
            <div id="friend#${friend.account_id}" class="friend-row" style="margin: 1%; display: flex; justify-content: space-between;">
                <p style="display: flex; align-items: center;">${friend.username}#${friend.account_id}</p>
                <button onclick="removeFriend(${friend.account_id})" class="btn btn-danger" style="display: flex; align-items: center;"><i class="fas fa-trash"></i></button>
            </div>
        `;
    });
}

function removeFriend(account_id) {
    const data = {
        target_account_id: account_id,
        current_account_id: globalAccount.account_id
    };
    
    fetch('/api/friends', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json; charset=utf-8'
        },
        body: JSON.stringify(data)
    })
    .then(response => { 
    response.clone().text().then(text => console.log("response removeFriend = " + text)); // debug
    return response.json();
    })
    .then(response => {
        if (response) {
            const friendElement = document.getElementById('friend#' + account_id);
            if (friendElement) {
                friendElement.remove();
            }
        } else {
            alert('Please retry again later!');
        }
    })
    .catch(error => console.log(error));
}

function logout(){

    fetch('/api/logout', {
        method: 'POST',
    })
    .then(function() {
        window.location.href = '/login';
    })
}

</script>

<?php
include __DIR__ . '/../footer.php';
?>