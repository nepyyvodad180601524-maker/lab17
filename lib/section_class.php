<?php
require_once __DIR__ . "/global_class.php";

class Section extends GlobalClass
{
    public function __construct(DataBase $db)
    {
        parent::__construct("sections", $db);
    }
}