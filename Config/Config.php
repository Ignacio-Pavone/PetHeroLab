<?php 
namespace Config;
define("ROOT", dirname(__DIR__) . "/");
//Luis path: /Facu/PetHeroLab/
//naza path: /PetHeroLab/
define("FRONT_ROOT", "/Facu/PetHeroLab/");
//define("FRONT_ROOT", "/PetHeroLab/");
//define("FRONT_ROOT", "/TP_FINAL/");
define("VIEWS_PATH", "Views/");
define("CSS_PATH", FRONT_ROOT . VIEWS_PATH . "layout/styles/");
define("JS_PATH", FRONT_ROOT . VIEWS_PATH . "layout/scripts/");
define("IMG_PATH", VIEWS_PATH . "img/");

//DB CONNECT
define("DB_HOST", "localhost");
define("DB_NAME", "pethero");
define("DB_USER", "root");
//define("DB_PASS", "root");
define("DB_PASS", "");
//define("DB_PASS","1234");
?>




