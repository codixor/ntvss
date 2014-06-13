<?php
require_once __DIR__.'/vendor/autoload.php';

$license_key = "http://TVSS.Co";

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "admin";
$dbname = "ntvss";
 
$baseurl = "http://localhost/ntvss";
$basepath = "C:/server/www/ntvss";
$sitename = "NTVSS";

$siteslogan = "";
 
mysql_connect($dbhost,$dbuser,$dbpass); mysql_select_db($dbname);
 
mysql_query("SET NAMES 'utf8'");
mysql_set_charset('utf8'); 


// Setup Capsule.
// See: https://github.com/illuminate/database
use Illuminate\Database\Capsule\Manager as Capsule;
 
$capsule = new Capsule;
$capsule->addConnection(array(
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'ntvss',
    'username'  => 'root',
    'password'  => 'admin',
    'charset'   => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix'    => '',
));
 

// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));


use Illuminate\Cache\CacheManager as CacheManager;
$container = $capsule->getContainer();
$container->offsetGet('config')->offsetSet('memcache', 'array');
$cacheManager = new CacheManager($container);
$capsule->setCacheManager($cacheManager);

// Make this Capsule instance available globally via static methods... (optional).
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

foreach (glob("models/*.php") as $filename)
{
    include $filename;
}