<?php
require_once __DIR__ . "/lib/shablon_class.php";

class FrontPage extends Modules
{
    protected function getTitle(): string
    {
        return "Лабораторна №17 — Шаблонізатор на PHP";
    }

    protected function getDescription(): string
    {
        return "Реалізація власного шаблонізатора засобами PHP";
    }

    protected function getKeyWords(): string
    {
        return "php, шаблонізатор, tpl, str_replace";
    }

    protected function getTop(): string
    {
        $sr = [
            "title" => $this->message->getTitle("WELCOME"),
            "intro_text" => $this->message->getText("WELCOME"),
            "date" => date("d.m.Y"),
        ];
        return $this->getReplaceTemplate($sr, "article_intro");
    }

    protected function getMiddle(): string
    {
        $articles = $this->article->getAllSortDate();
        $text = "";
        foreach ($articles as $art) {
            $sr = [
                "title" => $art["title"],
                "intro_text" => $art["intro_text"],
                "date" => $art["date"],
            ];
            $text .= $this->getReplaceTemplate($sr, "article_intro");
        }
        return $text;
    }
}

$db = new DataBase();
$page = new FrontPage($db);
echo $page->getContent();