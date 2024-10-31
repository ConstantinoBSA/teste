<?php

namespace App\Core;

class Sanitizer
{
    /**
     * Sanitiza uma string para evitar XSS.
     *
     * @param string $value A string a ser sanitizada.
     * @return string A string sanitizada.
     */
    public function sanitizeString($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Sanitiza um array de strings.
     *
     * @param array $array O array de strings a ser sanitizado.
     * @return array O array sanitizado.
     */
    public function sanitizeArray(array $array)
    {
        return array_map([$this, 'sanitizeString'], $array);
    }

    // Adicione outros métodos de sanitização conforme necessário

    //Auditoria e Logs: Implemente um sistema de logs para monitorar atividades suspeitas e rastrear erros.
}
