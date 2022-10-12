
<?php
require 'vendor/autoload.php';
require 'vendor/vlucas/phpdotenv/src/Dotenv.php';
require 'vendor/vlucas/phpdotenv/src/Loader.php';
require 'vendor/vlucas/phpdotenv/src/Validator.php';
if (true) {
    
    $dotenv = new Dotenv\Dotenv(__DIR__);
    $dotenv->load();
    
   echo $DB_HOST = getenv('APP_CONTRACT');
}
?>
