<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        input,
        button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
            font-size: 16px;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }

        .success {
            color: green;
            margin-bottom: 10px;
        }
        .log-a{
        display: flex;
        justify-content: space-between;
        }
        .main-log{
        display: flex;
        flex-direction: column;
        align-items: center;
        }
    </style>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
</head>
<body>
    <h2>Admin Login</h2>
    <div id="message"></div>
    <form id="loginForm" method="POST" action="{{ route('admin.login') }}">
        @csrf
        <div class="main-log">
        <input type="email" class="email" name="email" placeholder="Email" required>
        <span class="text-danger error-text email_error"></span>
        <input type="password" class="password" name="password" placeholder="Password" required>
        <span class="text-danger error-text password_error"></span>
        <span class="text-danger error-text invalid_credentials_error"></span>
        <button type="submit">Login</button>
        </div>

    </form>
<div class="log-a">
    <a href="{{ route('register') }}">Admin Register</a>
    <a href="{{ route('user.forms') }}">User Forms</a>
</div>
    
</body>
<script src="{{ asset('page-js/admin/login.js') }}"></script>
</html>