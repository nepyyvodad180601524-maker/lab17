<?php
require_once __DIR__ . "/config_class.php";
require_once __DIR__ . "/checkvalid_class.php";
require_once __DIR__ . "/database_class.php";

abstract class GlobalClass
{
    private DataBase $db;
    private string $table_name;
    protected Config $config;
    protected CheckValid $valid;

    protected function __construct(string $table_name, DataBase $db)
    {
        $this->db = $db;
        $this->table_name = $table_name;
        $this->config = new Config();
        $this->valid = new CheckValid();
    }

    protected function add(array $new_values): bool
    {
        return $this->db->insert($this->table_name, $new_values);
    }

    protected function edit(int $id, array $upd_fields): bool
    {
        return $this->db->updateOnID($this->table_name, $id, $upd_fields);
    }

    public function delete(int $id): bool
    {
        return $this->db->deleteOnID($this->table_name, $id);
    }

    public function deleteAll(): bool
    {
        return $this->db->deleteAll($this->table_name);
    }

    protected function getField(string $field_out, string $field_in, $value_in)
    {
        return $this->db->getField($this->table_name, $field_out, $field_in, $value_in);
    }

    protected function getFieldOnID(int $id, string $field)
    {
        return $this->db->getFieldOnID($this->table_name, $id, $field);
    }

    protected function setFieldOnID(int $id, string $field, $value): bool
    {
        return $this->db->setFieldOnID($this->table_name, $id, $field, $value);
    }

    public function get(int $id): ?array
    {
        return $this->db->getElementOnID($this->table_name, $id);
    }

    public function getAll(string $order = "", bool $up = true): array
    {
        return $this->db->getAll($this->table_name, $order, $up);
    }

    protected function getAllOnField(string $field, $value, string $order = "", bool $up = true): array
    {
        return $this->db->getAllOnField($this->table_name, $field, $value, $order, $up);
    }

    public function getRandomElement(int $count): array
    {
        return $this->db->getRandomElements($this->table_name, $count);
    }

    public function getLastID(): int
    {
        return $this->db->getLastID($this->table_name);
    }

    public function getCount(): int
    {
        return $this->db->getCount($this->table_name);
    }

    protected function isExists(string $field, $value): bool
    {
        return $this->db->isExists($this->table_name, $field, $value);
    }
}