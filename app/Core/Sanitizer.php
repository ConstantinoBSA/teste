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
     * Remove todas as tags HTML e PHP de uma string.
     *
     * @param string $value A string a ser sanitizada.
     * @return string A string sem tags HTML e PHP.
     */
    public function stripTags($value)
    {
        return strip_tags($value);
    }

    /**
     * Sanitiza um e-mail removendo caracteres inválidos.
     *
     * @param string $email O e-mail a ser sanitizado.
     * @return string O e-mail sanitizado.
     */
    public function sanitizeEmail($email)
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Sanitiza uma URL removendo caracteres inválidos.
     *
     * @param string $url A URL a ser sanitizada.
     * @return string A URL sanitizada.
     */
    public function sanitizeUrl($url)
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

    /**
     * Sanitiza um número inteiro removendo caracteres não numéricos.
     *
     * @param string $number O número a ser sanitizado.
     * @return string O número sanitizado.
     */
    public function sanitizeInt($number)
    {
        return filter_var($number, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * Adiciona barras invertidas a uma string para escapar caracteres especiais.
     *
     * @param string $value A string a ser escapada.
     * @return string A string com barras invertidas adicionadas.
     */
    public function addSlashes($value)
    {
        return addslashes($value);
    }

    /**
     * Remove barras invertidas de uma string.
     *
     * @param string $value A string a ser processada.
     * @return string A string sem barras invertidas.
     */
    public function stripSlashes($value)
    {
        return stripcslashes($value);
    }

    /**
     * Escapa caracteres especiais em uma string para uso em JSON.
     *
     * @param mixed $value O valor a ser convertido para JSON.
     * @return string A string JSON escapada.
     */
    public function jsonEncode($value)
    {
        return json_encode($value);
    }

    /**
     * Remove caracteres não alfanuméricos de uma string.
     *
     * @param string $value A string a ser sanitizada.
     * @return string A string apenas com caracteres alfanuméricos.
     */
    public function sanitizeAlphaNumeric($value)
    {
        return preg_replace("/[^a-zA-Z0-9]/", "", $value);
    }

    /**
     * Purifica HTML para remover ameaças XSS e garantir segurança.
     *
     * @param string $html O HTML a ser purificado.
     * @return string O HTML purificado.
     */
    public function purifyHtml($html)
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        return $purifier->purify($html);
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
}
