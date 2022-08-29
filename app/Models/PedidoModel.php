<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table            = 'pedidos';
    protected $returnType       = 'App\Entities\Pedido';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'usuario_id',
        'entregador_id',
        'codigo',
        'forma_pagamento',
        'situacao',
        'produtos',
        'valor_produtos',
        'valor_entrega',
        'valor_pedido',
        'endereco_entrega',
        'observacoes',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    /**
     * @uso Controller pedidos no método procurar com o autocomplete
     * @param string $term
     * @return array pedidos
     */
    public function procurar ($term) {
        if ($term === null) {
            return [];
        }

        return $this->select('codigo')
                    ->like('codigo', $term)
                    ->withDeleted(true)
                    ->get()
                    ->getResult();
    }

    public function geraCodigoPedido() {
        
        do {
            
            $codigoPedido = random_string('numeric', 8);

            $this->where('codigo', $codigoPedido);

        } while ($this->countAllResults() > 1);
    
        return $codigoPedido;
    }

    /**
     * @uso controller Admin\Pedidos
     */
    public function listaTodosOsPedidos() {

        return $this->select(['pedidos.*', 'usuarios.nome AS cliente',])
                            ->join('usuarios', 'usuarios.id = pedidos.usuario_id')
                            ->orderBy('pedidos.criado_em', 'DESC')
                            ->paginate(10);
    }

    public function buscaPedidoOu404(string $codigoPedido)
    {
        if (!$codigoPedido) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o pedido $codigoPedido");
        }

        $pedido = $this->select(['pedidos.*', 'usuarios.nome', 'usuarios.email', 'entregadores.nome AS entregador'])
                        ->join('usuarios', 'usuarios.id = pedidos.usuario_id')
                        ->join('entregadores', 'entregadores.id = pedidos.entregador_id', 'LEFT')
                        ->where('pedidos.codigo', $codigoPedido)
                        ->first();

        if (!$pedido) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o pedido $codigoPedido");
        }

        return $pedido;
    }

    public function valorPedidosEntregues() {

        return $this->select('COUNT(*) AS total')
                    ->selectSum('valor_pedido')
                    ->where('situacao', 2)
                    ->first();
    }

    public function valorPedidosCancelados() {

        return $this->select('COUNT(*) AS total')
                    ->selectSum('valor_pedido')
                    ->where('situacao', 3) // Cancelado
                    ->first();
    }

    public function recuperaClientesMaisAssiduos(int $quantidade) {

        return $this->select('usuarios.nome, COUNT(*) AS pedidos')
                    ->join('usuarios', 'usuarios.id = pedidos.usuario_id')
                    ->where('situacao', 2) // Entregue
                    ->limit($quantidade)
                    ->groupBy('usuarios.nome')
                    ->orderBy('pedidos', 'DESC')
                    ->find();
    }
}
