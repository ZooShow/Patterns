<?php

declare(strict_types=1);

abstract class SQLBuilder {
    
    protected stdClass $query;
    
    abstract public function select(string $table, array $fields): self;
    abstract public function where(string $field, string $value, string $operator = '='): self;
    abstract public function limit(int $start, int $offset): self;
    abstract public function getSql(): string;
}

class MySqlBuilder extends SQLBuilder
{
    protected function reset(): void
    {
        $this->query = new stdClass();
    }

    public function select(string $table, array $fields): SQLBuilder
    {
        $this->reset();
        $this->query->base = "SELECT " . implode(", ", $fields) . " FROM " . $table;
        $this->query->type = 'select';

        return $this;
    }

    public function where(string $field, string $value, string $operator = '='): SQLBuilder
    {
        // мне стало лень делать экранирование
        $this->query->where[] = "$field $operator '$value'";

        return $this;
    }

    public function limit(int $start, int $offset): SQLBuilder
    {
        $this->query->limit = " LIMIT " . $start . ", " . $offset;

        return $this;
    }

    public function getSQL(): string
    {
        $query = $this->query;
        $sql = $query->base;
        if (!empty($query->where)) {
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }
        if (isset($query->limit)) {
            $sql .= $query->limit;
        }
        $sql .= ";";
        return $sql;
    }
}

class PostgreSQLBuilder extends MySqlBuilder
{
    public function limit(int $start, int $offset): SQLBuilder
    {
        parent::limit($start, $offset);

        $this->query->limit = " LIMIT " . $start . " OFFSET " . $offset;

        return $this;
    }
}

function getSql(SQLBuilder $sqlBuilder)
{
    echo $sqlBuilder->select('a', ['foo', 'bar'])
        ->where('foo', '1')
        ->limit(0, 10)
        ->getSql();
}

if (getenv('database') === 'sql') {
    $sqlBuilder = new MySqlBuilder();
} else {
    $sqlBuilder = new PostgreSQLBuilder();
}

getSql($sqlBuilder);
