<?php
require_once __DIR__ . "/config_class.php";

abstract class GlobalMessage
{
    private array $data;

    public function __construct(string $file)
    {
        $config = new Config();
        $path = __DIR__ . "/../" . $config->dir_text . $file . ".ini";
        $this->data = is_file($path) ? parse_ini_file($path) : [];
    }

    public function getTitle(string $name): string
    {
        return $this->data[$name . "_TITLE"] ?? '';
    }

    public function getText(string $name): string
    {
        return $this->data[$name . "_TEXT"] ?? '';
    }
}