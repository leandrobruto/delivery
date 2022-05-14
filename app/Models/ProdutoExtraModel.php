<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoExtraModel extends Model
{
    protected $table            = 'produtos_extras';
    protected $returnType       = 'object';
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
     * @param int $quantidade_paginacao
     */
    public function buscaExtrasDoProduto(int $produto_id = null, $quantidade_paginacao) {

        return $this->select('extras.nome AS extra, extras.preco, produtos_extras.*')
                    ->join('extras', 'extras.id = produtos_extras.extra_id')
                    ->join('produtos', 'produtos.id = produtos_extras.produto_id')
                    ->where('produtos_extras.produto_id', $produto_id)
                    ->paginate($quantidade_paginacao);
    }

    /**
     * @descrição: Recupera os extras do produto em questão
     * @uso Controller Produto/detalhes e Produto/exibeTamanhos
     * @param int $produto_id
     * @return array objetos
     */
    public function buscaExtrasDoProdutoDetalhes(int $produto_id = null) {

        return $this->select('extras.id, extras.nome, extras.preco, produtos_extras.id AS id_principal')
                    ->join('extras', 'extras.id = produtos_extras.extra_id')
                    ->join('produtos', 'produtos.id = produtos_extras.produto_id')
                    ->where('produtos_extras.produto_id', $produto_id)
                    ->findAll();
    }
}
