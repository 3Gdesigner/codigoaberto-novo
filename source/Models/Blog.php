<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class Blog
 * @package Source\Models
 */
class Blog extends DataLayer
{
    public $author;
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("posts", ["title", "subtitle", "content"]);
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        $uri = (new Blog())->find("uri = :uri AND id != :id", "uri={$this->uri}&id={$this->id}");
        if ($uri->count()) {
            $this->uri = "{$this->uri}-" . time();
        }

        return parent::save();
    }

    /**
     * @return null|User
     */
    public function author(): ?DataLayer
    {
        if ($this->author) {
            return (new User())->find("id = :id", "id={$this->author}")->fetch();
        }
        return null;
    }
}