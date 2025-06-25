<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Register</title>

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

    <h2>Admin Register</h2>

    <div id="message"></div>

    <form id="registerForm" method="POST" action="{{ route('register') }}">
        @csrf
<div class="main-log">


        <input type="text" name="name" placeholder="Name">
        <span class="text-danger error error-text name_error"></span>
        <input type="email" name="email" placeholder="Email">
        <span class="text-danger error error-text email_error"></span>
        <input type="password" name="password" placeholder="Password">
        <span class="text-danger error error-text password_error"></span>
        <input type="password" class="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
        <span class="text-danger error error-text password_confirmation_error"></span>
        <button type="submit">Register</button>
        </div>
    </form>
    <div class="log-a">
         <a href="{{ route('login') }}">Admin Login</a>

    <a href="{{ route('user.forms') }}">User Forms</a>
    </div>
   


</body>
<script src="{{ asset('page-js/admin/register.js') }}"></script>

</html>