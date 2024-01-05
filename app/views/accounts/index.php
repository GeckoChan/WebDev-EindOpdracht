<?php
include __DIR__ . '/../header.php';
?>

<div id="overal-container" class="container-fluid row">
    <div id="accounts-container" class="border border-primary rounded container-fluid">
    </div>
    <div id="friendrequests-container" class="border border-primary rounded container-fluid">
    </div>
</div>
<script>
    function fetchAccounts()     {
        fetch('/api/accounts', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                }
            })
            .then(response => response.json())
            .then(accounts => {
                displayAccounts(accounts);
            })
            .catch(error => console.error(error));
    }

    function displayAccounts(accounts) {
        var container = document.getElementById('accounts-container');
        container.className = 'border border-primary rounded container-fluid col-md-6';
        container.innerHTML = '<h1>Accounts</h1>';

        accounts.forEach(function(account) {
            var accountDiv = document.createElement('div');
            accountDiv.className = 'border border-primary rounded p-2 m-2 bg-dark text-white';
            accountDiv.innerHTML = `
                <p>Tag: ${account.username}#${account.account_id} <br> Email: ${account.email}</p>
            `;
            if (account.username != '<?php echo $_SESSION['username'] ?>') {
                accountDiv.innerHTML += `
                    <button onclick="AddFriend('${account.account_id}')">Add Friend</button>
                `;
            } 
            container.appendChild(accountDiv); 
        });
    }

    function AddFriend(account_id) {
        var data = {
            target_account_id: account_id,
            current_account_id: '<?php echo $_SESSION['account_id'] ?>'
        };

        fetch('/api/addfriends', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json; charset=utf-8'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(response => {
                console.log(response);
                if (response) {
                    alert('Friend added');
                } else {
                    alert('ALready existing pending friend request!');
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
            .then(response => response.json())
            .then(friendrequests => {
                console.log(friendrequests)
                if (friendrequests == null) {
                    return;
                }
                displayFriendsRequests(friendrequests);
            })
            .catch(error => console.error(error));
    
    }

    function displayFriendsRequests(friendrequests){
        var container = document.getElementById('friendrequests-container');
        container.className = 'border border-primary rounded container-fluid col-md-6';
        container.innerHTML = '<h1>Friend Requests</h1>';

        friendrequests.forEach(function(friendrequest) {
            var friendrequestDiv = document.createElement('div');
            friendrequestDiv.className = 'border border-primary rounded p-2 m-2 bg-dark text-white';
            friendrequestDiv.innerHTML = `<p>Tag: ${friendrequest.username}#${friendrequest.account_id} <br> Email: ${friendrequest.email}</p>`;
            friendrequestDiv.innerHTML += `<button onclick="AcceptFriend('${friendrequest.account1_id}')">Accept Friend</button>`;
            container.appendChild(friendrequestDiv); 
        });
    
    }
    // Call the fetchAccounts function to load the accounts on page load
    fetchAccounts();
    getAllFriendRequests();
</script>


<?php
include __DIR__ . '/../footer.php';
?>