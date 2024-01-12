<?php
include __DIR__ . '/../header.php';
?>

<div id="postChoice-Container" class="position-fixed  w-100 d-flex justify-content-center" style="top: 9vh;">
    <div class="btn-group w-25 p-3 bg-dark rounded align-items-end">
        <button type="button" class="btn w-50 text-light" onclick="showAllPost()">All posts</button>
        <button type="button" class="btn w-50 text-light" onclick="showFriendsPost()">Friends posts</button>
    </div>
</div>

<div id="overal-Container" style="position: relative; height: 100vh; top: 20vh;" >
    <div id="readPost-Container" style="position: fixed; height: 55%; overflow-y: auto;">
    </div>
    <div id="writePost-Container" class="w-100 position-fixed bottom-0 d-flex justify-content-center align-items-end">
        <div class="post-input-container w-50 p-3 bg-dark rounded">
            <textarea id="postTextarea" class="form-control" rows="5" placeholder="What's happening?" style="resize: none;" maxlength="2000" oninput="updateCounter()"></textarea>
            <div id="counter" class="text-light">0 / 2000</div>
            <button class="btn btn-primary mt-2">Post</button>
        </div>
    </div>
</div>

<style>
    #readPost-Container {
    display: flex;
    flex-direction: column;
    align-items: center;
    overflow-y: auto;
    height: 75vh;
    padding-top: 3%;
}
</style>

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
    if (globalAccount == null){     // logged out
        loggedOutElements();
    } else {                        // logged in
        fetchAllPosts();
    }
});

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
    .then(response => response.json())
    .then(post => {
        textarea.value = '';
        updateCounter();
        fetchAllPosts();
    })
    .catch(error => console.log(error));

}

function fetchAllPosts() {
    fetch('/api/getposts', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json; charset=utf-8'
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
    readPostContainer.className = '';
    readPostContainer.className = 'container-fluid d-flex justify-content-center align-items-center text-light';
    readPostContainer.innerHTML = '';
    posts.forEach(post => {
        var postContainer = document.createElement('div');
        postContainer.className = 'post-container w-50 p-3 bg-dark rounded';
        postContainer.style = 'margin-bottom: 1rem;';
        let createdAt = new Date(post.created_at.date);
        let formattedDate = createdAt.toLocaleDateString() + ' ' + createdAt.toLocaleTimeString();

        postContainer.innerHTML = `
            <div class="post-header d-flex justify-content-between">
                <div class="post-username">${post.created_by.username}#${post.created_by.account_id}</div>
                <div class="post-date">${formattedDate}</div>
            </div>
            <div class="post-content">${post.content}</div>
        `;
        readPostContainer.appendChild(postContainer);
    });
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