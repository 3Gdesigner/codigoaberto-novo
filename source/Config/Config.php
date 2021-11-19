<?php

// DATABASE CONNECT
if (strpos($_SERVER["HTTP_HOST"], "localhost")) {
    define("DATA_LAYER_CONFIG", [
        "driver" => "mysql",
        "host" => "localhost",
        "port" => "3306",
        "dbname" => "codigoaberto-novo",
        "username" => "root",
        "passwd" => "",
        "options" => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]
    ]);
} else {
    define("DATA_LAYER_CONFIG", [
        "driver" => "mysql",
        "host" => "localhost",
        "port" => "3306",
        "dbname" => "banco_online",
        "username" => "username_online",
        "passwd" => "passowrd_online",
        "options" => [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_CASE => PDO::CASE_NATURAL
        ]
    ]);
}

// COOKIE POLICY
define("COOKIE_CONSENT", filter_input(INPUT_COOKIE, "cookieConsent", FILTER_SANITIZE_STRIPPED));

define("APP_COOKIE", 1); //COOKIE
define("APP_TREATMENT", 1); //Atendimento

// VIEW
define("CONF_VIEW", [
    "PATH" => __DIR__ . "/../../shared",
    "EXT" => "php",
    "THEME" => "anipat",
    "ADMIN" => "admin",
]);

// PROJECT URLs
define("CONF_URl", [
    "TEST" => "https://www.localhost/cursos/codigoaberto-novo",
    "BASE" => "https://www.seudominio.com.br"
]);

// PASSWORD
define("CONF_PASSWD", [
    "MIN" => 6,
    "MAX" => 40,
    "ALGO" => PASSWORD_DEFAULT,
    "OPTION" => ["cost" => 8],
]);

// MULTIPLO LOGIN
define("CONF_LOGIN", [
    "MULTIPLE" => 1,
    "BLOCK" => 60
]);

// SITE
define("CONF_SITE", [
    "NAME" => "Código aberto - Auth em MVC com php",
    "TITLE" => "Código aberto - Auth em MVC com php",
    "DESC" => "Aprenda a construir uma plicação de autenticação em MVC com php do Jeito Certo",
    "LANG" => "pt_BR",
    "DOMAIN" => "www.dortistudio.com.br",
    "ADDR_STREET" => "Votuporanga",
    "ADDR_NUMBER" => "2562",
    "ADDR_DISTRICT" => "Eldorado",
    "ADDR_COMPLEMENT" => "Casa",
    "ADDR_CITY" => "São José do Rio Preto",
    "ADDR_STATE" => "SP",
    "ADDR_ZIPCODE" => "15.043-040",
    "ADDR_TELEPHONE" => "(17) 99624-7870",
    "ADDR_WHATSAPP" => "5517996247870"
]);

// SOCIAL
define("CONF_SOCIAL", [
    "TWITTER_CREATOR" => "@creator",
    "TWITTER_PUBLISHER" => "@creator",
    "TWITTER_PAGE" => "https://twitter.com/home",
    "FACEBOOK_APP" => "https://www.facebook.com/reinaldorti",
    "FACEBOOK_PAGE" => "https://www.facebook.com/reinaldorti",
    "FACEBOOK_AUTHOR" => "https://www.facebook.com/reinaldorti",
    "LINKDIN_PAGE" => "https://www.linkedin.com/in/reinaldo-dorti-1a17a0198",
    "GOOGLE_PAGE" => "https://www.facebook.com/reinaldorti",
    "GOOGLE_AUTHOR" => "https://www.facebook.com/reinaldorti",
    "INSTAGRAM_PAGE" => "https://www.instagram.com/reinaldodorti",
    "YOUTUBE_PAGE" => "https://www.youtube.com/channel/UCfB0XRFZgoCFSi0wNYebUFA"
]);

// UPLOAD
define("CONF_UPLOAD", [
    "STORAGE" => "storage",
    "IMAGES" => "images",
    "CACHE" => "cache",
    "FILES" => "files",
    "MEDIAS" => "medias",
]);

// EMAIL CONNECT
define("CONF_MAIL", [
    "HOST" => "smtp.sendgrid.net",
    "PORT" => "587",
    "USER" => "apikey",
    "PASSWD" => "",
    "MODE" => "tls",
    "FROM_NAME" => "Reinaldo",
    "FROM_LASTNAME" => "Dorti",
    "FROM_EMAIL" => "reinaldorti@gmail.com",
    "FROM_DOCUMENT" => "653.041.910-13",
    "FROM_TELEPHONE" => "+55 (99) 9999-9999",
    "FROM_WHATSAPP" => "5599999999999"
]);

// SOCIAL LOGIN: FACEBOOK
define("FACEBOOK_LOGIN", [
    "clientId" => "",
    "clientSecret" => "",
    "redirectUri" => CONF_URl["TEST"] . "/facebook",
    "graphApiVersion" => "v4.0"
]);

// SOCIAL LOGIN: GOOGLE
define("GOOGLE_LOGIN", [
    "clientId" => "",
    "clientSecret" => "",
    "redirectUri" => CONF_URl["TEST"] . "/google"
]);

// GOOGLE RECAPTCHA
define("CONF_GOOGLE_RECAPTCHA", [
    "SITE" => "",
    "SERET" => ""
]);