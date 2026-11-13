<?php
require_once __DIR__ . "/global_class.php";

class Banner extends GlobalClass
{
    public function __construct(DataBase $db)
    {
        parent::__construct("banners", $db);
    }
}