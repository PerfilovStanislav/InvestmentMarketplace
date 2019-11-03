<?php

namespace Core;

use Helpers\Validator;
use Interfaces\ConstantInterface;
use Interfaces\EntityInterface;
use Traits\Collection;

abstract class AbstractEntity implements EntityInterface {
    CONST COLLECTION = 'collection';

    CONST
        TYPE_BOOL         = 1,
        TYPE_INT          = 2,
        TYPE_FLOAT        = 3,
        TYPE_STRING       = 4,
        TYPE_DTO          = 5,
        TYPE_DTO_ARRAY    = 6,
        TYPE_CONSTANTS    = 7,
        TYPE_DATE         = 8,
        TYPE_DATETIME     = 9,
        TYPE_NULLABLE     = 10,
        TYPE_INT_ARRAY    = 11,
        TYPE_FLOAT_ARRAY  = 12,
        TYPE_STRING_ARRAY = 13,
        TYPE_CURL_FILE    = 14;

    CONST
        FORMAT_DATE     = 'Y-m-d',
        FORMAT_DATETIME = 'Y-m-d H:i:s';

    protected $data;

    protected static
        $defaults = null,
        $arrayable = null,
        $properties;

    public function __construct(array $data = []) {
        $this->fromArray($data);
    }

    /**
     * @param array $data
     * @return static
     * @throws \Exception
     */
    public function fromArray(array $data) : self {
        foreach ($data as $key => $value) {
            if ($params = (static::$properties[$key] ?? null)) {
                if (($params[2] ?? null) == self::TYPE_NULLABLE && is_null($value)) {
                    $this->data[$key] = null;
                    continue;
                }
                $type = $params[0];
                switch ($type) {
                    case self::TYPE_BOOL:
                    case self::TYPE_DATE:
                    case self::TYPE_DATETIME:
                    case self::TYPE_STRING:
                    case self::TYPE_INT:
                    case self::TYPE_FLOAT:
                    case self::TYPE_CURL_FILE:
                        $this->data[$key] = Validator::validate($key, $value, $type, $params[1] ?? []);
                        break;
                    case self::TYPE_DTO:
                        /** @var EntityInterface $class */
                        $class = $params[1];
                        if (is_array($value)) $this->data[$key] = new $class($value);
                        else $this->data[$key] = $value;
                        break;
                    case self::TYPE_DTO_ARRAY:
                        /** @var EntityInterface $class */
                        $class = $params[1];
                        foreach ($value as $dto) {
                            $entity = new $class($dto);
                            if ($params[2] ?? null) $this->data[$key][$entity->{$params[2]}] = $entity;
                            else $this->data[$key][] = $entity;
                        }
                        break;
                    case self::TYPE_CONSTANTS:
                        /** @var Collection $class */
                        $class = $params[1];
                        if (Validator::in($key, mb_strtoupper($value), $class::getConstNames())) {
                            $this->data[$key] = $class::getValue($value);
                        }
                        break;
                    case self::TYPE_FLOAT_ARRAY:
                    case self::TYPE_INT_ARRAY:
                    case self::TYPE_STRING_ARRAY:
                        $array = is_array($value)
                            ? $value
                            : explode(',', str_replace(['{', '}'], '', $value));

                        $validatorType = [
                            self::TYPE_INT_ARRAY    => self::TYPE_INT,
                            self::TYPE_FLOAT_ARRAY  => self::TYPE_FLOAT,
                            self::TYPE_STRING_ARRAY => self::TYPE_STRING,
                        ][$type];
                        foreach ($array as $index => $item) {
                            $this->data[$key][$index] = Validator::validate("{$key}.{$index}", $item, $validatorType, $params[1] ?? []);
                        }
                        break;
                    default:
                        throw new \Exception('Unknown entity type');
                }
            }
        }
        return $this;
    }

    public function __get($name) {
        return $this->data[$name] ?? null;
    }

    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    public function get() : array {
        return $this->data ?? [];
    }

    public function __unset($name) {
        unset($this->data[$name]);
    }

    public function excludeDefault() {
        foreach ($this->get() as $key => $value) {
            if (static::$defaults->$key == $value) unset($this->$key);
        }
        return $this;
    }

    public static function getDefaults() {
        return static::$defaults;
    }

    public function getActual($key) {
        return $this->$key ?: static::getDefaults()->$key;
    }

    public static function getPropertyKeys(): array {
        return array_keys(static::$properties);
    }

    public static function getPropertyByKey(string $key): array {
        return [$key => static::$properties[$key]];
    }

    public function fillCollection(array $data) {
        $this->data = $this->fromArray([self::COLLECTION => $data])->{self::COLLECTION};
    }

    public function getValuesByKey(string $key = null) : array {
        if (!$key) {
            return array_keys($this->get());
        }
        $keys = [];
        foreach ($this->get() as $entity) {
            $keys[] = $entity->$key;
        }
        return $keys;
    }

    public function getByKeyAndValue(string $key, $value) : ?AbstractEntity {
        foreach ($this->get() as $entity) {
            if ($entity->$key == $value) {
                return $entity;
            }
        }
        return null;
    }

    public function getUniqueValuesByKey(string $key) : array {
        $values = $this->getValuesByKey($key);
        if (static::$properties[self::COLLECTION][1]::$properties[$key][0] == self::TYPE_INT_ARRAY) {
            $values = call_user_func_array('array_merge', $values);
        }
        return array_values(array_unique(array_filter($values)));
    }

    public function toArray() {
        $data = [];
        foreach ($this->get() as $key => $entity) {
            if (static::$arrayable && !in_array($key, static::$arrayable)) continue;

            $type = $this->getType($key);
            if ($type === self::TYPE_DTO || $type === self::TYPE_DTO_ARRAY) {
                /** @var AbstractEntity $entity */
                $data[$key] = $entity->toArray();
            }
            elseif ($entity instanceof \DateTime) {
                $data[$key] = $entity->format(self::getDateFormatByType($type));
            }
            elseif ($type === self::TYPE_CONSTANTS) {
                /** @var ConstantInterface $class */
                $class = static::$properties[$key][1];
                $data[$key] = $class::getConstName($entity);
            }
            else $data[$key] = $entity;
        }
        return $data;
    }

    public function toDatabase() {
        $data = [];
        foreach ($this->get() as $key => $item) {
            $type = $this->getType($key);
            switch ($type) {
                case self::TYPE_INT_ARRAY:
                case self::TYPE_FLOAT_ARRAY:
                case self::TYPE_STRING_ARRAY:
                    $data[$key] = '{' . implode(',', $item) . '}';
                    break;
                case self::TYPE_DATE:
                case self::TYPE_DATETIME:
                    $data[$key] = $item->format(self::getDateFormatByType($type));
                    break;
                default:
                    $data[$key] = $item;
            }
        }
        return $data;
    }

    public static function getType(string $key) : int {
        if (isset(static::$properties[self::COLLECTION])) return self::TYPE_DTO_ARRAY;
        return static::$properties[$key][0];
    }

    public static function getDateFormatByType(int $type) : string {
        return $type === self::TYPE_DATE
            ? self::FORMAT_DATE
            : self::FORMAT_DATETIME;
    }
}
