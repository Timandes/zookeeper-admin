<?php

include 'bootstrap.php';

$path = '/';
if (isset($_GET['path']))
    $path = $_GET['path'];

$zookeeper = new \timandes\ZookeeperClient();
$zookeeper->connect($GLOBALS['globalZookeeperHosts']);
$children = $zookeeper->getChildren($path);
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

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
<?php
if (is_array($children)) foreach ($children as $child) {
    echo '<li><a href="?path=' . urlencode(rtrim($path, '/') . '/' . $child) . '">' . $child . '</a></li>';
}
?>
                    </ul>
                </div>

                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">Dashboard</h1>
<?php
if ($path != '/') {
?>
                    <a href="?path=/">Root</a> /
                    <a href="?path=<?php echo dirname($path); ?>">Up..</a>
<?php
}
?>
                    <h2 class="sub-header"><?php echo $path;?></h2>
                    <div class="table-responsive">
                        <pre>
<?php
$value = $zookeeper->get($path);
var_export($value);
?>
                        </pre>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
