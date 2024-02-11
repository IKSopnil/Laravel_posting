<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opinion Vista</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <header class="bg-dark text-light text-center py-3">
        <h1>Opinion Vista</h1>
    </header>

    @auth

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card p-3 shadow-lg">
                    <p class="mb-3">You are logged in</p>
                    <form action="/logout" method="POST">
                        @csrf
                        <button class="btn btn-danger">Logout</button>
                    </form>

                    <div class="mt-3 border p-3">
                        <h2>Create a new post</h2>
                        <form action="/create_post" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input type="text" name="post_title" class="form-control" placeholder="Post title">
                            </div>
                            <div class="mb-3">
                                <textarea name="body" class="form-control" cols="30" rows="5" placeholder="Body content ..."></textarea>
                            </div>
                            <button class="btn btn-primary">Save post</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-3 shadow-lg">
                    <h2>All posts</h2>
                    @foreach ($posts as $post)
                    <div class="border mb-3 p-3">
                        <h3>{{ $post['title'] }} by {{$post->user->name }}</h3>
                        {{ $post['body'] }}
                        <p><a href="/edit-post/{{$post->id}}" class="btn btn-warning">Edit</a></p>
                        <form action="/delete/{{$post->id}}" method="post">
                            @csrf
                            @method('Delete')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @else
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card p-3 shadow-lg">
                    <h2>Login</h2>
                    <form action="/login" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input name="loginname" type="text" class="form-control" placeholder="Name">
                        </div>
                        <div class="mb-3">
                            <input name="loginpassword" type="password" class="form-control" placeholder="Password">
                        </div>
                        <button class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>

            <div class="col-md-6 ">
                <div class="card p-3 shadow-lg">
                    <h2>Register</h2>
                    <p>Don't have an account? Register now.</p>
                    <form action="/register" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input name="name" type="text" class="form-control" placeholder="Name">
                        </div>
                        <div class="mb-3">
                            <input name="email" type="text" class="form-control" placeholder="Email">
                        </div>
                        <div class="mb-3">
                            <input name="password" type="password" class="form-control" placeholder="Password">
                        </div>
                        <button class="btn btn-success">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endauth

    <!-- Bootstrap JS (optional, if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>
