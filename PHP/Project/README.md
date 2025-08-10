# BondhuBazz - Social Media Platform

BondhuBazz is a dynamic and feature-rich social media web application built with native PHP, HTML, CSS, and JavaScript. It provides a platform for users to connect with friends, share their moments through posts with text and images, and interact with each other's content. The project also includes a comprehensive admin panel for managing the platform.

## ✨ Features

- **Authentication**: Secure user registration and login.
- **News Feed**: A central feed displaying posts from followed users.
- **Profile Management**: View and manage profiles, posts, and profile pictures.
- **Social Interactions**: Like, comment, edit, and delete comments.
- **Follow System**: Follow and unfollow other users.
- **Live User Search**: Instantly find other users on the platform.
- **Notifications**: Receive alerts for likes, comments, and new followers.
- **Settings & Deletion**: Update account details or request account deletion.
- **Admin Panel**: A full suite of tools for site management.

## 🛠️ Technology Stack

- **Backend**: PHP
- **Frontend**: HTML, CSS, JavaScript (for dynamic features like live search)
- **Database**: MySQL (using PDO for database operations)

## 🏛️ Architecture and File Structure

The project loosely follows a Model-View-Controller (MVC) pattern to separate concerns, making the codebase modular and easier to maintain.

- **Views (`HTML/`)**: These files are responsible for presenting data and the user interface. They contain the HTML structure and embed PHP code, often calling "view helper" functions to display dynamic content.
- **Controllers (`includes/.../...inc.php`)**: These are the main entry points for backend logic. They handle user requests from forms (POST) or links (GET), validate data, and coordinate between the Models and Views.
- **Models (`includes/.../...model.inc.php`)**: These files handle all database interactions. They contain the SQL queries for fetching, inserting, updating, and deleting data, abstracting the database logic from the rest of the application.
- **View Helpers (`includes/.../...view.inc.php`)**: These files contain PHP functions that are called directly from the View (`HTML/`) files. Their primary role is to fetch data (by calling model functions) and format it for display.

```
.
├── HTML/
│   ├── admin_dashboard.php
│   ├── admin_login.php
│   ├── admin_posts.php
│   ├── admin_requests.php
│   ├── admin_users.php
│   ├── comment.php
│   ├── deletion_success.php
│   ├── follower.php
│   ├── login_signup.php
│   ├── login.php
│   ├── loginFailed.html
│   ├── loginSuccess.html
│   ├── logout.php
│   ├── newsfeed.php
│   ├── notification.php
│   ├── profile_image.php
│   ├── profile.php
│   ├── search_users.php
│   ├── search.php
│   ├── ServerFailed.html
│   ├── setting.php
│   ├── suggested_profile.php
│   └── visiting_profile.php
├── includes/
│   ├── ADMIN_PANEL/
│   │   ├── admin_login.inc.php
│   │   ├── admin_logout.inc.php
│   │   ├── admin_model.inc.php
│   │   └── admin_view.inc.php
│   ├── COMMENT_PAGE/
│   │   ├── comment.inc.php
│   │   ├── comment.model.inc.php
│   │   └── comment.view.inc.php
│   ├── config_session.inc.php
│   ├── dbh.inc.php
│   ├── FOLLOW_PAGE/
│   │   └── Follow.inc.php
│   ├── LOGIN_PAGE/
│   │   ├── login_contr.inc.php
│   │   ├── login_model.inc.php
│   │   ├── login_view.inc.php
│   │   └── login.inc.php
│   ├── LOGOUT_PAGE/
│   │   ├── logout_view.inc.php
│   │   └── logout.inc.php
│   ├── NEWSFEED_PAGE/
│   │   ├── newsfeed_model.php
│   │   ├── newsfeed_view.php
│   │   ├── post_contr.inc.php
│   │   ├── post_model.inc.php
│   │   ├── post_view.inc.php
│   │   └── post.inc.php
│   ├── NOTIFICATION_PAGE/
│   │   ├── notification.inc.php
│   │   ├── notification.model.inc.php
│   │   └── notification.view.inc.php
│   ├── POST_REACTION/
│   │   └── post_reaction.inc.php
│   ├── PROFILE_PAGE/
│   │   ├── delete_post.inc.php
│   │   ├── profile_contr.php
│   │   ├── profile_model.php
│   │   ├── profile_view.php
│   │   └── profile.inc.php
│   ├── PROFILE_PICTURE_PAGE/
│   │   ├── profile_image.contr.inc.php
│   │   ├── profile_image.inc.php
│   │   └── profile_image.model.inc.php
│   ├── SEARCH_PAGE/
│   ├── SETTING_PAGE/
│   │   ├── setting.inc.php
│   │   ├── setting.model.inc.php
│   │   └── setting.view.inc.php
│   ├── SIGNUP_PAGE/
│   │   ├── signup_contr.inc.php
│   │   ├── signup_model.inc.php
│   │   ├── signup_view.inc.php
│   │   └── signup.inc.php
│   └── VISITING_PROFILE/
│       ├── visiting_profile.contr.inc.php
│       ├── visiting_profile.inc.php
│       ├── visiting_profile.model.inc.php
│       └── visiting_profile.view.inc.php
└── README.md
```

