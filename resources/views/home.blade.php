<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    @auth

        <p>ur logged in</p>
        <form action="/logout" method="POST">
            @csrf
            <button>logout</button>
        </form>
        <div style="border: 3px solid black;">
            <h2>Create a new post</h2>
            <form action="/create_post" method="POST">
            @csrf
            <input type="text" name="post_title" placeholder="Post title">
            <textarea name="body" id="" cols="30" rows="10" placeholder="Body content ..."></textarea>
            <button>Save post</button>
            
        
        </form>
        </div>            
    @else
        <div style="border: 3px solid black;">
            <h2>Resgister</h2>
            <form action="/register" method="POST">
                @csrf
                <input name="name" type="text" placeholder="Name">
                <input name="email" type="text" placeholder="Email">
                <input name="password" type="password" placeholder="Password">
                <button>Register</button>
            </form>
        </div>

        <div style="border: 3px solid black;">
            <h2>Login</h2>
            <form action="/login" method="POST">
                @csrf
                <input name="loginname" type="text" placeholder="Name">
               
                <input name="loginpassword" type="password" placeholder="Password">
                <button>Login</button>
            </form>
        </div>

    @endauth

</body>

</html>
