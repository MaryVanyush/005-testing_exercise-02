<?php

class UserTableWrapper
{
    private array $rows = [];

    public function insert(array $values): void
    {
        $this->rows[] = $values;
    }

    public function update(int $id, array $values): array
    {
        if (!isset($this->rows[$id])) {
            throw new Exception("Row not found.");
        }
        
        $this->rows[$id] = array_merge($this->rows[$id], $values);
        return $this->rows[$id];
    }

    public function delete(int $id): void
    {
        if (!isset($this->rows[$id])) {
            throw new Exception("Row not found.");
        }
        
        unset($this->rows[$id]);
        $this->rows = array_values($this->rows);
    }
    
    public function get(): array
    {
        return $this->rows;
    }
}