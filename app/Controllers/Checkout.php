<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Checkout extends BaseController
{
    private $usuario;

    private $formaPagamentoModel;
    private $bairroModel;
    private $pedidoModel;

    public function __construct() {

        $this->usuario = service('autenticacao')->pegaUsuarioLogado();

        $this->formaPagamentoModel = new \App\Models\FormaPagamentoModel();
        $this->bairroModel = new \App\Models\BairroModel();
        $this->pedidoModel = new \App\Models\PedidoModel();
    }

    public function index()
    {
        if (!session()->has('carrinho') || count(session()->get('carrinho')) < 1) {
            return redirect()->to(site_url('carrinho'));
        }
        
        $data = [
            'titulo' => 'Finalizar pedido',
            'carrinho' => session()->get('carrinho'),
            'formas' => $this->formaPagamentoModel->where('ativo', true)->findAll(),
        ];

        return view('Checkout/index', $data);
    }

    public function consultaCep()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back();
        }

        $validacao = service('validation');

        $validacao->setRule('cep', 'CEP', 'required|exact_length[9]');

        $retono = [];

        if (!$validacao->withRequest($this->request)->run()) {
            $retono['erro'] = '<span class="text-danger small">' . $validacao->getError() . '</span>';

            return $this->response->setJSON($retono);
        }

        /* CEP formatado */
        $cep = str_replace("-", "", $this->request->getGet('cep'));

        /* Carregando o Helper */
        helper('consulta_cep');

        $consulta = consultaCep($cep);

        

        if (isset($consulta->erro) && !isset($consulta->cep)) {
            $retono['erro'] = '<span class="text-danger small">Informe um CEP válido!</span>';

            return $this->response->setJSON($retono);
        }

        $bairroRetornoSlug = mb_url_title($consulta->bairro, '-', true);

        $bairro = $this->bairroModel->select('nome, valor_entrega, slug')
                                    ->where('slug', $bairroRetornoSlug)
                                    ->where('ativo', true)
                                    ->first();
                            
        if ($consulta->bairro == null || $bairro == null) {
            $retono['erro'] = '<span class="text-danger small">Não atendemos o bairro: '
                            . esc($consulta->bairro)
                            . ' - ' . esc($consulta->localidade)
                            . ' - CEP: ' . esc($consulta->cep)
                            . ' - ' . esc($consulta->uf)
                            . '</span>';
                                
            return $this->response->setJSON($retono);
        }

        $retono['valor_entrega'] = 'R$ ' . esc(number_format($bairro->valor_entrega, 2));
        $retono['bairro'] = '<span class="small">Valor de entrega para o Bairro: '
                            . esc($consulta->bairro)
                            . ' - ' . esc($consulta->localidade)
                            . ' - CEP: ' . esc($consulta->cep)
                            . ' - ' . esc($consulta->uf)
                            . ' - R$ ' . esc(number_format($bairro->valor_entrega, 2))
                            . '</span>';

        $retono['endereco'] = esc($consulta->bairro)
                            . ' - ' . esc($consulta->localidade)
                            . ' - ' . esc($consulta->logradouro)
                            . ' - CEP: ' . esc($consulta->cep)
                            . ' - ' . esc($consulta->uf)
                            . ' - R$ ' . esc(number_format($bairro->valor_entrega, 2));

        $retono['logradouro'] = esc($consulta->logradouro);

        $retono['bairro_slug'] = esc($bairro->slug);

        $retono['total'] = number_format($this->somaValorProdutosCarrinho() + $bairro->valor_entrega, 2);

        session()->set('endereco_entrega', $retono['endereco']);

        // echo '<pre>';
        // print_r($bairro);
        // die;

        return $this->response->setJSON($retono);
    }

    public function processar(){

        if ($this->request->getMethod() === 'post') {

            $checkoutPost = $this->request->getPost('checkout');

            $validacao = service('validation');

            $validacao->setRules([
                'checkout.rua' => ['label' => 'Endereço', 'rules' => 'required|max_length[50]'],
                'checkout.numero' => ['label' => 'Número', 'rules' => 'required|max_length[30]'],
                'checkout.referencia' => ['label' => 'Referência', 'rules' => 'required|max_length[50]'],
                'checkout.forma_id' => ['label' => 'Forma de pagamento na entrega', 'rules' => 'required|integer'],
                'checkout.bairro_slug' => ['label' => 'Endereço de entrega', 'rules' => 'required|string|max_length[30]'],

            ]);

            if (!$validacao->withRequest($this->request)->run()) {

                session()->remove('endereco_entrega');

                return redirect()->back()->with('errors_model', $validacao->getErrors())
                                        ->with('atencao', "Por favor, verifique os erros abaixo e tente novamente.")
                                        ->withInput();
            }
            
            $forma = $this->formaPagamentoModel->where('id', $checkoutPost['forma_id'])->first();

            if ($forma == null) {

                session()->remove('endereco_entrega');

                return redirect()->back()
                                ->with('atencao', "Por favor, escolha a <strong>Forma de Pagamento na Entrega</strong> e tente novamente.");
            }

            $bairro = $this->bairroModel->where('slug', $checkoutPost['bairro_slug'])->first();
            
            if ($bairro == null) {

                session()->remove('endereco_entrega');

                return redirect()->back()
                                ->with('atencao', "Por favor, <strong>Informe o seu CEP</strong> e calcule a taxa de entrega novamente.");
            }

            if (!session()->get('endereco_entrega')) {

                return redirect()->back()
                                ->with('atencao', "Por favor, <strong>Informe o seu CEP</strong> e calcule a taxa de entrega novamente.");
            }

            /* Já podemos salvar o pedido */

            $pedido = new \App\Entities\Pedido();

            $pedido->usuario_id = $this->usuario->id;
            $pedido->codigo = $this->pedidoModel->geraCodigoPedido();
            $pedido->forma_pagamento = $forma->nome;
            $pedido->produtos = serialize(session()->get('carrinho'));
            $pedido->valor_produtos = number_format($this->somaValorProdutosCarrinho(), 2);
            $pedido->valor_entrega = number_format($bairro->valor_entrega, 2);
            $pedido->valor_pedido = number_format($pedido->valor_produtos + $pedido->valor_entrega, 2);
            $pedido->endereco_entrega = session()->get('endereco_entrega') . ' - Número: ' . $checkoutPost['numero'];

            if ($forma->id == 1) {
                
                if (isset($checkoutPost['sem_troco'])){
                    $pedido->observacoes = 'Ponto de referência: ' . $checkoutPost['referencia'] . ' - Número: ' . $checkoutPost['numero'] . ' - Você informou que não precisa de troco.';
                }

                if (isset($checkoutPost['troco_para'])){

                    if ($checkoutPost['troco_para'] == "" || $checkoutPost['troco_para'] < 1) {

                        return redirect()->back()
                                ->with('atencao', "Ao escolher que <strong>Precisa de troco</strong>, por favor informe um valor maior que zero.");
                    }

                    $troco_para = str_replace(',', '', $checkoutPost['troco_para']);

                    // if ($troco_para < 1) {
                    //     // Também funciona para o debug de $troco_para vazio ou igual a zero
                    // }
                    
                    $pedido->observacoes = 'Ponto de referência: ' . $checkoutPost['referencia'] . ' - Número: ' . $checkoutPost['numero'] . ' - Você informou que precisa de troco para: R$ ' . number_format($troco_para, 2);
                }

            } else {

                /* Cliente escolheu forma de pagamento diferente de Dinheiro */
                $pedido->observacoes = 'Ponto de referência: ' . $checkoutPost['referencia'] . ' - Número: ' . $checkoutPost['numero'];
            }
            
            
            $this->pedidoModel->save($pedido);

            $pedido->usuario = $this->usuario;

            $this->enviaEmailPedidoRealizado($pedido);

            session()->remove('carrinho');
            session()->remove('endereco_entrega');

            return redirect()->to(site_url("checkout/sucesso/$pedido->codigo"));

        } else {
            return redirect()->back();
        }
    }

    public function sucesso($codigoPedido = null)
    {
        $pedido = $this->buscaPedidoOu404($codigoPedido);

        $data = [
            'titulo' => "Pedido $codigoPedido realizado com suceso",
            'pedido' => $pedido,
            "produtos" => unserialize($pedido->produtos),
        ];

        return view('Checkout/sucesso', $data);
    }

    // ------------------- Funções privadas ------------------------ //

    private function somaValorProdutosCarrinho() {

        $produtosCarrinho = array_map(function ($linha) {
            return $linha['quantidade'] * $linha['preco'];
        }, session()->get('carrinho'));

        return array_sum($produtosCarrinho);
    }

    private function enviaEmailPedidoRealizado(object $pedido) {

        $email = service('email');

        $email->setFrom('no-reply@delivery.com.br', 'Food Delivery');
        $email->setTo($this->usuario->email);

        $email->setSubject("Pedido $pedido->codigo realizado com sucesso!");
        
        $mensagem = view('Checkout/pedido_email', ['pedido' => $pedido]);

        $email->setMessage($mensagem);

        $email->send();
    }

    /**
     * @param string $id
     * @return objeto pedido
     */
    private function buscaPedidoOu404(string $codigoPedido = null)
    {
        if (!$codigoPedido || !$pedido = $this->pedidoModel
                                    ->where('codigo', $codigoPedido)
                                    ->where('usuario_id', $this->usuario->id)
                                    ->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o pedido $codigoPedido");
        }
        
        return $pedido;
    }
}
