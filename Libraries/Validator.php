<?php

namespace Libraries {

	class Validator {
		CONST TEXT = '/[^a-zа-я0-9ё \-]/iu';
		CONST EN = '/[^a-z0-9]/iu';
		CONST EMAIL = '/[^a-z0-9\-_.@]/i';
		CONST NUM = '/[^0-9]/i';
		CONST HASH = '/[^a-z0-9\/\.]/i';
		CONST URI = '/[^a-z0-9-_\/]/i';

		private $post;
		private $data = [];
		private $link;
		private $errors = [];
		private $key = null;

		function __construct(array $post) {
			$this->post = $post;
		}

		public function choose($key) {
			if (isset($this->post[$key])) {
				$this->data[$key] = $this->post[$key];
				$this->link = &$this->data[$key];
				$this->key = $key;
			} else {
				$this->errors[$key][] = sprintf("Отсутствует поле %s", $key);
				$this->key = null;
			}
			return $this;
		}

		public function checkAll($key, $min = null, $max = null, $regex = null) {
			$this->choose($key);
			if ($regex !== null) $this->clear($regex);
			if ($min !== null) $this->min($min);
			if ($max !== null) $this->max($max);
			return $this;
		}

		public function clear($regex) {
			if ($this->key !== null)
				$this->link = self::replace($regex, $this->link);
			return $this;
		}

		public function min($min) {
			if ($this->key !== null)
				if (strlen($this->link) < $min) $this->errors[$this->key][] = sprintf("минимальное кол-во знаков %d", $min);
			return $this;
		}

		public function max($max) {
			if ($this->key !== null)
				if (strlen($this->link) > $max) $this->errors[$this->key][] = sprintf("максимальное кол-во знаков %d", $max);
			return $this;
		}

		public function getErrors() {
			return empty($this->errors) ? false : $this->errors;
		}

		public function getData() {
			return $this->data;
		}

		public final static function replace($regex, $str) {
			return preg_replace($regex, '', $str);
		}
	}

}?>