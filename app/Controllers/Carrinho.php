<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Carrinho extends BaseController
{
    private $validacao;
    private $produtoEspecificacaoModel;
    private $extraModel;
    private $produtoModel;

    private $acao;
    
    public function __construct() {

        $this->validacao = service('validation');
        $this->produtoEspecificacaoModel = new \App\Models\ProdutoEspecificacaoModel();
        $this->extraModel = new \App\Models\ExtraModel();
        $this->produtoModel = new \App\Models\ProdutoModel();

        $this->acao = service('router')->methodName();
    }

    public function index() {
        //
    }

    public function adicionar() {
        
        if ($this->request->getMethod() == 'post') {

            $produtoPost = $this->request->getPost('produto');

            $this->validacao->setRules([
                'produto.slug' => ['label' => 'Produto', 'rules' => 'required|string'],
                'produto.especificacao_id' => ['label' => 'Valor do produto', 'rules' => 'required|greater_than[0]'],
                'produto.preco' => ['label' => 'Valor do produto', 'rules' =>'required|greater_than[0]'],
                'produto.quantidade' => ['label' => 'Quantidade', 'rules' =>'required|greater_than[0]'],

            ]);

            if (!$this->validacao->withRequest($this->request)->run()) {

                return redirect()->back()->with('errors_model', $this->validacao->getErrors())
                                        ->with('atencao', "Por favor, verifique os erros abaixo e tente novamente.")
                                        ->withInput();
            }

            /* Validamos a existência da especificacao_id */
            $especificacaoProduto = $this->produtoEspecificacaoModel
                                        ->join('medidas', 'medidas.id = produtos_especificacoes.medida_id')
                                        ->where('produtos_especificacoes.id', $produtoPost['especificacao_id'])->first();

            if ($especificacaoProduto == null) {
                return redirect()->back()
                                ->with('fraude', 'Não conseguimos processar a sua solicitação. 
                                    Por favor, entre em contato com a nossa equipe e informe o código de erro: 
                                    <strong>ERRO-ADD-PROD-1001</strong>.'); // Fraude no FORM na chave $produtoPost['especificacao_id'] 
            }

            /* Caso o extra_id venha no POST, validamos a existência do mesmo */
            if ($produtoPost['extra_id'] && $produtoPost['extra_id'] != "") {

                $extra = $this->extraModel->where('id', $produtoPost['extra_id'])->first();

                if ($extra == null) {

                
                return redirect()->back()
                                ->with('fraude', 'Não conseguimos processar a sua solicitação. 
                                    Por favor, entre em contato com a nossa equipe e informe o código de erro: 
                                    <strong>ERRO-ADD-PROD-2002</strong>.'); // Fraude no FORM na chave $produtoPost['extra_id'] 
            
                }
            }

            /* Estamoutilizando o toArray() para que possamos inserir esse objeto no carrinho no formato adequado */
            $produto = $this->produtoModel->select(['id', 'nome', 'slug', 'ativo'])->where('slug', $produtoPost['slug'])->first()->toArray();

            /* Validamos a existência do produto e se o mesmo esta ativo */
            if ($produto == null || $produto['ativo'] == false) {
                
                return redirect()->back()
                                ->with('fraude', 'Não conseguimos processar a sua solicitação. 
                                    Por favor, entre em contato com a nossa equipe e informe o código de erro: 
                                    <strong>ERRO-ADD-PROD-3003</strong>.'); // Fraude no FORM na chave $produtoPost['slug'] 
            }

            /* Criamos o slug composto para identificarmos a existência ou não do item no carrinho na hora de adicionar */
            $produto['slug'] = mb_url_title($produto['slug'] . '-' . $especificacaoProduto->nome . '-' . (isset($extra) ? 'com extra-'. $extra->nome : ''), '-', true);

            /* Criamos o nome do produto a partir da especificacao e / ou do extra */
            $produto['nome'] = $produto['nome'] . ' ' . $especificacaoProduto->nome . ' ' . (isset($extra) ? 'Com extra '. $extra->nome : '');
            
            /* Definimos o preço, quantidade e tamanho do produto */
            $preco = $especificacaoProduto->preco + (isset($extra) ? $extra->preco : 0);

            $produto['preco'] = number_format($preco, 2);
            $produto['quantidade'] = (int) $produtoPost['quantidade'];
            $produto['tamanho'] = $especificacaoProduto->nome;

            /* Removemos os atributos sem utilidades */
            unset($produto['ativo']);

            /* Iniciamos a inserção do produto no carrinho */
            if (session()->has('carrinho')) {

                /* Existe um carrinho de compras.. damos sequência.. */
                
                /* Recupero os produtos do carrinho */
                $produtos = session()->get('carrinho');

                /* Recuperamos apenas o slug dos produtos do carrinho */
                $produtosSlugs = array_column($produtos, 'slug');

                if (in_array($produto['slug'], $produtosSlugs)) {

                    /* Já existe o produto no carrinho.. Incrementamos a quantidade */

                    /* Chamamos a função que incrementa a quantidade do produto caso o mesmo exista no carrinho */
                    $produtos = $this->atualizaProduto($this->acao, $produto['slug'], $produto['quantidade'], $produtos);

                    /* Sobreescrevemos a sessão carrinho com o array $produtos que foi incrementado (alterado) */
                    session()->set('carrinho', $produtos);

                } else {

                    /**
                    * Não existe no carrinho.. Pode adicionar
                    * Adicionamos no carrinho existente o $produto.
                    * Notem o push adiciona na sessão 'carrinho' um array [$produto] 
                    */
                    session()->push('carrinho', [$produto]);
                }

            } else {

                /* Não existe ainda um carrinho de compras na sessão */
                $produtos[] = $produto;

                session()->set('carrinho', $produtos);
            }

            return redirect()->back()->with('sucesso', 'Produto adicionado com sucesso');
            
        } else {
            return redirect()->back();
        }
    }


    /**
     * @param string $acao
     * @param string $slug
     * @param int $quantidade
     * @param array $produtos
     * @return array $produtos
     */
    public function atualizaProduto(string $acao, string $slug, int $quantidade, array $produtos) {
        
        $produtos = array_map(function ($linha) use ($acao, $slug, $quantidade) {

            if ($linha['slug'] == $slug) {

                if ($acao === 'adicionar') {
                    $linha['quantidade'] += $quantidade;
                } 
                
                if ($acao === 'atualizar') {
                    $linha['quantidade'] = $quantidade;
                }
            }

            return $linha;

        }, $produtos);

        return $produtos;
    }
}
