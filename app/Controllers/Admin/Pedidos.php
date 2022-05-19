<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Pedidos extends BaseController
{
    private $pedidoModel;
    private $entregadorModel;

    public function __construct() {

        $this->pedidoModel = new \App\Models\PedidoModel();
        $this->entregadorModel = new \App\Models\EntregadorModel();
        
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
            'entregadores' => $this->entregadorModel->select('id, nome')->where('ativo', true)->findAll(),
        ];

        return view('Admin/Pedidos/editar', $data);
    }

    public function atualizar($codigoPedido = null)
    {
        if ($this->request->getMethod() === 'post') {
            
            $pedido = $this->pedidoModel->buscaPedidoOu404($codigoPedido);

            if ($pedido->situacao == 2) {

                return redirect()->back()->with('info', 'Esse pedido já foi entregue e portanto não é possível editá-lo.');
            }
    
            if ($pedido->situacao == 3) {
    
                return redirect()->back()->with('info', 'Esse pedido foi cancelado e portanto não é possível editá-lo.');
            }

            $pedidoPost = $this->request->getPost();

            if (!isset($pedidoPost['situacao'])) {
                return redirect()->back()->with('atencao', "Escolha a situação do pedido.");
            }

            if ($pedidoPost['situacao'] == 1) {

                if (strlen($pedidoPost['entregador_id']) < 1) {

                    return redirect()->back()->with('atencao', "Se o pedido está saindo para entrega, por favor escolha o entregador.");

                }
            }

            if ($pedido->situacao == 0) {

                if ($pedidoPost['situacao'] == 2) {

                    return redirect()->back()->with('atencao', "O pedido não pode ter sido entregue, pois ainda não <strong>saiu para entrega</strong>.");

                }
            }

            if ($pedidoPost['situacao'] != 1) {

                unset($pedidoPost['entregador_id']);
            }

            if ($pedidoPost['situacao'] == 3) {

                $pedidoPost['entregador_id'] = null;
            }

            /* Usaremos para avisar o admin que o pedido foi cancelado (ligar entregador) */
            $situacaoAnterior = $pedido->situacao;

            $pedido->fill($this->request->getPost());

            if (!$pedido->hasChanged()) {
                return redirect()->back()->with('info', "Não há novas informações para atualizar.");
            }

            
            if ($this->pedidoModel->save($pedido)) {

                if ($pedido->situacao == 1) {

                    $entregador = $this->entregadorModel->find($pedido->entregador_id);

                    $pedido->entregador = $entregador;

                    $this->enviaEmailPedidoSaiuEntrega($pedido);
                }

                
                return redirect()->back()->with('sucesso', 'Pedido atualizado com sucesso!');
            } else {
                return redirect()->back()->with('errors_model', $this->pedidoModel->errors())
                                    ->with('atencao', "Por favor, verifique os erros abaixo.");
            }

        } else {
            /* Não é POST */
            return redirect()->back();
        }
    }

    private function enviaEmailPedidoSaiuEntrega(object $pedido) {

        $email = \Config\Services::email();

        $email->setFrom('no-reply@delivery.com.br', 'Food Delivery');
        $email->setTo($pedido->email);

        $email->setSubject("Pedido $pedido->codigo saiu para entrega");
        
        $mensagem = view('Admin/Pedidos/pedido_saiu_entrega_email', ['pedido' => $pedido]);

        $email->setMessage($mensagem);

        $email->send();
    }

}
