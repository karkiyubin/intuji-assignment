<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('URL', $_ENV['URL']);
define('BASE_DIR', dirname(__FILE__));

$google = new GoogleLibrary();
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <script src="https://cdn.tailwindcss.com"></script>

  <title>Intuji Events</title>
</head>

<body>

  <main class="h-screen my-8 gap-8">
    <header class="flex items-center justify-between m-auto w-3/4 pb-10">
      <h2 class="text-xl font-bold text-stone-700 mb-4"><a href="<?php echo URL ?>">Intuji Events</a></h2>
      <?php if (!empty($_SESSION["auth_credentials"])) { ?>
        <a class="px-4 py-2 rounded-md text-red-700 hover:text-red-200" href="<?php echo URL . 'logout' ?>">Logout</a>
      <?php } ?>
    </header>
    <?php include("route.php"); ?>
  </main>

</body>

</html>