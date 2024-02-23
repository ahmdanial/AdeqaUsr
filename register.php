<?php
require 'inc/conn.php';
?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
              crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="inc/register.css">
        <title>MyPhlebo - Login</title>
    </head>
    <body>
    <div style="width: 40%; padding-top: 10%; margin-left: auto;" class="container-fluid">
        <h1 class="text-center">Register User</h1>
        <table class="table table-borderless">
            <tr>
                <th>
                    <label for="username">Username</label>
                </th>
                <td>
                    <input type="text" id="username" name="username" class="form-control">
                </td>
            </tr>
            <tr>
                <th>
                    <label for="fullaname">Full Name</label>
                </th>
                <td>
                    <input type="text" id="fullaname" name="fullaname" class="form-control">
                </td>
            </tr>
            <tr>
                <th>
                    <label for="email">Email Address</label>
                </th>
                <td>
                    <input type="email" id="email" name="email" class="form-control">
                </td>
            </tr>
            <tr>
                <th>
                    <label for="password">Password</label>
                </th>
                <td>
                    <input type="password" id="password" name="password" class="form-control">
                </td>
            </tr>
            <tr>
                <th>
                    <label for="confirmpassword">Confirm Password</label>
                </th>
                <td>
                    <input type="password" id="confirmpassword" name="confirmpassword" class="form-control">
                </td>
            </tr>
            <tr>
                <th colspan="2">
                    <input type="submit" class="form-control bg-success text-light registerBtn" value="Register">
                </th>
            </tr>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
    </body>
    </html>

<?php
session_unset();