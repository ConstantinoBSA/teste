<?php

namespace Core;

class Controller
{
    public function model($model)
    {
        $modelClass = 'Models\\' . $model;
        $modelPath = __DIR__ . '/../Models/' . $model . '.php';

        if (file_exists($modelPath)) {
            require_once $modelPath;
            return new $modelClass();
        } else {
            throw new Exception("Model file not found: $modelPath");
        }
    }

    public function view($view, $data = [])
    {
        extract($data);
        $viewPath = __DIR__ . '/../../resources/views/' . $view . '.php';

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            echo "View not found: $viewPath"; // Debugging
        }
    }
}
