<?php
ob_start();
session_start();

require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;

$router = new Router(url(), ":");
$router->namespace("Source\Controllers");

//WEB ROUTES
$router->group(null);
$router->get("/", "Web:home", "web.home");
$router->get("/sobre", "Web:about", "web.about");
$router->get("/contato", "Web:contact", "web.contact");
$router->post("/contato", "Web:contact", "web.contact");
$router->post("/cookie", "Web:cookiePolicy", "web.cookie.policy");

//BLOG
$router->group("/blog");
$router->get("/", "Web:blog", "web.blog");
$router->post("/buscar", "Web:blogSearch");
$router->get("/buscar/{search}/{page}", "Web:blogSearch");
$router->get("/{uri}", "Web:blogPost");
$router->get("/tag/{tag}", "Web:tag");

//ADMIN ROUTES
$router->namespace("Source\Controllers\Admin");
$router->group("/admin");

//LOGIN
$router->get("/", "Login:login");
$router->post("/login", "Login:login");
$router->get("/recuperar", "Login:forget");
$router->post("/forget", "Login:forget");
$router->get("/senha/{email}/{forget}", "Login:reset");
$router->post("/reset", "Login:reset");

//DASHBOARD
$router->get("/dash", "Dash:home");
$router->post("/dash", "Dash:dashboard");
$router->get("/logoff", "Dash:logoff");

//USERS
$router->get("/users/home", "Users:home");
$router->post("/users/home", "Users:home");
$router->get("/users/home/{search}/{page}", "Users:home");
$router->get("/users/user", "Users:user");
$router->post("/users/user", "Users:user");
$router->get("/users/user/{user_id}", "Users:user");
$router->post("/users/user/{user_id}", "Users:user");
$router->get("/users/delete/{user_id}", "Users:delete");
$router->post("/users/address/{user_id}", "Address:address");

//ABOUT
$router->get("/about/home", "About:home");
$router->post("/about/home", "About:home");
$router->get("/about/home/{search}/{page}", "About:home");
$router->get("/about/about", "About:about");
$router->post("/about/about", "About:about");
$router->get("/about/about/{about_id}", "About:about");
$router->post("/about/about/{about_id}", "About:about");
$router->get("/about/delete/{about_id}", "About:delete");

//SLIDES
$router->get("/slides/home", "Slides:home");
$router->post("/slides/home", "Slides:home");
$router->get("/slides/home/{search}/{page}", "Slides:home");
$router->get("/slides/slide", "Slides:slide");
$router->post("/slides/slide", "Slides:slide");
$router->get("/slides/slide/{slide_id}", "Slides:slide");
$router->post("/slides/slide/{slide_id}", "Slides:slide");
$router->get("/slides/delete/{slide_id}", "Slides:delete");
$router->post("/slides/order", "Slides:SlideOrder");

//BLOG
$router->get("/posts/home", "Posts:home");
$router->post("/posts/home", "Posts:home");
$router->get("/posts/home/{search}/{page}", "Posts:home");
$router->get("/posts/post", "Posts:post");
$router->post("/posts/post", "Posts:post");
$router->get("/posts/post/{post_id}", "Posts:post");
$router->post("/posts/post/{post_id}", "Posts:post");
$router->get("/posts/delete/{post_id}", "Posts:delete");
$router->get("/posts/gallery/{post_id}", "Posts:GalleryDelete");

//TESTIMONY
$router->get("/testimony/home", "Testimonys:home");
$router->post("/testimony/home", "Testimonys:home");
$router->get("/testimony/home/{search}/{page}", "Testimonys:home");
$router->get("/testimony/testimony", "Testimonys:testimony");
$router->post("/testimony/testimony", "Testimonys:testimony");
$router->get("/testimony/testimony/{testimony_id}", "Testimonys:testimony");
$router->post("/testimony/testimony/{testimony_id}", "Testimonys:testimony");
$router->get("/testimony/delete/{testimony_id}", "Testimonys:delete");
$router->post("/testimony/order", "Testimonys:TestimonyOrder");

//END ADMIN
$router->namespace("Source\Controllers");

//ERROR ROUTES
$router->group("/ops");
$router->get("/{errcode}", "Web:error");

//ROUTE
$router->dispatch();

//ERROR REDIRECT
if ($router->error()) {
    $router->redirect("/ops/{$router->error()}");
}

if (!file_exists('.htaccess')) {
    $htaccesswrite = "RewriteEngine On\r\nOptions All -Indexes\r\n\r\n# WWW Redirect.\r\nRewriteCond %{HTTP_HOST} !^www\. [NC]\r\nRewriteRule ^ https://www.%{HTTP_HOST}%{REQUEST_URI} [L,R=301]\r\n\r\n# HTTPS Redirect\r\nRewriteCond %{HTTP:X-Forwarded-Proto} !https\r\nRewriteCond %{HTTPS} off\r\nRewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]\r\n\r\n# URL Rewrite\r\nRewriteCond %{SCRIPT_FILENAME} !-f\r\nRewriteCond %{SCRIPT_FILENAME} !-d\r\nRewriteRule ^(.*)$ index.php?route=/$1";
    $htaccess = fopen('.htaccess', "w");
    fwrite($htaccess, str_replace("'", '"', $htaccesswrite));
    fclose($htaccess);
}

ob_flush();