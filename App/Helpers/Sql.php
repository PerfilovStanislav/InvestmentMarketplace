<?php

namespace App\Helpers;

class Sql implements \Stringable
{
    protected string $sql;
    protected array $params;

    public function __construct(string $sql, array $params)
    {
        $this->sql = $sql;
        $this->params = $params;
    }

    public function __toString(): string
    {
        $params = $this->params;
        return \preg_replace_callback('|\$(\w*)|', function ($m) use ($params) {
            if (\array_key_exists($m[1], $params) === false) {
                return $m[0];
            }
            $v = $params[$m[1]];
            if ($v === null) {
                return 'NULL';
            }
            if (\is_int($v) || \is_float($v)) {
                return $v;
            }
            if (\is_string($v)) {
                $v = \pg_escape_string($v);
                return "'$v'";
            }
            if (\is_array($v)) {
                $v = \json_encode($v, JSON_UNESCAPED_UNICODE);
                return "'$v'";
            }
            if ($v instanceof \Stringable) {
                return (string)$v;
            }
            throw new \RuntimeException('undefined type ' . (gettype($v)) . "for {$m[1]}");
        }, $this->sql);
    }
}