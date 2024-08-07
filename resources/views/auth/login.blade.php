<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>HTML5 Login Form with validation Example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="{{ asset('login/style.css') }}">

</head>

<body>
    <div id="login-form-wrap">
        <h2>Login</h2>
        <form action="{{ route('masuk') }}" method="post" id="login-form">
            @csrf
            <p>
                <input type="email" id="email" name="email" placeholder="Email Address" required><i
                    class="validation"><span></span><span></span></i>
            </p>
            <p>
                <input type="password" id="password" name="password" placeholder="password Address" required><i
                    class="validation"><span></span><span></span></i>
            </p>
            <p>
                <input type="submit" id="login" value="Login">
            </p>
        </form>
    </div><!--login-form-wrap-->
</body>

</html>
