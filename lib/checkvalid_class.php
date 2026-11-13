<?php
require_once __DIR__ . "/config_class.php";

class CheckValid
{
    private Config $config;

    public function __construct()
    {
        $this->config = new Config();
    }

    public function validID($id): bool
    {
        if (!$this->isIntNumber($id)) return false;
        if ($id <= 0) return false;
        return true;
    }

    public function validLogin($login): bool
    {
        if ($this->isContainQuotes($login)) return false;
        if (preg_match("/^\d*$/", $login)) return false;
        return $this->validString($login, $this->config->min_login, $this->config->max_login);
    }

    public function validHash($hash): bool
    {
        if (!$this->validString($hash, 32, 32)) return false;
        if (!$this->isOnlyLettersAndDigits($hash)) return false;
        return true;
    }

    public function validTimeStamp($time): bool
    {
        return $this->isNoNegativeInteger($time);
    }

    private function isIntNumber($number): bool
    {
        if (!is_int($number) && !is_string($number)) return false;
        if (!preg_match("/^-?(([1-9][0-9]*)|(0))$/", (string)$number)) return false;
        return true;
    }

    private function isNoNegativeInteger($number): bool
    {
        if (!$this->isIntNumber($number)) return false;
        if ($number < 0) return false;
        return true;
    }

    private function isOnlyLettersAndDigits($string): bool
    {
        if (!is_int($string) && !is_string($string)) return false;
        if (!preg_match("/^[a-zA-Z0-9]*$/", (string)$string)) return false;
        return true;
    }

    private function validString($string, int $min_length, int $max_length): bool
    {
        if (!is_string($string)) return false;
        if (strlen($string) < $min_length) return false;
        if (strlen($string) > $max_length) return false;
        return true;
    }

    private function isContainQuotes($string): bool
    {
        $array = ["\"", "'", "`", "&quot;", "&apos;"];
        foreach ($array as $value) {
            if (strpos((string)$string, $value) !== false) return true;
        }
        return false;
    }
}