## ⚙️ Core Modules & Data Flow

Each major feature of the application is a self-contained "module" that combines files from the `HTML/` and `includes/` directories.

### 1. Authentication Module (Signup & Login)
- **Files**: `HTML/login_signup.php`, `HTML/login.php`, `includes/LOGIN_PAGE/`, `includes/SIGNUP_PAGE/`.
- **Data Flow**:
  1. A user fills out the signup or login form in the `HTML` file.
  2. The form data is **POSTed** to a controller (`signup.inc.php` or `login.inc.php`).
  3. The controller validates the data (e.g., checks for empty fields, valid email) using functions from its `_contr.inc.php` file.
  4. It then calls the model (`_model.inc.php`) to query the database (e.g., check if user exists, insert a new user).
  5. Based on the result, the user is redirected to the newsfeed on success (with a new session created via `config_session.inc.php`) or back to the form with an error message.

### 2. Search Module
- **Files**: `HTML/search.php`, `HTML/search_users.php`.
- **Data Flow**: The search functionality provides a live search experience without page reloads using AJAX-like principles.
  1. The user navigates to `search.php`, which presents a search input field.
  2. A JavaScript event listener on this input field triggers on every keystroke.
  3. The JavaScript sends a `fetch()` request to the `search_users.php` backend script, passing the current input value as a URL query parameter (e.g., `search_users.php?query=sadi`).
  4. The `search_users.php` script receives the query, fetches all users from the database, and then **filters this list in PHP** to find usernames that match the query.
  5. The script generates and `echo`es a raw HTML list (`<li>`) of the matching users.
  6. The JavaScript on `search.php` receives this HTML as the response and directly injects it into the page's user list container, instantly updating the results for the user.

### 3. Profile & Follow System Module
- **Files**: `HTML/profile.php`, `HTML/visiting_profile.php`, `HTML/follower.php`, `includes/PROFILE_PAGE/`, `includes/VISITING_PROFILE/`, `includes/FOLLOW_PAGE/`.
- **Data Flow**:
  1. When viewing a profile, the corresponding view helper (`_view.php`) is called.
  2. The view helper fetches the user's information and their posts from the model (`_model.php`).
  3. The "Follow" or "Unfollow" button is a form that **POSTs** an action to `visiting_profile.inc.php`.
  4. This controller calls the model to either `INSERT` or `DELETE` a record in the `follow` table and creates a notification for the user being followed.

### 4. Interaction Module (Likes & Comments)
- **Files**: `HTML/comment.php`, `includes/POST_REACTION/`, `includes/COMMENT_PAGE/`.
- **Data Flow (Likes)**: The "React" button is a form that **POSTs** to `post_reaction.inc.php`. This script checks if a "like" record exists for that user/post. If it does, it's deleted (unlike); otherwise, it's inserted (like) and a notification is created. The user is then redirected back to the original page.
- **Data Flow (Comments)**: A user submits a comment via the form on `comment.php`. The form **POSTs** to `comment.inc.php`, which uses its model to insert the comment into the `comments` table and create a notification. The page then reloads to display the new comment.

### 5. Admin Panel Module
- **Files**: `HTML/admin_*.php`, `includes/ADMIN_PANEL/`.
- **Data Flow**: The admin logs in via `admin_login.php`. Upon success, an admin-specific session is created. Each admin page (`admin_users.php`, `admin_posts.php`) fetches data using model functions. Actions like deleting a user are handled by the page itself, which receives a request, performs deletions across multiple tables (user, posts, comments, likes), and reloads the page.

## 🚀 Setup and Installation

1.  **Prerequisites**: A local server environment (XAMPP, WAMP, MAMP) with Apache, PHP, and MySQL.
2.  **Clone**: Clone the repository to your server's web directory (e.g., `htdocs`).
3.  **Database**:
    - Create a new database named `SOCIAL_MEDIA`.
    - The required tables are: `users`, `posts`, `comments`, `likes`, `follow`, `notifications`, `admins`, `deletion_requests`. You will need to create the schema based on the queries in the `.model.inc.php` files.
4.  **Connection**: Open `includes/dbh.inc.php` and update the database credentials.
5.  **Run**: Navigate to `http://localhost/your-project-folder/HTML/login_signup.php`.

## 🔑 Admin Panel

- **Access**: `http://localhost/your-project-folder/HTML/admin_login.php`
- **Default Credentials**:
  - Username: `admin`
  - Password: `password`
