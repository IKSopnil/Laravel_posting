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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    


</head>

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
}

[data-theme="dark"] .card {
    --card-font-color: #fefefe;
    --card-bg-color: #212121;
}

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
    bottom: 100px;
    right: 20px;
}

.theme-switch {
    display: flex;
    align-items: center;
}

.theme-switch input {
    display: none;
}

.theme_slider {
    width: 40px;
    height: 20px;
    background-color: #ccc;
    border-radius: 10px;
    margin-left: 10px;
    position: relative;
    cursor: pointer;
    transition: background-color 0.4s;
}

.theme_slider:before {
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

input:checked + .theme_slider {
    background-color: #2b2b2b;
}

input:checked + .theme_slider:before {
    transform: translateX(20px);
}

.mini-text {
    font-size: 0.8em;
    color: #888;
    margin-left: 5px;
}

    </style>

<body>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Pacifico&display=swap');

        header {
            font-family: 'Pacifico', cursive;
            background-color: #343a40;
            /* Adjust the background color as needed */
            color: #ffffff;
            /* Adjust the text color as needed */
            text-align: center;
            padding: 20px 0;
        }
    </style>


    <header class="bg-dark text-light text-center py-3">
        <h1>Opinion Vista</h1>
    </header>


    <div class="switch">
        <label class="theme-switch" for="checkbox">
            <input type="checkbox" id="checkbox" />
            <div class="theme_slider"></div>
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
                
                                <!-- Displaying posted time in relative format -->
                                <p class="posted-text">
                                    Posted
                                    @if ($post->created_at->diffInDays(now()) <= 7)
                                        {{ $post->created_at->diffForHumans() }}
                                    @else
                                        {{ $post->created_at->format('F j, Y \a\t h:i A') }}
                                    @endif
                                </p>
                
                                {{ $post->body }}
                
                                <!-- Edit and Delete buttons -->
                                <div class="position-absolute top-0 end-0 mt-2 mr-2">
                                    @if (auth()->check() && auth()->user()->id === $post->user_id)
                                        <!-- Three-dot menu for small screens -->
                                        <div class="dropdown d-md-none">
                                            <button class="btn btn-neon dropdown-toggle" type="button" id="postMenu{{ $post->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="postMenu{{ $post->id }}">
                                                <li><a class="dropdown-item" href="/edit-post/{{ $post->id }}">Edit</a></li>
                                                <li>
                                                    <form action="/delete/{{ $post->id }}" method="post">
                                                        @csrf
                                                        @method('Delete')
                                                        <button type="submit" class="dropdown-item">Delete</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                
                                        <!-- Edit and Delete buttons for larger screens -->
                                        <div class="d-none d-md-block">
                                            <a href="/edit-post/{{ $post->id }}" class="btn btn-neon">Edit</a>
                                            <form action="/delete/{{ $post->id }}" method="post" class="d-inline">
                                                @csrf
                                                @method('Delete')
                                                <button class="btn btn-neon">Delete</button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                
                                <!-- Like and Dislike buttons with icons -->
                                <div class="mt-3">
                                    <button class="btn btn-success btn-neon mr-2 like-btn" data-post-id="{{ $post->id }}"><i class="fas fa-thumbs-up"></i></button>
                                    <button class="btn btn-danger btn-neon dislike-btn" data-post-id="{{ $post->id }}"><i class="fas fa-thumbs-down"></i></button>
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
                    <div class="card p-3 shadow-lg position-relative">
                        <div class="dropdown m-2">
                            <button class="btn btn-neon position-absolute top-0 end-0 m-2" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user "></i> <!-- Font Awesome person icon -->
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li>
                                    <form action="/logout" method="POST">
                                        @csrf
                                        <button class="dropdown-item btn-neon" type="submit">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                
                        <p class="mb-3" style="color: rgb(84, 140, 0)">You are logged in.</p>
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
                                <button class="btn btn-neon">Save post</button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <style>
                    /* Style for the "Posted" text */
                    .posted-text {
                        font-size: 14px;
                        /* Adjust the font size as needed */
                        color: #555;
                        /* Change the color to a shade of gray */
                        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
                        /* Add a subtle shadow effect */
                    }

                    /* Add these styles to give the buttons a neon effect */
                    .btn-neon {
                        --button-bg-dark: black;
                        --button-bg-light: white;
                        --neon-color: #82A972;

                        position: relative;
                        background-color: var(--button-bg-dark);
                        color: var(--neon-color);
                        border: none;
                        padding: 10px 20px;
                        font-size: 16px;
                        cursor: pointer;
                        overflow: hidden;
                        transition: background-color 0.2s, color 0.2s;
                    }

                    .btn-neon:before,
                    .btn-neon:after {
                        content: "";
                        position: absolute;
                        width: 100%;
                        height: 2px;
                        background: var(--neon-color);
                        top: 0;
                        left: 0;
                        transform: scaleX(0);
                        transform-origin: left;
                        transition: transform 0.2s ease-in-out;
                    }

                    .btn-neon:after {
                        top: auto;
                        bottom: 0;
                        transform-origin: right;
                    }

                    .btn-neon:hover:before,
                    .btn-neon:hover:after {
                        transform: scaleX(1);
                    }

                    /* Adjust the styles for light theme */
                    .light-theme .btn-neon {
                        background-color: var(--button-bg-light);
                        color: var(--neon-color);
                    }
                </style>

            </div>
        </div>
        </div>
    @else
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="card p-3 shadow-lg text-center">
                        <h2>Login</h2>
                        <form action="/login" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input name="loginname" type="text" class="form-control" placeholder="Name">
                            </div>
                            <div class="mb-3">
                                <input name="loginpassword" type="password" class="form-control" placeholder="Password">
                            </div>
                            <button class="btn  btn-neon">Login</button>
                        </form>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card p-3 shadow-lg text-center">
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
                            <button class="btn  btn-neon ">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <style>
            /* Add these styles to give the buttons a neon effect */
            .btn-neon {
                --button-bg-dark: black;
                --button-bg-light: white;
                --neon-color: #82A972;

                position: relative;
                background-color: var(--button-bg-dark);
                color: var(--neon-color);
                border: none;
                padding: 10px 20px;
                font-size: 16px;
                cursor: pointer;
                overflow: hidden;
                transition: background-color 0.2s, color 0.2s;
            }

            .btn-neon:before,
            .btn-neon:after {
                content: "";
                position: absolute;
                width: 100%;
                height: 2px;
                background: var(--neon-color);
                top: 0;
                left: 0;
                transform: scaleX(0);
                transform-origin: left;
                transition: transform 0.2s ease-in-out;
            }

            .btn-neon:after {
                top: auto;
                bottom: 0;
                transform-origin: right;
            }

            .btn-neon:hover:before,
            .btn-neon:hover:after {
                transform: scaleX(1);
            }

            /* Adjust the styles for light theme */
            .light-theme .btn-neon {
                background-color: var(--button-bg-light);
                color: var(--neon-color);
            }
        </style>


        <section class="animation">
            <div class="slider-area text-center ">
                <h2 class="my-5 ">Sponsered By</h2>
                <div class="wrapper slider-container">
                    <ul class="slider">
                        <li class="slider__slide">
                            <div class="slide__content">
                                <img alt="" src="img/meta.jpg">
                            </div>
                        </li>
                        <li class="slider__slide">
                            <div class="slide__content">
                                <img alt="" src="img/f1.jpg">
                            </div>
                        </li>
                        <li class="slider__slide">
                            <div class="slide__content">
                                <img alt="" src="img/netflix.jpg">
                            </div>
                        </li>
                        <li class="slider__slide">
                            <div class="slide__content">
                                <img alt="" src="img/oracle.png">
                            </div>
                        </li>
                        <li class="slider__slide">
                            <div class="slide__content">
                                <img alt="" src="img/Tesla.jpg">
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>


        <style>
            /* Slider CSS logic */
            .slider {
                --slider-inner-width: 2000px;
                --slider-speed: 6s;
                /* Adjust the speed as needed for a smoother effect */
            }

            @keyframes scroll {
                0% {
                    transform: translateX(0);
                }

                100% {
                    transform: translateX(calc(0% - var(--slider-inner-width)));
                }
            }

            .slider {
                -webkit-transform: translate3d(0, 0, 0);
                animation: scroll linear infinite var(--slider-speed);
                width: var(--slider-inner-width);
                /* Adjusted width */
                transition: animation-play-state ease 0.3s;

                &:hover {
                    animation-play-state: paused;
                }
            }

            /* Main styles CSS */
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

            .flex-container {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 4rem 0;
            }

            .slider-container {
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
                height: 150px;
                /* Increase the height as needed */
                overflow: hidden;
                position: relative;
                width: 100%;

                .slider {
                    display: flex;
                    align-items: center;
                    list-style: none;
                    margin: 0;
                }

                .slider__slide {
                    height: 150px;
                    /* Increase the height as needed */
                    flex-grow: 1;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background: black;
                    border-right: solid #82a972 10px;
                    background: rgba(0, 0, 0, 1);

                    &:hover {
                        background: rgba(0, 0, 0, 0.8);
                        cursor: pointer;
                    }

                    .slide__content {
                        color: white;
                        font-size: 80px;
                    }
                }
            }
        </style>

    @endauth
    <style>
        /* Your existing styles */

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: var(--footer-bg-color);
            color: var(--font-color);
            padding: 10px;
            text-align: center;
            transition: background-color 0.4s, color 0.4s;
        }

        [data-theme="dark"] .footer {
            --footer-bg-color: #121212;
        }

        [data-theme="light"] .footer {
            --footer-bg-color: #f8f9fa;
        }
    </style>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Opinion Vista. All rights reserved.</p>
    </div>

   
</body>

</html>
