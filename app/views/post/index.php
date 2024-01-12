<?php
include __DIR__ . '/../header.php';
?>

<div id='overal-Container' style="position: relative; top: 12vh;">
    
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
    fetchPostById();
});

function fetchPostById(){
    const urlParams = new URLSearchParams(window.location.search);
    const postId = urlParams.get('post_id');

    fetch(`/api/getposts?post_id=${postId}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json; charset=utf-8',
            'X-Custom-Header': 'FetchPostById',
        }
    })
    .then(response => { 
        response.clone().text().then(text => console.log("response fetchAllPosts = " + text)); // debug
        return response.json(); 
    })
    .then(post => {
        displayPost(post[0]);
    })
    .catch(error => console.log(error));
}

function displayPost(post) {
    var container = document.getElementById('overal-Container');
    var postContainer = document.createElement('div');
    postContainer.className = 'post-container p-3 bg-dark rounded text-light';
    postContainer.style = 'margin-left: 1%; margin-right: 1%;';
    let createdAt = new Date(post.created_at.date);
    let formattedDate = createdAt.toLocaleDateString() + ' ' + createdAt.toLocaleTimeString();

    postContainer.innerHTML = `
        <div class="">
            <div class="post-username">${post.created_by.username}#${post.created_by.account_id}</div>
            <div class="post-date">${formattedDate}</div>
        </div>
        <div class="post-content">${post.content}</div>
    `;

    container.appendChild(postContainer);

}

</script>

<?php
include __DIR__ . '/../footer.php';
?>