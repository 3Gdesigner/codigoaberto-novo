<?php

namespace Source\Controllers;

use CoffeeCode\Router\Router;
use Source\Models\Post;
use Source\Models\Testimony;
use Source\Support\Message;
use Source\Support\Email;
use Source\Support\Pager;
/**
 * Class Web
 * @package Source\Controllers
 */
class Web extends Controller
{
    protected $router;

    /**
     * Web constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        parent::__construct(__DIR__ . "/../../public/" . CONF_VIEW['THEME'] . "/");

        $this->router = $router;

        $this->view->data([
            "router" => $this->router
        ]);
    }

    /**
     * SITE HOME
     */
    public function home(): void
    {
        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url(),
            asset("/assets/images/logo/logo.png")
        );

        $testimony = (new Testimony())->find()->order("id DESC")->fetch(true);

        echo $this->view->render("home", [
            "head" => $head,
            "testimony" => $testimony
        ]);
    }

    /**
     * SITE SOBRE
     */
    public function about(): void
    {
        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url(),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("about", [
            "head" => $head
        ]);
    }

    /**
     * SITE BLOG
     * @param array|null $data
     */
    public function posts(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $posts = (new Post())->find()->order("id DESC");

        $pager = new Pager(url("/blog/"));
        $pager->pager($posts->count(), 15, (!empty($data["page"]) ? $data["page"] : 1));
        $head = $this->seo->render(
            "Blog - " . CONF_SITE['NAME'],
            CONF_SITE['DESC'],
            url(),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("posts", [
            "head" => $head,
            "posts" => $posts->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "views" => (new Post())->find()->order("views DESC")->fetch(true),
            "tags" => (new Post())->find()->order("views DESC")->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * SITE BLOG TAG
     * @param array|null $data
     */
    public function tag(?array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        $search = null;

        if (!empty($data["tag"]) && str_search($data["tag"]) != "all") {
            $search = str_search($data["tag"]);
            $tag = (new Post())->find("MATCH(tag) AGAINST(:tag)", "s={$search}");
            if (!$tag->count()) {
                flash("info", "Oops! Tag não foi encontrado!");
                redirect("/blog/");
            }
        }

        var_dump($tag);

    }

    /**
     * SITE BLOG SEARCH
     * @param array $data
     */
    public function postSearch(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

        //search redirect
        if (!empty($data["s"])) {
            $s = str_search($data["s"]);

            echo Message::ajaxResponse("redirect", [
                "url" => url("/blog/buscar/{$s}/1")
            ]);
            return;
        }

        $search = null;
        $posts = (new Post())->find()->order("id DESC")->fetch();

        if (!empty($data["search"]) && str_search($data["search"]) != "all") {
            $search = str_search($data["search"]);
            $posts = (new Post())->find("MATCH(title) AGAINST(:s)", "s={$search}");
            if (!$posts->count()) {
                flash("info", "Oops! Sua pesquisa não retornou resultados!");
                redirect("/blog/");
            }
        }

        $all = ($search ?? "all");
        $pager = new Pager(url("/blog/{$all}/"));
        $pager->pager($posts->count(), 15, (!empty($data["page"]) ? $data["page"] : 1));

        $head = $this->seo->render(
            "Blog - " . CONF_SITE['NAME'],
            CONF_SITE['DESC'],
            url(),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("posts", [
            "head" => $head,
            "search" => $search,
            "posts" => $posts->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "views" => (new Post())->find()->order("views DESC")->fetch(true),
            "paginator" => $pager->render()
        ]);
    }

    /**
     * SITE BLOG POST
     * @param array $data
     */
    public function post(array $data): void
    {
        $post = (new Post())->find("uri = :url", "url={$data['uri']}")->fetch();
        if (!$post) {
            redirect("/404");
        }

        $post->views += 1;
        $post->save();

        $head = $this->seo->render(
            "{$post->title} - " . CONF_SITE['NAME'],
            CONF_SITE['DESC'],
            url(),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("post", [
            "head" => $head,
            "post" => $post,
            "views" => (new Post())->find()->order("views DESC")->fetch(true),
        ]);
    }

    /**
     * SITE CONTATO
     * @param null|array $data
     */
    public function contact(?array $data): void
    {
        //send contact
        if (!empty($data["action"]) && $data["action"] == "contact") {
            $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

            $form = [$data["name"], $data["email"], $data["subject"], $data["message"]];
            if (in_array("", $form)) {
                echo Message::ajaxResponse("message", [
                    "type" => "error",
                    "message" => "<i class='fa fa-warning'></i> Oops! Por favor, preencha todos os campos para continuar!"
                ]);
                return;
            }

            //VERIFY CSRF TOKEN
            if (!csrf_verify($data['csrf_token'])) {
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "
                    <i class='fa fa-warning'></i> 
                    Oops! Erro ao enviar o formulário!<br>
                    Por favor, atualize a página e tente novamente!
                "
                ]);
                return;
            }

            //VALIDATE EMAIL
            if (!is_email($data["email"])){
                echo Message::ajaxResponse("message", [
                    "type" => "alert",
                    "message" => "
                    <i class='fa fa-warning'></i>
                    Oops! O e-email informado não é válido!
                "
                ]);
                return;
            }

            var_dump($data);
          
            $mail = new Email();
            $mail->add(
                $data["subject"],
                $this->view->render("templates/contact", [
                    "message" => $data["message"],
                    "link" => url(),
                ]),
                "{$data["name"]}",
                $data["email"]
            )->send();

            echo Message::ajaxResponse("message", [
                "type" => "success",
                "message" => "
                    <i class='fa fa-check'></i> 
                    Pronto, {$data["name"]}! <br>
                    Sua mensagem foi enviada com sucesso!
                ",
                "clear" => [
                    "clear" => true,
                ],
            ]);
            return;
        }

        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url(),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("contact", [
            "head" => $head,
            "csrf" => csrf_input(),
            //"siteKey" => CONF_GOOGLE_RECAPTCHA['SITE'],
        ]);
    }

    public function cookiePolicy(array $data): void
    {
        $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);
        setcookie("cookiePolicy", $data["cookie"], time() + (12 * 43200), "/");

        $json["agree"] = true;
        echo json_encode($json);
        return;
    }

    /**
     * @param $data
     */
    public function error($data): void
    {
        $error = filter_var($data["errcode"], FILTER_VALIDATE_INT);
        $head = $this->seo->render(
            "Oops {$error}" . " | " .  CONF_SITE['NAME'],
            CONF_SITE['DESC'],
            url("/ops/{$error}"),
            asset("/assets/images/logo/logo.png"),
            false
        );

        echo $this->view->render("error", [
            "head" => $head,
            "error" => $error
        ]);
    }
}