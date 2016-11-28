<?php

include __DIR__ . '/bootstrap.php';

$path = '/';
if (isset($_GET['path']))
    $path = $_GET['path'];

$zookeeper = new \timandes\ZookeeperClient();
$zookeeper->connect($GLOBALS['globalZookeeperHosts']);

if (isset($_SESSION['ZA_CERTS'])
        && is_array($_SESSION['ZA_CERTS'])) {
    foreach ($_SESSION['ZA_CERTS'] as $cert) {
        $zookeeper->addAuth('digest', $cert);
    }
}

$getChildrenException = null;
try {
    $children = $zookeeper->getChildren($path);
} catch (\ZookeeperClientCoreException $zcce) {
    if ($zcce->getCode() == \ZookeeperClient::ERR_NOAUTH) {
        header("Location: add_auth.php");
        exit(1);
    }

    $children = array();
    $getChildrenException = $zcce;
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

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">
<?php
if (is_array($children)
        && $children) foreach ($children as $child) {
    echo '<li><a href="?path=' . urlencode(rtrim($path, '/') . '/' . $child) . '">' . $child . '</a></li>';
} else {
    $message = 'No child';
    if ($getChildrenException)
        $message .= '(' . $getChildrenException->getMessage() . ')';
    echo '<li>' . $message . '</li>';
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
echo ((null === $value)?'(nil)':htmlentities($value));
$jsonDecodedValue = false;
$xmlDecodedValue = false;
if (is_string($value)) {
    $jsonDecodedValue = @json_decode($value, true);

    $xmlElement = @simplexml_load_string($value);
    if ($xmlElement) {
        $tmp = json_encode($xmlElement);
        $xmlDecodedValue = json_decode($tmp, true);
    }
}
?>
                        </pre>
<?php
if ($jsonDecodedValue) {
?>
                        <pre>JSON Decoded: <?php var_export($jsonDecodedValue);?></pre>
<?php
}
if ($xmlDecodedValue) {
?>
                        <pre>XML Decoded: <?php var_export($xmlDecodedValue);?></pre>
<?php
}
?>

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
