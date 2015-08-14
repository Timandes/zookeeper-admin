<?php

include 'bootstrap.php';

$path = '/';
if (isset($_GET['path']))
    $path = $_GET['path'];

$zookeeper = new \timandes\ZookeeperClient();
$zookeeper->connect($GLOBALS['globalZookeeperHosts']);
$children = $zookeeper->getChildren($path);
?>
<ul>
<?php
if ($path != '/') {
?>
<li><a href="?path=<?php echo dirname($path); ?>">..</a></li>
<?php
}
if (is_array($children)) foreach ($children as $child) {
    echo '<li><a href="?path=' . urlencode(rtrim($path, '/') . '/' . $child) . '">' . $child . '</a></li>';
}
?>
</ul>
<pre>
<?php
$value = $zookeeper->get($path);
var_export($value);
?>
</pre>
