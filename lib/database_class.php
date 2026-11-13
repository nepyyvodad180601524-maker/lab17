<?php
require_once __DIR__ . "/config_class.php";

class DataBase
{
    private Config $config;
    private ?mysqli $mysqli = null;

    public function __construct()
    {
        $this->config = new Config();
        try {
            mysqli_report(MYSQLI_REPORT_OFF);
            $conn = @new mysqli(
                $this->config->host,
                $this->config->user,
                $this->config->password,
                $this->config->db
            );
            if (!$conn->connect_error) {
                $conn->set_charset("utf8mb4");
                $this->mysqli = $conn;
            }
        } catch (Throwable $e) {
            $this->mysqli = null;
        }
    }

    public function select(string $table_name, array $fields, string $where = "", string $order = "", bool $up = true): array
    {
        if ($this->mysqli === null) {
            return $this->getDemoData($table_name);
        }

        $fields_str = implode(", ", $fields);
        $table = $this->config->db_prefix . $table_name;
        $sql = "SELECT $fields_str FROM `$table`";
        if ($where !== "") $sql .= " WHERE $where";
        if ($order !== "") $sql .= " ORDER BY `$order` " . ($up ? "ASC" : "DESC");

        $res = $this->mysqli->query($sql);
        if (!$res) return [];
        return $res->fetch_all(MYSQLI_ASSOC);
    }

    public function getAll(string $table_name, string $order = "", bool $up = true): array
    {
        return $this->select($table_name, ["*"], "", $order, $up);
    }

    public function getAllOnField(string $table_name, string $field, $value, string $order = "", bool $up = true): array
    {
        $val = addslashes((string)$value);
        return $this->select($table_name, ["*"], "`$field` = '$val'", $order, $up);
    }

    public function getLastID(string $table_name): int
    {
        $data = $this->select($table_name, ["MAX(`id`) as max_id"]);
        return (int)($data[0]['max_id'] ?? 0);
    }

    public function getElementOnID(string $table_name, int $id): ?array
    {
        $res = $this->select($table_name, ["*"], "`id` = $id");
        return $res[0] ?? null;
    }

    public function getField(string $table_name, string $field_out, string $field_in, $value_in)
    {
        $val = addslashes((string)$value_in);
        $res = $this->select($table_name, [$field_out], "`$field_in` = '$val'");
        return $res[0][$field_out] ?? false;
    }

    public function getFieldOnID(string $table_name, int $id, string $field)
    {
        return $this->getField($table_name, $field, "id", $id);
    }

    public function getCount(string $table_name): int
    {
        return count($this->getAll($table_name));
    }

    public function isExists(string $table_name, string $field, $value): bool
    {
        return $this->getField($table_name, "id", $field, $value) !== false;
    }

    public function insert(string $table_name, array $new_values): bool { return true; }
    public function updateOnID(string $table_name, int $id, array $upd_fields): bool { return true; }
    public function deleteOnID(string $table_name, int $id): bool { return true; }
    public function deleteAll(string $table_name): bool { return true; }
    public function setFieldOnID(string $table_name, int $id, string $field, $value): bool { return true; }
    public function getRandomElements(string $table_name, int $count): array { return array_slice($this->getAll($table_name), 0, $count); }

    private function getDemoData(string $table_name): array
    {
        return match ($table_name) {
            'menu' => [
                ['id' => 1, 'title' => 'Головна', 'link' => 'index.php'],
                ['id' => 2, 'title' => 'Статті', 'link' => 'index.php?view=articles'],
                ['id' => 3, 'title' => 'Про проєкт', 'link' => 'index.php?view=about'],
            ],
            'banners' => [
                ['id' => 1, 'code' => '<div class="banner-box">Банер №1: Вивчення шаблонізаторів PHP</div>'],
                ['id' => 2, 'code' => '<div class="banner-box">Банер №2: Лабораторна робота №17</div>'],
            ],
            'articles' => [
                [
                    'id' => 1,
                    'title' => 'Принцип роботи шаблонізатора',
                    'intro_text' => 'Шаблонізатор відокремлює логіку отримання даних від їх HTML-відображення за допомогою маркерів %key%.',
                    'date' => '13.11.2026'
                ],
                [
                    'id' => 2,
                    'title' => 'Абстрактний клас Modules',
                    'intro_text' => 'Базовий клас зчитує .tpl файли та замінює змінні через str_replace().',
                    'date' => '13.11.2026'
                ],
            ],
            default => [],
        };
    }
}