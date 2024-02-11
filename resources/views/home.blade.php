<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opinion Vista</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 1rem;
            text-align: center;
        }

        .container {
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            padding: 20px;
        }

        .form-container {
            width: 45%;
        }

        .posts-container {
            width: 45%;
        }

        .form-container,
        .posts-container {
            background-color: #fff;
            border: 3px solid #333;
            padding: 20px;
            margin: 10px;
            border-radius: 8px;
        }

        form {
            margin-top: 10px;
        }

        button {
            padding: 8px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #555;
        }

    </style>
</head>

<body>

    <header>
        <h1>Opinion Vista</h1>
    </header>

    @auth

    <div class="container">
        <div class="form-container">
            <p>You are logged in</p>
            <form action="/logout" method="POST">
                @csrf
                <button>Logout</button>
            </form>

            <div style="border: 3px solid black;">
                <h2>Create a new post</h2>
                <form action="/create_post" method="POST">
                    @csrf
                    <input type="text" name="post_title" placeholder="Post title">
                    <textarea name="body" cols="30" rows="10" placeholder="Body content ..."></textarea>
                    <button>Save post</button>
                </form>
            </div>
        </div>

        <div class="posts-container">
            <div style="border: 3px solid black;">
                <h2>All posts</h2>
                @foreach ($posts as $post)
                <div style="border: 3px solid rgb(207, 187, 187); padding: 10px; margin: 10px;">
                    <h3>{{ $post['title'] }} by {{$post->user->name }}</h3>
                    {{ $post['body'] }}
                    <p><a href="/edit-post/{{$post->id}}">Edit</a></p>
                    <form action="/delete/{{$post->id}}" method="post">
                        @csrf
                        @method('Delete')
                        <button>Delete</button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    @else
    <div class="container">
        <div class="form-container">
            <div style="border: 3px solid black;">
                <h2>Login</h2>
                <form action="/login" method="POST">
                    @csrf
                    <input name="loginname" type="text" placeholder="Name"> <br>
                    <input name="loginpassword" type="password" placeholder="Password"><br>
                    <button>Login</button>
                </form>
            </div>
        </div>

        <div class="form-container">
            <div style="border: 3px solid black;">
                <h2>Register</h2>
                <p>Don't have an account? Register now.</p>
                <form action="/register" method="POST">
                    @csrf
                    <input name="name" type="text" placeholder="Name">
                    <input name="email" type="text" placeholder="Email">
                    <input name="password" type="password" placeholder="Password">
                    <button>Register</button>
                </form>
            </div>
        </div>

       
    </div>

    @endauth

</body>

</html>
