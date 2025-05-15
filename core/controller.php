<?php

namespace Core;

class Controller {
    public function render($view, $data = []) {
        extract($data);
        require_once dirname(__DIR__) . '/app/views/' . $view . '.php';
    }
}

