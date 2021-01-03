<?php

namespace App\Core;

class View extends \ArrayIterator {
    /**
     * @var string
     */
    private string $template;

    public function __construct(string $template, array $data = []) {
        parent::__construct($data, \ArrayObject::ARRAY_AS_PROPS);
        $this->template = $template;
    }

    public function render() {
        ob_start();
        foreach ($this as $key => $value) {
            if ($value instanceof self) {
                $this->$key = $value->render();
            }
        }
        require_once real_path($this->template . '.php');
        return ob_get_clean();
    }
}
