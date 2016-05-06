<?php

require __DIR__ . '/bootstrap.php';

if (isset($_POST['user'])
        && isset($_POST['password'])) {
    $_SESSION['ZA_CERTS'][] = $_POST['user'] . ':' . $_POST['password'];
    header("Location: index.php");
    exit(0);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Zookeeper Admin</title>

        <link href="libs/bootstrap-3.3.5/css/bootstrap.min.css" rel="stylesheet" />
        <link href="res/css/dashboard.css" rel="stylesheet" />
    </head>
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">Zookeeper Admin</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/">Dashboard</a></li>
                        <li><a href="https://github.com/Timandes/zookeeper-admin/">Help</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <form action="add_auth.php" method="POST">
                        <div class="form-group">
                            <label for="inputUser">User</label>
                            <input class="form-control" type="text" name="user" id="inputUser" />
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">Password</label>
                            <input class="form-control" type="password" name="password" id="inputPassword" />
                        </div>
                        <button class="btn btn-primary" type="submit">Add Auth</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
