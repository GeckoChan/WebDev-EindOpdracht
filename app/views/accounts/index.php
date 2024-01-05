<?php
include __DIR__ . '/../header.php';
?>

<h1>Accounts view</h1>


<div id="accounts-container"></div>

<script>
    function fetchAccounts() {
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
        container.innerHTML = '';

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
                    alert('Something went wrong');
                }
            })
            .catch(error => console.error(error));
    }

    // Call the fetchAccounts function to load the accounts on page load
    fetchAccounts();
</script>


<?php
include __DIR__ . '/../footer.php';
?>