<?php
include __DIR__ . '/../header.php';
?>

<div id="postChoice-Container" class="position-fixed  w-100 d-flex justify-content-center" style="top: 9vh;">
    <div class="btn-group w-25 p-3 bg-dark rounded align-items-end">
        <button type="button" class="btn w-50 text-light" onclick="showAllPost()">All posts</button>
        <button type="button" class="btn w-50 text-light" onclick="showFriendsPost()">Friends posts</button>
    </div>
</div>

<div id="overal-Container" style="position: relative; top: 20vh;">
    <div id="readPost-Container" class="d-flex align-items-center text-light" style="flex-direction: column; max-height: 55vh; overflow-y: auto;" >
    </div>
    <div id="writePost-Container" class="w-100 position-fixed bottom-0 d-flex justify-content-center align-items-end">
        <div class="post-input-container w-50 p-3 bg-dark rounded">
            <textarea id="postTextarea" class="form-control" rows="5" placeholder="What's happening?" style="resize: none;" maxlength="2000" oninput="updateCounter()"></textarea>
            <div id="counter" class="text-light">0 / 2000</div>
            <button class="btn btn-primary mt-2" onclick="createPost()">Post</button>
        </div>
    </div>
</div>

<style>
    .post-link {
            color: inherit;
            text-decoration: none;
        }

    .post-link:hover {
        color: your-hover-color-here;
    }
</style>

<script>    
var globalAccount = null;
var globalFriendPosts = false;

fetch('/api/session', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json; charset=utf-8'
        }
    })
.then(response => response.json())
.then(sessionData => {
    globalAccount = sessionData;
    if (globalAccount == null){     // logged out
        loggedOutElements();
    } else {                        // logged in
        fetchAllPosts();
    }
});

function showAllPost() {
    if (globalFriendPosts == true) {
        globalFriendPosts = false;
        fetchAllPosts();
    }
}

function showFriendsPost() {
    if (globalFriendPosts == false) {
        globalFriendPosts = true;
        fetchAllFriendPosts();
    }
}

function createPost() {
    var textarea = document.getElementById('postTextarea');
    var post = {
        content: textarea.value
    };
    fetch('/api/createpost', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json; charset=utf-8'
        },
        body: JSON.stringify(post)
    })
    .then(response => { 
    response.clone().text().then(text => console.log("response createPost = " + text)); // debug
    return response.json();
    })
    .then(post => {
        textarea.value = '';
        updateCounter();
        fetchAllPosts();
    })
    .catch(error => console.log(error));

}

function deletePost(post_id) {
    var post = {
        post_id: post_id
    };

    fetch('/api/deletepost', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json; charset=utf-8'
        },
        body: JSON.stringify(post)
    })
    .then(response => { 
    response.clone().text().then(text => console.log("response deletePost = " + text)); // debug
    return response.json();
    })
    .then(post => {
        fetchAllPosts();
    })
    .catch(error => console.log(error));
}

function fetchAllPosts() {
    fetch('/api/getposts', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json; charset=utf-8',
            'X-Custom-Header': 'FetchAllPosts'
        }
    })
    .then(response => { 
    response.clone().text().then(text => console.log("response fetchAllPosts = " + text)); // debug
    return response.json();
    })
    .then(posts => {
        displayPosts(posts);
    })
    .catch(error => console.log(error));
}

function fetchAllFriendPosts() {
    fetch('/api/getposts', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json; charset=utf-8',
            'X-Custom-Header': 'FetchAllFriendPosts'
        }
    })
    .then(response => { 
    response.clone().text().then(text => console.log("response fetchAllPosts = " + text)); // debug
    return response.json();
    })
    .then(posts => {
        displayPosts(posts);
    })
    .catch(error => console.log(error));
}

function displayPosts(posts){
    var readPostContainer = document.getElementById('readPost-Container');
    readPostContainer.innerHTML = '';

    // sort posts by date descending
    posts.sort((a, b) => {
        let dateA = new Date(a.created_at.date);
        let dateB = new Date(b.created_at.date);
        return dateB - dateA; // sort in descending order
    });

    posts.forEach(post => {
        var postContainer = document.createElement('div');
        postContainer.className = 'post-container w-50 p-3 bg-dark rounded';
        postContainer.style = 'margin-top: 1rem;';
        let createdAt = new Date(post.created_at.date);
        let formattedDate = createdAt.toLocaleDateString() + ' ' + createdAt.toLocaleTimeString();

        postContainer.innerHTML = `
            <a class="post-link" href="/post?post_id=${post.post_id}">
                <div class="post-header d-flex justify-content-between">
                    <div class="post-username">${post.created_by.username}#${post.created_by.account_id}</div>
                    <div class="post-date">${formattedDate}</div>
                </div>
                <div class="post-content">${post.content}</div>
            </a>
        `;

        if(post.created_by.account_id == globalAccount.account_id){
            postContainer.innerHTML += `
                <div class="post-footer d-flex justify-content-end">
                    <button class="btn btn-danger" onclick="deletePost(${post.post_id})">Delete</button>
                </div>
            `;
        }
        readPostContainer.appendChild(postContainer);
    });
    
    var endOfPosts = document.createElement('div');
    endOfPosts.className = 'post-container w-50 p-3 bg-dark rounded';
    endOfPosts.style = 'margin-top: 1rem;';
    endOfPosts.innerHTML = `
        <div class="post-header d-flex justify-content-center">
            <div>Sorry no more posts :(</div>
        </div>
    `;
    readPostContainer.appendChild(endOfPosts);

}

function updateCounter() {
    var textarea = document.getElementById('postTextarea');
    var counter = document.getElementById('counter');
    counter.textContent = textarea.value.length + ' / 2000';
}

function loggedOutElements() {
    var readPostContainer = document.getElementById('readPost-Container');
    readPostContainer.className = '';
    readPostContainer.className = 'container-fluid d-flex justify-content-center align-items-center';
    readPostContainer.innerHTML = '';
    readPostContainer.innerHTML = `<h1>You are not logged in!</h1>`;
}
</script>

<?php
include __DIR__ . '/../footer.php'; 
?>