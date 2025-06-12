<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Profile</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #F3F4F6;
        }

        .navbar {
            background: #1E3A8A;
            padding: 1rem;
            color: #fff;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar button {
            background: none;
            border: none;
            color: #fff;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
        }

        .navbar button::before {
            content: "←";
        }

        .container {
            max-width: 1200px;
            margin: 1.5rem auto;
            padding: 0 1rem;
        }

        .profile-section {
            background: #fff;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .profile-section img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
        }

        .profile-section h2 {
            margin-bottom: 1rem;
            color: #1E3A8A;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .button-group button {
            background: #3B82F6;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }

        .button-group button.delete {
            background: #EF4444;
        }

        .posts-section {
            background: #fff;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .post {
            margin-bottom: 1.5rem;
        }

        .post-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .post-header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .post .actions button {
            background: none;
            border: none;
            color: #1E3A8A;
            font-weight: bold;
            cursor: pointer;
            margin-right: 1rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 0.5rem;
            }

            .profile-section img {
                width: 80px;
                height: 80px;
            }

            .button-group {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <button onclick="window.history.length > 1 ? history.back() : window.location.href='fallback.php';">Back</button>
    </nav>

    <div class="container">
        <div class="profile-section">
            <img src="https://via.placeholder.com/100" alt="User Profile" />
            <h2>John Doe</h2>
            <p>Email: john.doe@example.com</p>
            <p>Location: New York, USA</p>

            <form action="#" method="POST">
                <div class="button-group">
                    <button type="submit">Add Friend</button>
                </div>
            </form>
        </div>

        <div class="posts-section">
            <h3>Posts</h3>

            <div class="post">
                <div class="post-header">
                    <img src="https://via.placeholder.com/40" alt="Avatar" />
                    <h3>John Doe</h3>
                </div>
                <p>This is a demo post to test the layout and design.</p>
                <img src="https://via.placeholder.com/600x300" alt="Post Image" style="width:100%; border-radius:8px;" />
                <div class="actions">
                    <button>Like (3)</button>
                    <button>Comment (1)</button>
                </div>
            </div>

            <div class="post">
                <div class="post-header">
                    <img src="https://via.placeholder.com/40" alt="Avatar" />
                    <h3>John Doe</h3>
                </div>
                <p>Another post with sample content to show the layout.</p>
                <img src="https://via.placeholder.com/600x300" alt="Post Image" style="width:100%; border-radius:8px;" />
                <div class="actions">
                    <button>Like (10)</button>
                    <button>Comment (4)</button>
                </div>
            </div>

        </div>
    </div>
</body>
</html>