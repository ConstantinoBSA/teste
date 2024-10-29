<?php

namespace core;

class Controller {
    public function model($model) {
        require_once '../Models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = []) {
        require_once '../views/' . $view . '.php';
    }
}
