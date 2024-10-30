<?php

namespace Core;

class Validator {
    protected $errors = [];

    public function validate($data, $rules) {
        foreach ($rules as $field => $ruleSet) {
            $rulesArray = explode('|', $ruleSet);
            foreach ($rulesArray as $rule) {
                $method = 'validate' . ucfirst($rule);
                if (method_exists($this, $method)) {
                    $this->$method($field, $data[$field] ?? null);
                }
            }
        }
        return $this->errors;
    }

    protected function validateRequired($field, $value) {
        if (empty($value)) {
            $this->errors[$field] = 'O campo ' . $field . ' é obrigatório.';
        }
    }

    protected function validateEmail($field, $value) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field] = 'O campo ' . $field . ' deve ser um email válido.';
        }
    }

    // Adicione outros métodos de validação conforme necessário
}
