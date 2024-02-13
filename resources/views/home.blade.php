<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opinion Vista</title>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        /* Light mode styles */
        body {

            overflow-y: scroll;
            background-color: var(--bg-color);
            color: var(--font-color);
        }

        [data-theme="dark"] {
            --font-color: #fefefe;
            --bg-color: #121212;
        }

        .card {
            background-color: var(--card-bg-color);
            color: var(--card-font-color);
            transition: background-color 0.4s, color 0.4s;
            /* Add transition for smooth color change */
        }

        [data-theme="dark"] .card {
            --card-font-color: #fefefe;
            --card-bg-color: #212121;
        }

        /* Add these styles for light mode (optional) */
        [data-theme="light"] .card {
            --card-font-color: #0f0f0f;
            --card-bg-color: #f8f9fa;
        }


        :root {
            --font-color: #0f0f0f;
            --bg-color: #fefefe;
        }

        [data-theme="dark"] {
            --font-color: #fefefe;
            --bg-color: #121212;
        }

        .switch {
            position: fixed;
            bottom: 20px;
            right: 20px;
        }

        .theme-switch {
            display: flex;
            align-items: center;
        }

        .theme-switch input {
            display: none;
        }

        .slider {
            width: 40px;
            height: 20px;
            background-color: #ccc;
            border-radius: 10px;
            margin-left: 10px;
            position: relative;
            cursor: pointer;
            transition: background-color 0.4s;
        }

        .slider:before {
            content: '';
            width: 20px;
            height: 20px;
            background-color: #fff;
            border-radius: 50%;
            position: absolute;
            top: 0;
            left: 0;
            transition: transform 0.4s;
        }

        input:checked+.slider {
            background-color: #2b2b2b;
        }

        input:checked+.slider:before {
            transform: translateX(20px);
        }

        .mini-text {
            font-size: 0.8em;
            /* Adjust the size as needed */
            color: #888;
            /* Adjust the color as needed */
            margin-left: 5px;
            /* Add margin for spacing */
        }
    </style>


</head>

<body>

    <header class="bg-dark text-light text-center py-3">
        <h1>Opinion Vista</h1>
    </header>


    <div class="switch">
        <label class="theme-switch" for="checkbox">
            <input type="checkbox" id="checkbox" />
            <div class="slider"></div>
        </label>
    </div>

    <script>
        const toggleSwitch = document.getElementById('checkbox');
        const currentTheme = localStorage.getItem('theme');

        if (currentTheme) {
            document.documentElement.setAttribute('data-theme', currentTheme);
            toggleSwitch.checked = currentTheme === 'dark';
        }

        toggleSwitch.addEventListener('change', function() {
            const theme = toggleSwitch.checked ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        });
    </script>

    @auth

        <div class="container mt-4">
            <div class="row">
                
                <div class="col-md-6 mb-4">
                    <div class="card p-3 shadow-lg">
                        <h2>All posts</h2>
                        @foreach ($posts as $post)
                            <div class="border mb-3 p-3 position-relative">
                                <h3>{{ $post->title }} <span class="mini-text">by "{{ $post->user->name }}"</span></h3>
                                {{ $post->body }}

                                <!-- Edit and Delete buttons in the top right corner -->
                                <div class="position-absolute top-0 end-0 mt-2 mr-2">
                                    @if (auth()->check() && auth()->user()->id === $post->user_id)
                                        <a href="/edit-post/{{ $post->id }}" class="btn btn-warning">Edit</a>
                                        <form action="/delete/{{ $post->id }}" method="post" class="d-inline">
                                            @csrf
                                            @method('Delete')
                                            <button class="btn btn-danger">Delete</button>
                                        </form>
                                    @endif
                                </div>

                                <!-- Like and Dislike buttons with icons -->
                                <div class="mt-3">
                                    <button class="btn btn-success mr-2 like-btn" data-post-id="{{ $post->id }}"><i
                                            class="fas fa-thumbs-up"></i></button>
                                    <button class="btn btn-danger dislike-btn" data-post-id="{{ $post->id }}"><i
                                            class="fas fa-thumbs-down"></i></button>
                                </div>
                            </div>
                        @endforeach

                        <script>
                            // Assuming you have jQuery included for simplicity
                            $('.like-btn').on('click', function() {
                                var postId = $(this).data('post-id');
                                toggleLike(postId, 'like');
                            });

                            $('.dislike-btn').on('click', function() {
                                var postId = $(this).data('post-id');
                                toggleLike(postId, 'dislike');
                            });

                            function toggleLike(postId, type) {
                                $.ajax({
                                    type: 'POST',
                                    url: `/${type}/${postId}`,
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                    },
                                    success: function(response) {
                                        // Handle success, you may update UI accordingly
                                        console.log(response);
                                    },
                                    error: function(error) {
                                        console.error(error);
                                    },
                                });
                            }
                        </script>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
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

                <div class="col-md-6">
                    <div class="card p-3 shadow-lg">
                        <h2>Register</h2>
                        <p>Don't have an account? <br>Register now.</p>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
</body>

</html>
