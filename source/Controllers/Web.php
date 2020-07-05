<?php


namespace Source\Controllers;

use Source\Models\Post;
use Source\Support\Message;
use Source\Support\Email;
use Source\Support\Pager;
/**
 * Class Web
 * @package Source\Controllers
 */
class Web extends Controller
{
    /**
     * Web constructor.
     * @param $router
     */
    public function __construct($router)
    {
        $this->router = $router;
        parent::__construct(__DIR__ . "/../../themes/" . CONF_VIEW['THEME'] . "/");
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

        echo $this->view->render("home", [
            "head" => $head,
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
        $posts = (new Post())->find("post_at <= NOW()");
        $pager = new Pager(url("/blog/p/"));
        $pager->pager($posts->count(), 10, ($data['page'] ?? 1));
        $head = $this->seo->render(
            "Blog - " . CONF_SITE['NAME'],
            CONF_SITE['DESC'],
            url(),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("posts", [
            "head" => $head,
            "posts" => $posts->order("id DESC")->limit($pager->limit())->offset($pager->offset())->fetch(true),
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
            "post" => $post
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

            $Mail = new Email();
            $Mail->add(
                $data["subject"],
                $this->view->render("emails/contact", [
                    "data" => $data,
                    "link" => url(),
                ]),
                "{$data["name"]}",
                $data["email"]
            )->send();

            echo Message::ajaxResponse("message", [
                "type" => "success",
                "message" => "
                <i class='fa fa-check'></i> Pronto, {$data["name"]}! <br>
                Sua mensagem foi enviada com sucesso!
            "
            ]);
            return;
        }

        $csrf = csrf_input();
        $head = $this->seo->render(
            CONF_SITE['NAME'] . " - " . CONF_SITE['TITLE'],
            CONF_SITE['DESC'],
            url(),
            asset("/assets/images/logo/logo.png")
        );

        echo $this->view->render("contact", [
            "head" => $head,
            "csrf" => $csrf

        ]);
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