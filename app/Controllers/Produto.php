<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Produto extends BaseController
{
    private $produtoModel;
    private $produtoEspecificacaoModel;
    private $produtoExtraModel;

    public function __construct() {
        $this->produtoModel = new \App\Models\ProdutoModel();
        $this->produtoEspecificacaoModel = new \App\Models\ProdutoEspecificacaoModel();
        $this->produtoExtraModel = new \App\Models\ProdutoExtraModel();
    }

    public function detalhes($produto_slug)
    {
        if (!$produto_slug || !$produto = $this->produtoModel->where('slug', $produto_slug)->first()) {
            return redirect()->to(site_url('/'));
        }

        $data = [
            'titulo' => "Detalhando o produto $produto->nome",
            'produto' => $produto,
            'especificacoes' => $this->produtoEspecificacaoModel->buscaEspecificacoesDoProdutoDetalhes($produto->id),
        ];

        $extras = $this->produtoExtraModel->buscaExtrasDoProdutoDetalhes($produto->id);

        if ($extras) {

            $data['extras'] =  $extras;

        }

        return view('Produto/detalhes', $data);
    }

    public function imagem(string $imagem = null)
    {
        if ($imagem) {
            $caminhoImagem = WRITEPATH . 'uploads/produtos/' . $imagem;

            $infoImagem = new \finfo(FILEINFO_MIME);

            $tipoImagem = $infoImagem->file($caminhoImagem);
            
            header("Content-Type: $tipoImagem");
            header("Content-Length: " . filesize($caminhoImagem));
            
            readfile($caminhoImagem);

            exit;
        }
    }
}
