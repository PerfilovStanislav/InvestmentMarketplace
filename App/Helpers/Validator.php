<?php

namespace App\Helpers;

use App\Core\AbstractEntity;
use App\Interfaces\ModelInterface;
use App\Traits\Collection;

class Validator
{
    public CONST
        MIN            = 1,
        MAX            = 2,
        LENGTH         = 3,
        IN             = 4,
        REGEX          = 5,
        MODEL          = 6;

    public CONST
        EN             = 'a-z',
        NUM            = '0-9',
        LOGIN          = self::EN . self::NUM,
        FLOAT          = self::NUM . '.',
        NUMS           = self::NUM .'\,',
        SITE_URI       = self::EN . self::NUMS . ':\/_\.\-?=',
        PROJECT_NAME   = self::EN . self::NUM . ' \.\-',
        EMAIL          = self::EN . self::NUM . '\-_.@',
        HASH           = self::EN . self::NUM . '\/\.',
        REF_SITE_URL   = self::SITE_URI . '?№=',
        IP             = self::NUM . '\.:',
        DATE           = self::NUM . '\-',
        EN_FULL_NAME   = self::EN . ' ';

    public static function validate($key, $value, int $type, array $rules = []) {
        if ($type === AbstractEntity::TYPE_INT || $type === AbstractEntity::TYPE_FLOAT) {
            if (!\is_numeric($value)) {
                Error()->add($key, Translate()->expectedNumber);
            }
        }
        elseif ($type === AbstractEntity::TYPE_BOOL) {
            if (\in_array($value, ['1', 1, 'true', true], true)) return true;
            if (\in_array($value, ['0', 0, 'false', false], true)) return false;
            Error()->add($key, Translate()->wrongValue);
        }

        switch ($type) {
            case AbstractEntity::TYPE_INT:       $value = intval($value);           break;
            case AbstractEntity::TYPE_FLOAT:     $value = floatval($value);         break;
            case AbstractEntity::TYPE_STRING:
            case AbstractEntity::TYPE_CURL_FILE:
                                                 $value = (string)$value;           break;
            case AbstractEntity::TYPE_DATETIME:  $value = mb_substr($value, 0, 19); break;
            case AbstractEntity::TYPE_DATE:      $value = mb_substr($value, 0, 10); break;
        }

        if ($type === AbstractEntity::TYPE_DATETIME || $type === AbstractEntity::TYPE_DATE) {
            $format = $type === AbstractEntity::TYPE_DATE
                ? AbstractEntity::FORMAT_DATE
                : AbstractEntity::FORMAT_DATETIME;
            return self::date($key, $value, $format);
        }

        foreach ($rules as $operator => $rule) {
            switch ($operator) {
                case self::MIN:
                    switch ($type) {
                        case AbstractEntity::TYPE_INT:
                        case AbstractEntity::TYPE_FLOAT:
                            self::minNumber($key, $value, $rule); break;
                        case AbstractEntity::TYPE_STRING:
                        case AbstractEntity::TYPE_CURL_FILE:
                            self::minString($key, $value, $rule); break;
                    }; break;
                case self::MAX:
                    switch ($type) {
                        case AbstractEntity::TYPE_INT:
                        case AbstractEntity::TYPE_FLOAT:
                            self::maxNumber($key, $value, $rule); break;
                        case AbstractEntity::TYPE_STRING:
                        case AbstractEntity::TYPE_CURL_FILE:
                            self::maxString($key, $value, $rule); break;
                    }; break;
                case self::LENGTH:
                    self::lengthString($key, $value, $rule); break;
                case self::REGEX:
                    self::regex($key, $value, $rule); break;
                case self::IN:
                    if (\is_string($rule)) {
                        /** @var Collection $rule */
                        $rule = $rule::getValues();
                    }
                    self::in($key, $value, $rule); break;
                case self::MODEL:
                    /** @var ModelInterface $rule */
                    if ($rule::setTable()->selectById($value, 'id') === null) {
                        Error()->add($key, Translate()->wrongValue . ': ' . $value);
                    }
                    break;
            }
        }

        if ($type === AbstractEntity::TYPE_CURL_FILE) {
            if (!\file_exists($value)) {
                Error()->add($key, sprintf(Translate()->fileNotFound, $value));
            }
            return new \CURLFile($value);
        }

        return $value;
    }

    private static function maxNumber($key, $value, $max) {
        if ($value > $max) Error()->add($key, Translate()->maxValue . ' ' . $max);
    }

    private static function minNumber($key, $value, $min) {
        if ($value < $min) {
            Error()->add($key, Translate()->minValue . ' ' . $min);
        }
    }

    private static function maxString($key, $value, $max) {
        if (\mb_strlen($value) > $max) Error()->add($key, Translate()->maxLength . ' ' . $max);
    }

    private static function minString($key, $value, $min) {
        if (\mb_strlen($value) < $min) Error()->add($key, Translate()->minLength . ' ' . $min);
    }

    private static function lengthString($key, $value, $length) {
        if (\mb_strlen($value) != $length) {
            Error()->add($key, Translate()->fixedLength . ' ' . $length);
        }
    }

    public static function regex($key, $value, $regex): string {
        if (($return = \preg_replace('/[^' . $regex . ']/i', '', $value)) !== $value) {
            Error()->add($key, Translate()->prohibitedChars);
        }
        return $return;
    }

    public static function in($key, $value, array $availables) : ?bool {
        if (!in_array($value, $availables)) {
            Error()->add($key, Translate()->availableValues . ' ' . \implode(', ', $availables));
            return null;
        }
        return true;
    }

    public static function date($key, $value, string $format) : ?\DateTime {
        $date = \DateTime::createFromFormat($format, $value);
        if (!$date || $date->format($format) !== $value) {
            Error()->add($key, Translate()->invalidDateFormat);
            return null;
        }
        return $date;
    }
}
