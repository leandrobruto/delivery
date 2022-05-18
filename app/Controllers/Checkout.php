<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Checkout extends BaseController
{
    private $usuario;

    private $formaPagamentoModel;
    private $bairroModel;

    public function __construct() {

        $this->usuario = service('autenticacao')->pegaUsuarioLogado();

        $this->formaPagamentoModel = new \App\Models\FormaPagamentoModel();
        $this->bairroModel = new \App\Models\BairroModel();
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
            $retono['erro'] = '<span class="text-danger small"> Informe um CEP válido!   </span>';

            return $this->response->setJSON($retono);
        }

        $bairroRetornoSlug = mb_url_title($consulta->bairro, '-', true);

        $bairro = $this->bairroModel->select('nome, valor_entrega, slug')
                                    ->where('slug', $bairroRetornoSlug)
                                    ->where('ativo', true)
                                    ->first();
                            
        if ($consulta->bairro == null || $bairro == null) {
            $retono['erro'] = '<span class="text-danger small"> Não atendemos o bairro: '
                            . esc($consulta->bairro)
                            . ' - ' . esc($consulta->localidade)
                            . ' - CEP: ' . esc($consulta->cep)
                            . ' - ' . esc($consulta->uf)
                            . '</span>';
                                
            return $this->response->setJSON($retono);
        }

        $retono['valor_entrega'] = 'R$ ' . esc(number_format($bairro->valor_entrega, 2));
        $retono['bairro'] = '<span class="small"> Valor de entrega para o Bairro: '
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
                            . ' - R$ ' . esc(number_format($bairro->valor_entrega, 2))
                            . '</span>';

        $retono['logradouro'] = esc($consulta->logradouro);

        $retono['bairro_slug'] = esc($bairro->slug);

        $retono['total'] = number_format($this->somaValorProdutosCarrinho() + $bairro->valor_entrega, 2);

        session()->set('endereco_retorno', $retono['endereco']);

        // echo '<pre>';
        // print_r($bairro);
        // die;

        return $this->response->setJSON($retono);
    }

    public function processar($bairro){

        if ($this->request->getMethod() === 'post') {

            $checkoutPost = $this->request->getPost();

            dd($checkoutPost);
        } else {
            return redirect()->back();
        }
    }

    // ------------------- Funções privadas ------------------------ //

    private function somaValorProdutosCarrinho() {

        $produtosCarrinho = array_map(function ($linha) {
            return $linha['quantidade'] * $linha['preco'];
        }, session()->get('carrinho'));

        return array_sum($produtosCarrinho);
    }

}
