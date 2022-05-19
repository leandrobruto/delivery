<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Pedidos extends BaseController
{
    private $pedidoModel;

    public function __construct() {

        $this->pedidoModel = new \App\Models\PedidoModel();
        
    }

    public function index()
    {
        
        $data = [
            'titulo' => 'Pedidos realizados',
            'pedidos' => $this->pedidoModel->listaTodosOsPedidos(),
            'pager' => $this->pedidoModel->pager,
        ];

        return view('Admin/Pedidos/index', $data);
    }

    public function procurar()
    {
        if (!$this->request->isAjax()) 
        {
            exit('Página não encontrada');
        }

        $pedidos = $this->pedidoModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach ($pedidos as $pedido) {
            $data['id'] = $pedido->id;
            $data['value'] = $pedido->codigo;

            $retorno[] = $data;
        }
        
        return $this->response->setJson($retorno);
    }

    public function show($codigoPedido = null)
    {
        $pedido = $this->pedidoModel->buscaPedidoOu404($codigoPedido);

        $data = [
            'titulo'     => "Detalhando o pedido $pedido->codigo",
            'pedido' => $pedido,
        ];

        return view('Admin/Pedidos/show', $data);
    }

    public function editar($codigoPedido = null)
    {
        $pedido = $this->pedidoModel->buscaPedidoOu404($codigoPedido);

        if ($pedido->situacao == 2) {

            return redirect()->back()->with('info', 'Esse pedido já foi entregue e portanto não é possível editá-lo.');
        }

        if ($pedido->situacao == 3) {

            return redirect()->back()->with('info', 'Esse pedido foi cancelado e portanto não é possível editá-lo.');
        }

        $data = [
            'titulo'     => "Editando o pedido $pedido->codigo",
            'pedido' => $pedido,
        ];

        return view('Admin/Pedidos/editar', $data);
    }

}
