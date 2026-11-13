<?php
require_once __DIR__ . "/config_class.php";
require_once __DIR__ . "/article_class.php";
require_once __DIR__ . "/section_class.php";
require_once __DIR__ . "/user_class.php";
require_once __DIR__ . "/menu_class.php";
require_once __DIR__ . "/banner_class.php";
require_once __DIR__ . "/message_class.php";

abstract class Modules
{
    protected Config $config;
    protected Article $article;
    protected Section $section;
    protected User $user;
    protected Menu $menu;
    protected Banner $banner;
    protected Message $message;
    protected array $data;

    public function __construct(DataBase $db)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->config = new Config();
        $this->article = new Article($db);
        $this->section = new Section($db);
        $this->user = new User($db);
        $this->menu = new Menu($db);
        $this->banner = new Banner($db);
        $this->message = new Message();
        $this->data = $this->secureData($_GET);
    }

    public function getContent(): string
    {
        $sr = [
            "title" => $this->getTitle(),
            "meta_desc" => $this->getDescription(),
            "meta_key" => $this->getKeyWords(),
            "menu" => $this->getMenu(),
            "auth_user" => $this->getAuthUser(),
            "banners" => $this->getBanners(),
            "top" => $this->getTop(),
            "middle" => $this->getMiddle(),
            "bottom" => $this->getBottom(),
        ];
        return $this->getReplaceTemplate($sr, "main");
    }

    abstract protected function getTitle(): string;
    abstract protected function getDescription(): string;
    abstract protected function getKeyWords(): string;
    abstract protected function getMiddle(): string;

    protected function getMenu(): string
    {
        $menu = $this->menu->getAll();
        $text = "";
        for ($i = 0; $i < count($menu); $i++) {
            $sr = [
                "title" => $menu[$i]["title"],
                "link" => $menu[$i]["link"],
            ];
            $text .= $this->getReplaceTemplate($sr, "menu_item");
        }
        return $text;
    }

    protected function getAuthUser(): string
    {
        return $this->getReplaceTemplate([], "form_auth");
    }

    protected function getBanners(): string
    {
        $banners = $this->banner->getAll();
        $text = "";
        for ($i = 0; $i < count($banners); $i++) {
            $sr = [
                "code" => $banners[$i]["code"],
            ];
            $text .= $this->getReplaceTemplate($sr, "banner");
        }
        return $text;
    }

    protected function getTop(): string
    {
        return "";
    }

    protected function getBottom(): string
    {
        return "";
    }

    private function secureData(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->secureData($value);
            } else {
                $data[$key] = htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
            }
        }
        return $data;
    }

    protected function getTemplate(string $name): string
    {
        $path = __DIR__ . "/../" . $this->config->dir_temp . $name . ".tpl";
        $text = is_file($path) ? file_get_contents($path) : "";
        return str_replace("%address%", $this->config->address, $text);
    }

    protected function getReplaceTemplate(array $sr, string $template): string
    {
        return $this->getReplaceContent($sr, $this->getTemplate($template));
    }

    private function getReplaceContent(array $sr, string $content): string
    {
        $search = [];
        $replace = [];
        $i = 0;
        foreach ($sr as $key => $value) {
            $search[$i] = "%$key%";
            $replace[$i] = $value;
            $i++;
        }
        return str_replace($search, $replace, $content);
    }
}