<?php

namespace Helpers {

	class Validator {
		CONST TEXT = '/[^a-zа-я0-9ё \-+=\\!%№#()\[\]_@:;"{}]/iu';
		CONST EN = '/[^a-z0-9]/iu';
		CONST EMAIL = '/[^a-z0-9\-_.@]/i';
		CONST NUM = '/[^0-9\-]/i';
		CONST NUMS = '/[^0-9\,]/i';
		CONST FLOAT = '/[^0-9.]/i';
		CONST HASH = '/[^a-z0-9\/\.]/i';
		CONST URI = '/[^a-z0-9-_\/]/i';
		CONST URL = '/[^a-z0-9\-\/=%#_:?№.]/iu';
		CONST IP = '/[^0-9\.:]/i';
		CONST DATE = '/[^\-0-9]/i';
		CONST TABLENAME = '/[^a-z_]/i';

		private $post;
		private $data = [];
		private $link;
		private $errors = null;
		private $key = null;
		private $isArray = false;
		private $sameArrays = [];

		function __construct(array $post) {
			$this->post = $post;
		}

		public function choose($key, $rename = null):self {
			if (isset($this->post[$key])) {
				$this->data[$rename ?? $key] = $this->post[$key];
				$this->link = &$this->data[$rename ?? $key];
				$this->key = $key;
				$this->isArray = is_array($this->post[$key]);
			} else {
				$this->errors[$key][] = sprintf("Отсутствует поле %s", $key);
				$this->key = null;
			}
			return $this;
		}

		public function addFields($arr):self {
		    foreach ($arr as $key => $val) {
                $this->data[$key] = $val;
            }
			return $this;
		}

		public function checkAll($key, $min = null, $max = null, $regex = null, $rename = null, $removeEmpty = null, $index = null):self {
			$this->choose($key, $rename);
			if ($regex          !== null) $this->clear($regex);
            if ($removeEmpty    !== null) $this->removeEmpty();
			if ($min            !== null) $this->min($min, $regex);
			if ($max            !== null) $this->max($max, $regex);
			if ($index          !== null) $this->count($index);
			return $this;
		}

		public function clear($regex):self {
			if ($this->key !== null) {
				if (!$this->isArray) $this->link = self::replace($regex, $this->link);
				else {
					foreach ($this->link as &$val) {
						$val = self::replace($regex, $val);
					}
				}
			}
			return $this;
		}

		public function min($min, $regex = null):self {
			if ($this->key !== null) {
				if (!$this->isArray) {
				    if (in_array($regex, [self::FLOAT, self::NUM])) {
				        if ((float)$this->link < $min) $this->errors[$this->key][] = sprintf("минимальное значение: %d", $min);
                    }
					else if (mb_strlen($this->link) < $min) $this->errors[$this->key][] = sprintf("минимальное количество знаков: %d", $min);
				}
				else {
					foreach ($this->link as $key => $val) {
                        if (in_array($regex, [self::FLOAT, self::NUM])) {
                            if ((float)$val < $min) $this->errors[$this->key][] = sprintf("минимальное значение: %d", $min);
                        }
						else if (mb_strlen($val) < $min) $this->errors[$this->key][$key] = sprintf("минимальное количество знаков: %d", $min);
					}
				}
			}

			return $this;
		}

		public function max($max, $regex = null):self {
			if ($this->key !== null) {
				if (!$this->isArray) {
                    if (in_array($regex, [self::FLOAT, self::NUM])) {
                        if ((float)$this->link > $max) $this->errors[$this->key][] = sprintf("максимальное значение: %d", $max);
                    }
                    else if (mb_strlen($this->link) > $max) $this->errors[$this->key][] = sprintf("максимальное количество знаков: %d", $max);
				}
				else {
					foreach ($this->link as $key => $val) {
                        if (in_array($regex, [self::FLOAT, self::NUM])) {
                            if ((float)$val > $max) $this->errors[$this->key][] = sprintf("максимальное значение: %d", $max);
                        }
                        else if (mb_strlen($val) > $max) $this->errors[$this->key][$key] = sprintf("максимальное количество знаков: %d", $max);
					}
				}
			}
			return $this;
		}

		private function removeEmpty():self {
		    $this->link = array_diff($this->link, array(''));
			return $this;
		}

		private function count($index):self {
			$this->sameArrays[$index][] = count($this->link);
			return $this;
		}

		public function same():bool {
			foreach ($this->sameArrays as $arr) {
				if (max($arr) !== min($arr)) return false;
			}
			return true;
		}

		public function getErrors() {
			foreach ($this->sameArrays as $key => $arr) {
				if (max($arr) !== min($arr)) $this->addErrors([$key => 'Not same!']);
			}
			return $this->errors?:false;
		}

		public function addErrors(array $errors):self {
			if (!empty($errors)) foreach ($errors as $k => $v) {
				$this->errors[$k][] = $v;
			}
			return $this;
		}

		public function getData():array {
			return $this->data;
		}

		final public function __get($name) {
            return $this->data[$name];
        }

		final public function __set($name, $value) {
            return $this->data[$name] = $value;
        }

        final public static function replace($regex, $str):string {
			switch ($regex) {
				case self::FLOAT: 	$str = str_replace(',', '.', $str); break;
//				case self::NUM: 	$str = (int)$str; break;
			}
			return preg_replace($regex, '', $str);
		}

		final public function exitWithErrors($scope = 'content') {
            return ($errors = $this->getErrors()) ? Output::error($errors, $scope) : $this;
        }

		final public function checkAlerts() {
            return ($errors = $this->getErrors()) ? Output::alert($errors, 'error') : $this;
        }
	}

}
