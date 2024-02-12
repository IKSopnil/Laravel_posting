<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Post</title>

    <!-- Bootstrap CSS (for a more refined design) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- Include your dark mode styles -->
    <style>
        body {
            background-color: var(--bg-color);
            color: var(--font-color);
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        form {
            width: 70%;
            max-width: 500px;
            background-color: var(--form-bg-color);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input,
        textarea,
        button {
            margin-bottom: 15px;
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            background-color: var(--primary-color);
            color: #fff;
            cursor: pointer;
        }

        [data-theme="dark"] {
            --font-color: #fefefe;
            --bg-color: #121212;
            --primary-color: #61dafb;
            --form-bg-color: #272c33;
        }
    </style>
</head>

<body>
    <h1>Edit Post</h1>
    <form action="/edit-post/{{$post->id}}" method="post">
        @csrf
        @method('PUT')
        <input type="text" name="title" value="{{$post->title}}" placeholder="Post Title" required />
        <textarea name="body" cols="30" rows="10" placeholder="Body content ..." required>{{$post->body}}</textarea>
        <button>Save changes</button>
    </form>

    <!-- Include your dark mode script -->
    <script>
        const currentTheme = localStorage.getItem('theme');
        if (currentTheme) {
            document.documentElement.setAttribute('data-theme', currentTheme);
        }
    </script>
</body>

</html>
