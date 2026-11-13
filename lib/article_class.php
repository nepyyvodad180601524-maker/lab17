<?php
require_once __DIR__ . "/global_class.php";

class Article extends GlobalClass
{
    public function __construct(DataBase $db)
    {
        parent::__construct("articles", $db);
    }

    public function getAllSortDate(): array
    {
        return $this->getAll("date", false);
    }

    public function getAllOnSectionID(int $section_id): array
    {
        return $this->getAllOnField("section_id", $section_id, "date", false);
    }
}