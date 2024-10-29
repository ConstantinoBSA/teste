<?php

namespace Core;

class Controller
{
    public function model($model)
    {
        $modelClass = 'Models\\' . $model;
        require_once 'Models/' . $model . '.php';
        return new $modelClass();
    }

    public function view($view, $data = [])
    {
        require_once __DIR__ . '/../views/' . $view . '.php';
    }
}
