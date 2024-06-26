<?php
include __DIR__ . '/../header.php';
?>

<div id='overal-Container' style="position: relative; top: 10vh; padding-top: 1%;">
    <div id='parentPost-Container'></div>
    <div id='reactions-Container' class="d-flex flex-column w-100 position-relative align-items-end" style="flex-direction: column; max-height: 40vh; overflow-y: auto; margin-top: 1%;"></div>
    <div id='writePost-Container' class="w-100 position-fixed bottom-0 d-flex justify-content-center" style="height: 20vh;">
        <div class="post-input-container w-50 p-3 bg-dark rounded">
            <textarea id="postTextarea" class="form-control" placeholder="Post a reaction" style="resize: none; height: 60%;" maxlength="2000" oninput="updateCounter()"></textarea>
            <div id="counter" class="text-light" style="height:20%;">0 / 2000</div>
            <button class="btn btn-primary mt-2" style="height:20%;" onclick="createReaction()">Post</button>
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
let globalAccount = null;
const urlParams = new URLSearchParams(window.location.search);
const postId = urlParams.get('post_id');

fetch('/api/session', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json; charset=utf-8'
        }
    })
.then(response => response.json())
.then(sessionData => {
    globalAccount = sessionData;
    fetchPostById();
    FetchReactionsForPost();
});

function fetchPostById(){
    fetch(`/api/getposts?post_id=${postId}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json; charset=utf-8',
            'X-Custom-Header': 'FetchPostById',
        }
    })
    .then(response => { 
        response.clone().text().then(text => console.log("response fetchPostById = " + text)); // debug
        return response.json(); 
    })
    .then(post => {
        displayPost(post[0]);
    })
    .catch(error => console.log(error));
}

function displayPost(post) {
    const container = document.getElementById('parentPost-Container');
    const postContainer = document.createElement('div');
    postContainer.className = 'post-container p-3 bg-dark rounded text-light';
    postContainer.style = 'margin-left: 1%; margin-right: 1%;';
    let createdAt = new Date(post.created_at.date);
    let formattedDate = createdAt.toLocaleDateString() + ' ' + createdAt.toLocaleTimeString();

    postContainer.innerHTML = `
        <div class="post-header d-flex justify-content-between">
            <div class="post-username">${post.created_by.username}#${post.created_by.account_id}</div>
            <div class="post-date">${formattedDate}</div>
        </div>
        <div class="post-content">${post.content}</div>
    `;

    postContainer.innerHTML += `
        <div class="post-footer d-flex justify-content-between">
            <div class="d-flex align-items-center">
                <a href="/post?post_id=${post.post_id}">
                    <button class="btn" style="color: white;">
                        <i class="fas fa-reply"></i>
                    </button>
                </a>
                <button class="btn" style="color: red;" onclick="likePost(${post.post_id})">
                    <i class="fa-regular fa-heart"></i>
                </button>
                <p id='likeCounter_${post.post_id}' class="mb-0">${post.likes} Like(s)</p>
            </div>
        </div>
    `;
    container.appendChild(postContainer);
}

function createReaction() {
    const textarea = document.getElementById('postTextarea');
    if (textarea.value.trim() === "") {
        return;
    }
    
    const post = {
        content: textarea.value,
        parent_post_id: postId
    };

    
    fetch('/api/createpost', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json; charset=utf-8',
            'X-Custom-Header': 'CreateReaction'
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
        FetchReactionsForPost();
    })
    .catch(error => console.log(error));
}

function FetchReactionsForPost() {
    fetch(`/api/getposts?post_id=${postId}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json; charset=utf-8',
            'X-Custom-Header': 'FetchReactionsForPost'
        }
    })
    .then(response => { 
    response.clone().text().then(text => console.log("response FetchReactionsForPost = " + text)); // debug
    return response.json();
    })
    .then(posts => {
        displayReactions(posts);
    })
    .catch(error => console.log(error));

}

function displayReactions(posts) {
    const container = document.getElementById('reactions-Container');
    container.innerHTML = '';

    posts.sort((a, b) => {
        let dateA = new Date(a.created_at.date);
        let dateB = new Date(b.created_at.date);
        return dateB - dateA; 
    });

    posts.forEach(post => {
        const postContainer = document.createElement('div');
        postContainer.className = 'post-container p-3 bg-dark rounded text-light w-75';
        postContainer.style = 'margin-right: 1%; margin-bottom: 1%;';
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

        postContainer.innerHTML += `
        <div class="post-footer d-flex justify-content-between">
            <div class="d-flex align-items-center">
                <a href="/post?post_id=${post.post_id}">
                    <button class="btn" style="color: white;">
                        <i class="fas fa-reply"></i>
                    </button>
                </a>
                <button class="btn" style="color: red;" onclick="likePost(${post.post_id})">
                    <i class="fa-regular fa-heart"></i>
                </button>
                <p id='likeCounter_${post.post_id}' class="mb-0">${post.likes} Like(s)</p>
            </div>
            ${post.created_by.account_id == globalAccount.account_id ? `
                <div>
                    <button class="btn" style='color: red;' onclick="deletePost(${post.post_id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            ` : ''}
        </div>
        `;
        container.appendChild(postContainer);
    });
}

function deletePost(post_id) {
    fetch('/api/deletepost', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json; charset=utf-8'
        },
        body: JSON.stringify({post_id: post_id})
    })
    .then(response => { 
    response.clone().text().then(text => console.log("response deletePost = " + text)); // debug
    return response.json();
    })
    .then(post => {
        FetchReactionsForPost();
    })
    .catch(error => console.log(error));
}

function likePost(post_id) {
    const post = {
        post_id: post_id
    };

    fetch('/api/likepost', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json; charset=utf-8'
        },
        body: JSON.stringify(post)
    })
    .then(response => { 
    response.clone().text().then(text => console.log("response likePost = " + text)); // debug
    return response.json();
    })
    .then(response => {
        const likeCounter = document.getElementById(`likeCounter_${post_id}`);
        likeCounter.textContent = response + ' Like(s)';

    })
    .catch(error => console.log(error));

}

function updateCounter() {
    const textarea = document.getElementById('postTextarea');
    const counter = document.getElementById('counter');
    counter.textContent = textarea.value.length + ' / 2000';
}

</script>

<?php
include __DIR__ . '/../footer.php';
?>