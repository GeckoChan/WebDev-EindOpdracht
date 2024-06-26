<?php
include __DIR__ . '/../header.php';
?>

<div id="overal-container" class="container-fluid row m-0 p-0" style="position: relative; top: 10vh;">
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
        if (globalAccount != null){
            createContainers();
            fetchAccounts();
            getAllFriendRequests();
        } else {
            var container = document.createElement('div');
            container.className = 'container-fluid';
            container.innerHTML = '<h1>You are not logged in!</h1>';
            document.body.appendChild(container);
        }
    })
    .catch(error => console.error(error));

    function createContainers() {
        var overallContainer = document.getElementById('overal-container');

        var accountsContainer = document.createElement('div');
        accountsContainer.id = 'accounts-container';
        accountsContainer.className = 'border border-primary rounded container-fluid col-md-3';

        var friendrequestsContainer = document.createElement('div');
        friendrequestsContainer.id = 'friendrequests-container';
        friendrequestsContainer.className = 'border border-primary rounded container-fluid col-md-9';

        overallContainer.appendChild(accountsContainer);
        overallContainer.appendChild(friendrequestsContainer);

        document.body.appendChild(overallContainer);
    }

    function fetchAccounts()     {
        fetch('/api/accounts', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                }
            })
            .then(response => { 
            response.clone().text().then(text => console.log("response fetchAccounts = " + text)); // debug
            return response.json();
            })
            .then(accounts => {displayAccounts(accounts);})
            .catch(error => console.error(error));
    }

    function displayAccounts(accounts) {
        const container = document.getElementById('accounts-container');
        container.innerHTML = '<h1>Accounts</h1>';

        accounts.forEach(function(account) {
            const accountDiv = document.createElement('div');
            accountDiv.className = 'border border-primary rounded p-2 m-2 bg-dark text-white';
            accountDiv.innerHTML = `<p>Tag: ${account.username}#${account.account_id} <br> Email: ${account.email}</p>`;

            if (account.username != globalAccount.username) {
                accountDiv.innerHTML += `<button class="btn btn-primary" onclick="addFriend('${account.account_id}')">Add Friend</button>`;
            } 
            container.appendChild(accountDiv); 
        });
    }

    function addFriend(account_id) {
        const data = {
            target_account_id: account_id,
            current_account_id: globalAccount.account_id
        };

        fetch('/api/addfriends', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                },
                body: JSON.stringify(data)
            })
            .then(response => { 
            response.clone().text().then(text => console.log("response AddFriend = " + text)); // debug
            return response.json();
            })
            .then(response => {
                if (response) {
                    alert('Friend request send');
                } else {
                    alert('Already existing pending friend request or already friends!');
                }
            })
            .catch(error => console.error(error));
    }

    function getAllFriendRequests() {
        fetch('/api/addfriends', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                }
            })
            .then(response => { 
            response.clone().text().then(text => console.log("response getAllFriendRequests = " + text)); // debug
            return response.json();
            })  
            .then(friendrequests => {
                displayFriendsRequests(friendrequests);
            })
            .catch(error => console.error(error));
    
    }

    function displayFriendsRequests(friendrequests){
        const container = document.getElementById('friendrequests-container');
        container.innerHTML = '<h1>Friend Requests</h1>';
        if (friendrequests == null) {
            container.innerHTML += '<p>No friend requests</p>';
        } else {
            friendrequests.forEach(function(friendrequest) {
                const friendrequestDiv = document.createElement('div');
                friendrequestDiv.id = friendrequest.account_id;
                friendrequestDiv.className = 'border border-primary rounded p-2 m-2 bg-dark text-white';
                friendrequestDiv.innerHTML = `  <p>Tag: ${friendrequest.username}#${friendrequest.account_id} <br> Email: ${friendrequest.email}</p>
                                                <button class="btn btn-primary" onclick="acceptFriend('${friendrequest.account_id}')">Accept Friend</button>
                                                <button class="btn btn-danger" onclick="declineFriend('${friendrequest.account_id}')">Decline Friend</button>`;
                container.appendChild(friendrequestDiv); 
            });
        }
    }

    function acceptFriend(account_id) {
        const data = {
            target_account_id: account_id,
            current_account_id: globalAccount.account_id
        };

        console.log(data);

        fetch('/api/friendrequest', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json; charset=utf-8',
                    'X-Custom-Header': 'AcceptFriend'
                },
                body: JSON.stringify(data)
            })
        .then(response => { 
            response.clone().text().then(text => console.log("response acceptFriend = " + text)); // debug
            return response.json();
        })
        .then(response => {
            if (response) {
                alert('Friend request accepted');
                const friendrequestDiv = document.getElementById(account_id);
                friendrequestDiv.remove();   
            } else {
                alert('Please retry again later');
            }
        })
        .catch(error => console.error(error));
    }

    function declineFriend(account_id) {
        const data = {
            target_account_id: account_id,
            current_account_id: globalAccount.account_id
        };

        fetch('/api/friendrequest', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json; charset=utf-8',
                    'X-Custom-Header': 'DeclineFriend'             
                },
                body: JSON.stringify(data)
            })
        .then(response => { 
            response.clone().text().then(text => console.log("response declineFriend = " + text)); // debug
            return response.json();
        })
        .then(response => {
            if (response) {
                alert('Friend request declined');
                const friendrequestDiv = document.getElementById(account_id);
                friendrequestDiv.remove();   
            } else {
                alert('Please retry again later');
            }
        })
        .catch(error => console.error(error));
    }
</script>

<?php
include __DIR__ . '/../footer.php';
?>