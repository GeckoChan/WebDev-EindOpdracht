

-- Create the accounts table
CREATE TABLE accounts (
    account_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL
);

-- Create the friends table
CREATE TABLE friends (
    friend_id INT PRIMARY KEY AUTO_INCREMENT,
    account1_id INT,
    account2_id INT,
    status VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (account1_id) REFERENCES accounts(account_id),
    FOREIGN KEY (account2_id) REFERENCES accounts(account_id)
);

-- Create the posts table
CREATE TABLE posts (
    post_id INT PRIMARY KEY AUTO_INCREMENT,
    created_by INT,
    parent_post_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    post_content TEXT,
    FOREIGN KEY (created_by) REFERENCES accounts(account_id),
    FOREIGN KEY (parent_post_id) REFERENCES posts(post_id)
);

-- Create the likes table
CREATE TABLE likes (
    like_id INT PRIMARY KEY AUTO_INCREMENT,
    account_id INT,
    post_id INT,
    FOREIGN KEY (account_id) REFERENCES accounts(account_id),
    FOREIGN KEY (post_id) REFERENCES posts(post_id)
);
