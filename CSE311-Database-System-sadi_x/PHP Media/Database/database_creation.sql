CREATE DATABASE SOCIAL_MEDIA;
USE SOCIAL_MEDIA;



CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    dob DATE,
    GENDER varchar(40) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE posts (
    post_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    text_content TEXT,
    image_url VARCHAR(255),
    like_count INT DEFAULT 0,
    comment_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

CREATE TABLE likes (
    like_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    post_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(user_id, post_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (post_id) REFERENCES posts(post_id)
);

CREATE TABLE comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    post_id INT,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (post_id) REFERENCES posts(post_id)
);

CREATE TABLE friends (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    friend_id INT NOT NULL,
    status ENUM('pending', 'accepted') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(user_id, friend_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (friend_id) REFERENCES users(user_id)
);
CREATE TABLE notifications (
    notification_id INT AUTO_INCREMENT PRIMARY KEY,
    recipient_id INT NOT NULL,                    -- User receiving the notification
    sender_id INT,                                -- User who triggered the notification (can be NULL for system notifications)
    status varchar(100) NOT NULL,
    post_id INT,                                  -- Nullable: refers to the post related to the notification (if any)
    comment_id INT,                               -- Nullable: refers to the comment related to the notification (if any)
    message TEXT,                                 -- Optional descriptive message
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (recipient_id) REFERENCES users(user_id),
    FOREIGN KEY (sender_id) REFERENCES users(user_id),
    FOREIGN KEY (post_id) REFERENCES posts(post_id),
    FOREIGN KEY (comment_id) REFERENCES comments(comment_id)
);
CREATE TABLE follow (
    F_ID INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    FOLLOWER_ID INT(11) NOT NULL,
    FOLLOWING_ID INT(11) NOT NULL,
    FOLLOWER_NAME VARCHAR(100) NOT NULL,
    FOLLOWER_GENDER VARCHAR(100) NOT NULL,
    FOLLOWER_DATE TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    FOREIGN KEY FOLLOWER_ID REFERENCES USERS(ID),
    FOREIGN KEY FOLLOWING_ID REFERENCES USERS(ID)
);

