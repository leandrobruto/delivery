<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;
use App\Libraries\Token;

class Usuario extends Entity
{
    protected $dates   = [
        'criado_em', 
        'atualizado_em', 
        'deletado_em',
    ];

    public function verificaPassword(string $password) {
        return password_verify($password, $this->password_hash);
    }

    public function iniciaPasswordReset() {

        /* Instancia o objeto da classe Token */
        $token = new Token();
        
        /**
         * @descrição: Atribuímos ao objeto Usuário ($this) o atributo 'reset_token' que conterá o token gerado
         *             para que possamos acessá-lo na view 'Password/reset_email'.
         */
        $this->reset_token = $token->getValue();

        /**
         * @descrição: Atribuímos ao objeto Entities Usuario ($this) o atributo 'reset_hash' que conterá o hash do token.
         */
        $this->reset_hash = $token->getHash();
        
        $this->reset_expira_em = date('Y-m-d H:i:s', time() + 7200); // Expira em 2hrs a partir da data e hora atuais
    }

    public function completaPasswordReset() {

        $this->reset_hash = null;
        $this->reset_expira_em = null;
        
    }
}
