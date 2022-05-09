<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoExtraModel extends Model
{
    protected $table            = 'produtos_extras';
    protected $primaryKey       = 'object';
    protected $allowedFields    = ['produto_id', 'extra_id'];

    // Validações
    protected $validationRules = [
        'produto_id' => 'required|integer',
        'extra_id' => 'required|integer',
    ];

    protected $validationMessages = [
        'extra_id' => [
            'required' => 'O campo Extra é obrigatório.',
        ],
    ];

    /**
     * @descrição: Recupera os extras do produto em questão
     * @uso Controller Admin/Produtos/extra($id = null)
     * @param int $produto_id
     */
    public function buscaExtrasDoProduto(int $produto_id = null) {

        return $this->select('extras.nome AS extra, extras.preco, produtos_extras.*')
                    ->join('extras', 'extras.id = produtos_extras.extra_id')
                    ->join('produtos', 'produtos.id = produtos_extras.produto_id')
                    ->where('produtos_extras.produto_id', $produto_id)
                    ->findAll();
    }
}
