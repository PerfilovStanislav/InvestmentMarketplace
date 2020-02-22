<?php

namespace Core;

use DateTime;
use Helpers\Validator;
use Interfaces\ConstantInterface;
use Interfaces\EntityInterface;
use InvalidArgumentException;
use LogicException;
use Traits\Collection;

abstract class AbstractEntity {
    public CONST COLLECTION = 'collection';

    public CONST
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

    public CONST
        FORMAT_DATE     = 'Y-m-d',
        FORMAT_DATETIME = 'Y-m-d H:i:s';

    protected array $data = [];

    protected static array
        $arrayable = [],
        $properties = [];

    public function __construct(array $data = []) {
        $this->fromArray($data + static::getDefaults());
    }

    /**
     * @param array $data
     * @return static
     * @throws LogicException
     */
    public function fromArray(array $data) : self {
        foreach ($data as $key => $value) {
            if (!$params = (static::$properties[$key] ?? null)) {
                continue;
            }
            if (($params[2] ?? null) === self::TYPE_NULLABLE && $value === null) {
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
                    if (is_array($value)) {
                        $this->data[$key] = new $class($value);
                    }
                    else {
                        $this->data[$key] = $value;
                    }
                    break;
                case self::TYPE_DTO_ARRAY:
                    /** @var EntityInterface $class */
                    $class = $params[1];
                    foreach ($value as $dto) {
                        $entity = new $class($dto);
                        if ($params[2] ?? null) {
                            $this->data[$key][$entity->{$params[2]}] = $entity;
                        }
                        else {
                            $this->data[$key][] = $entity;
                        }
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
                    throw new LogicException('Unknown entity type');
            }
        }
        return $this;
    }

    public function __get($key) {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        }
        if (static::getDefaults()) {
            $entityWithDefaults = (new static())->fromArray(static::getDefaults());
            if (isset($entityWithDefaults->data[$key])) {
                return $this->data[$key] ??= $entityWithDefaults->data[$key];
            }
        }
        if (!isset(static::$properties[$key])) {
            throw new InvalidArgumentException(static::class . '->' . $key);
        }
        return null;
    }

    public function __set($name, $value) {
        $this->fromArray([$name => $value]);
    }

    public function __unset($name) {
        unset($this->data[$name]);
    }

    public static function getDefaults(): array {
        return [];
    }

    public static function getPropertyKeys(): array {
        return array_keys(static::$properties);
    }

    public static function getPropertyByKey(string $key): array {
        return [$key => static::$properties[$key]];
    }

    public function fillCollection(array $data): void {
        $this->data = $this->fromArray([self::COLLECTION => $data])->{self::COLLECTION} ?? [];
    }

    public function getValuesByKey(string $key = null): array {
        if (!$key) {
            return array_keys($this->data);
        }
        $keys = [];
        foreach ($this->data as $entity) {
            $keys[] = $entity->$key;
        }
        return $keys;
    }

    public function getByKeyAndValue(string $key, $value) : ?AbstractEntity {
        foreach ($this->data as $entity) {
            if ($entity->$key === $value) {
                return $entity;
            }
        }
        return null;
    }

    public function getUniqueValuesByKey(string $key): array {
        $values = $this->getValuesByKey($key);
        if (static::$properties[self::COLLECTION][1]::$properties[$key][0] === self::TYPE_INT_ARRAY) {
            $values = array_merge(...$values);
        }
        return array_values(array_unique(array_filter($values)));
    }

    public function toArray(): array {
        $data = [];
        foreach ($this->data as $key => $entity) {
            if (static::$arrayable && !in_array($key, static::$arrayable, true)) {
                continue;
            }

            $type = self::getType($key);
            if ($type === self::TYPE_DTO || $type === self::TYPE_DTO_ARRAY) {
                /** @var AbstractEntity $entity */
                $data[$key] = $entity->toArray();
            }
            elseif ($entity instanceof DateTime) {
                $data[$key] = $entity->format(self::getDateFormatByType($type));
            }
            elseif ($type === self::TYPE_CONSTANTS) {
                /** @var ConstantInterface $class */
                $class = static::$properties[$key][1];
                $data[$key] = $class::getConstName($entity);
            }
            else {
                $data[$key] = $entity;
            }
        }
        return $data;
    }

    public function toDatabase(): array {
        $data = [];
        foreach ($this->data as $key => $item) {
            $type = self::getType($key);
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

    public static function getType(string $key): int {
        if (isset(static::$properties[self::COLLECTION])) {
            return self::TYPE_DTO_ARRAY;
        }
        return static::$properties[$key][0];
    }

    public static function getDateFormatByType(int $type): string {
        return $type === self::TYPE_DATE
            ? self::FORMAT_DATE
            : self::FORMAT_DATETIME;
    }
}
