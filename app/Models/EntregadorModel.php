<?php

namespace App\Models;

use CodeIgniter\Model;

class EntregadorModel extends Model
{
    protected $table            = 'entregadores';
    protected $returnType       = 'App\Entities\Entregador';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'nome', 
        'cpf', 
        'cnh', 
        'email', 
        'telefone', 
        'endereco', 
        'imagem', 
        'veiculo', 
        'placa', 
        'ativo'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';
    // Validações
    protected $validationRules = [
        'nome' => 'required|min_length[4]|max_length[120]',
        'cpf' => 'required|exact_length[14]|validaCpf|is_unique[entregadores.cpf]',
        'cnh' => 'required|exact_length[11]|is_unique[entregadores.cnh]',
        'email' => 'required|valid_email|is_unique[entregadores.email]',
        'telefone' => 'required|exact_length[15]|is_unique[entregadores.telefone]',
        'endereco' => 'required|max_length[230]',
        'veiculo' => 'required|max_length[230]',
        'placa' => 'required|min_length[7]|max_length[8]|is_unique[entregadores.placa]',
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

    /**
     * @uso Controller entregadores no método procurar com o autocomplete
     * @param string $term
     * @return array entregadores
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

    public function desfazerExclusao(int $id) {

        return $this->protect(false)
                    ->where('id', $id)
                    ->set('deletado_em', null)
                    ->update();
    }

    public function recuperaTotalEntregadoresAtivos() {

        return $this->where('ativo', true)
                    ->countAllResults();
    }

    public function recuperaEntregadoresMaisAssiduos(int $quantidade) {

        return $this->select('entregadores.nome, entregadores.imagem, COUNT(*) AS entregas')
                    ->join('pedidos', 'pedidos.entregador_id = entregadores.id')
                    ->where('pedidos.situacao', 2) // Entregue
                    ->limit($quantidade)
                    ->groupBy('entregadores.nome')
                    ->orderBy('entregas', 'DESC')
                    ->find();
    }
}
