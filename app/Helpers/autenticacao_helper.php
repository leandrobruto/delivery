<?php

if (!function_exists('usuarioLogado')) {
    
    function usuarioLogado() {

        $autenticacao = service('autenticacao');

        return $autenticacao->pegaUsuarioLogado();
    }
}