<?php
const DEFAULT_APP = 'Frontend';

// Si l'application n'est pas valide, on va charger l'application par défaut qui se chargera de générer une erreur 404
if (!isset($_GET['app']) || !file_exists(__DIR__.'/../App/'.$_GET['app'])) $_GET['app'] = DEFAULT_APP;
 
// On commence par inclure la classe nous permettant d'enregistrer nos autoload
require __DIR__.'/../lib/OCFram/SplClassLoader.php';

require __DIR__.'/../lib/vendor/autoload.php';
 
// On va ensuite enregistrer les autoloads correspondant à chaque vendor (OCFram, App, Model, etc.)
$OCFramLoader = new SplClassLoader('OCFram', __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib');
$OCFramLoader->register();
 
$appLoader = new SplClassLoader('App', __DIR__.DIRECTORY_SEPARATOR.'..');
$appLoader->register();
 
$modelLoader = new SplClassLoader('Model', __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'vendors');
$modelLoader->register();
 
$entityLoader = new SplClassLoader('Entity', __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'vendors');
$entityLoader->register();
 
$formBuilderLoader = new SplClassLoader('FormBuilder', __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'vendors');
$formBuilderLoader->register();
 

// Il ne nous suffit plus qu'à déduire le nom de la classe et de l'instancier
$appClass = 'App\\'.$_GET['app'].'\\'.$_GET['app'].'Application'; // ?

$app = new $appClass;
$app->run();