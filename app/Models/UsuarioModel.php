<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Libraries\Token;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $returnType       = 'App\Entities\Usuario';
    protected $allowedFields    = ['nome', 'cpf', 'telefone', 'email', 'password', 'reset_hash', 'reset_expira_em', 'ativacao_hash'];
    // Datas
    protected $useTimestamps    = true;
    protected $createdField     = 'criado_em';
    protected $updatedField     = 'atualizado_em';
    protected $dateFormat       = 'datetime'; // Para uso com o $softDelete
    protected $useSoftDeletes   = true;
    protected $deletedField     = 'deletado_em';
    // Validações
    protected $validationRules = [
        'nome' => 'required|min_length[4]|max_length[120]',
        'cpf' => 'required|exact_length[14]|validaCpf|is_unique[usuarios.cpf]',
        'telefone' => 'required',
        'email' => 'required|valid_email|is_unique[usuarios.email]',
        'password' => 'required|min_length[6]',
        'password_confirmation' => 'required_with[password]|matches[password]',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo Nome é obrigatório.',
        ],
        'cpf' => [
            'required' => 'O campo CPF é obrigatório.',
            'is_unique' => 'Desculpe. Esse CPF já existe.',
        ],
        'telefone' => [
            'required' => 'O campo Telefone é obrigatório.',
        ],
        'email' => [
            'required' => 'O campo E-mail é obrigatório.',
            'is_unique' => 'Desculpe. Esse email já existe.',
        ],
        'password' => [
            'required' => 'O campo Senha é obrigatório.',
        ],
    ];

    // Eventos callback
    protected $beforeInsert = ['hasPassword'];
    protected $beforeUpdate = ['hasPassword'];

    public function hasPassword (array $data) {

        if (isset($data['data']['password'])) {
            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

            unset($data['data']['password']);
            unset($data['data']['password_confirmation']);
        }

        return $data;
    }

    /**
     * @uso Controller usuarios no método procurar com o autocomplete
     * @param string $term
     * @return array usuarios
     */
    public function procurar ($term) {
        if ($term === null) {
            return [];
        }

        return $this->select('id, nome')
                    ->like('nome', $term)
                    ->withDeleted(true)
                    ->get()
                    ->getResult();
    }

    public function desabilitaValidacaoSenha () {
        unset($this->validationRules['password']);
        unset($this->validationRules['password_confirmation']);
    }

    public function desabilitaValidacaoTelefone () {
        unset($this->validationRules['telefone']);
    }

    public function desfazerExclusao(int $id) {

        return $this->protect(false)
                    ->where('id', $id)
                    ->set('deletado_em', null)
                    ->update();
    }

    /**
     * @uso Classe Autenticacao
     * @param string $email
     * @return object $usuario
     */
    public function buscaUsuarioPorEmail(string $email) {

        return $this->where('email', $email)->first();

    }

    public function buscaUsuarioParaResetarSenha(string $token) {

        $token = new Token($token);

        $tokenHash = $token->getHash();

        $usuario = $this->where('reset_hash', $tokenHash)->first();

        if ($usuario != null) {

            /**
             * Verificamos se o token não está expirado de acordo com a data e hora atuais
             */
            if ($usuario->reset_expira_em < date('Y-m-d H:i:s')) {

                /**
                 * Token está expirado, então setamos o $usuario = null
                 */
                $usuario = null;
            }

            return $usuario;
        }
    }

    public function ativarContaPeloToken(string $token) {

        $token = new Token($token);

        $tokenHash = $token->getHash();

        $usuario = $this->where('ativacao_hash', $tokenHash)->first();

        if ($usuario != null) {
            
            $usuario->ativar();

            $this->protect(false)->save($usuario);
        }
    }

    public function recuperaTotalClientesAtivos() {

        return $this->where('is_admin', false)
                    ->where('ativo', true)
                    ->countAllResults();
    }
}
