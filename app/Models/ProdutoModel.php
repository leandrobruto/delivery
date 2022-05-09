<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $table            = 'produtos';
    protected $returnType       = 'App\Entities\Produto';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['categoria_id', 'nome', 'slug', 'ingredientes', 'ativo', 'imagem'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

   // Validation
   protected $validationRules = [
        'categoria_id' => 'required|integer',
        'nome' => 'required|min_length[4]|max_length[120]|is_unique[produtos.nome]',
        'ingredientes' => 'required|min_length[10]|max_length[1000]',
    ];

    protected $validationMessages = [
        'categoria_id' => [
            'required' => 'O campo Categoria é obrigatório.',
        ],
        'nome' => [
            'required' => 'O campo Nome é obrigatório.',
            'is_unique' => 'Esse produto já existe.'
        ],
    ];

    // Eventos callback
    protected $beforeInsert = ['criaSlug'];
    protected $beforeUpdate = ['criaSlug'];

    public function criaSlug (array $data) {

        if (isset($data['data']['nome'])) {
            $data['data']['slug'] = mb_url_title($data['data']['nome'], '-', TRUE);

        }

        return $data;
    }

    /**
     * @uso Controller produtos no método procurar com o autocomplete
     * @param string $term
     * @return array produtos
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
}