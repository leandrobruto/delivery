<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Produto;

class Produtos extends BaseController
{
    private $produtoModel;
    private $categoriaModel;
    private $extraModel;
    private $produtoExtraModel;

    public function __construct() {
        $this->produtoModel = new \App\Models\ProdutoModel();
        $this->categoriaModel = new \App\Models\CategoriaModel();

        $this->extraModel = new \App\Models\ExtraModel();
        $this->produtoExtraModel = new \App\Models\ProdutoExtraModel();
    }

    public function index()
    {
        $data = [
            'titulo' => 'Listando os produtos',
            'produtos' => $this->produtoModel->select('produtos.*, categorias.nome AS categoria')
                                            ->join('categorias', 'categorias.id = produtos.categoria_id')
                                            ->withDeleted(true)->paginate(10),
            'pager' => $this->produtoModel->pager,
        ];

        return view('Admin/Produtos/index', $data);
    }

    public function procurar()
    {
        if (!$this->request->isAjax()) 
        {
            exit('Página não encontrada');
        }

        $produtos = $this->produtoModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach ($produtos as $produto) {
            $data['id'] = $produto->id;
            $data['value'] = $produto->nome;

            $retorno[] = $data;
        }
        
        return $this->response->setJson($retorno);
    }

    public function criar($id = null)
    {
        $produto = new Produto();

        $data = [
            'titulo'     => "Cadastrando o produto",
            'produto' => $produto,
            'categorias' => $this->categoriaModel->where('ativo', true)->findAll(),
        ];

        return view('Admin/Produtos/criar', $data);
    }

    public function cadastrar($id = null)
    {
        if ($this->request->getMethod() === 'post') {
            $produto = new Produto($this->request->getPost());

            if ($this->produtoModel->save($produto)) {
                return redirect()->to(site_url("admin/produtos/show/" . $this->produtoModel->getInsertID()))
                                ->with('sucesso', "Produto $produto->nome cadastrado com sucesso!");
            } else {
                return redirect()->back()->with('errors_model', $this->produtoModel->errors())
                                        ->with('atencao', "Por favor, verifique os erros abaixo.")
                                        ->withInput();
            }

        } else {
            /* Não é POST */
            return redirect()->back();
        }
    }

    public function show($id = null)
    {
        $produto = $this->buscaProdutoOu404($id);

        $data = [
            'titulo'     => "Detalhando o produto $produto->nome",
            'produto' => $produto,
        ];

        return view('Admin/Produtos/show', $data);
    }

    public function editar($id = null)
    {
        $produto = $this->buscaProdutoOu404($id);

        if ($produto->deletado_em != null) {
            return redirect()->back()->with('info', "O produto $produto->nome encontra-se excluído. Portanto, não é possível editá-lo.");
        }
        
        $data = [
            'titulo'     => "Editando o extra $produto->nome",
            'produto' => $produto,
            'categorias' => $this->categoriaModel->where('ativo', true)->findAll(),
        ];

        return view('Admin/Produtos/editar', $data);
    }

    public function atualizar($id = null)
    {
        if ($this->request->getMethod() === 'post') {
            $produto = $this->buscaProdutoOu404($id);

            if ($produto->deletado_em != null) {
                return redirect()->back()->with('info', "O produto $produto->nome encontra-se excluído. Portanto, não é possível editá-lo.");
            }

        } else {
            /* Não é POST */
            return redirect()->back();
        }

        $produto->fill($this->request->getPost());
        
        if (!$produto->hasChanged()) {
            return redirect()->back()->with('info', "Não há dados para atualizar.");
        }
        
        if ($this->produtoModel->save($produto)) {
            return redirect()->to(site_url("admin/produtos/show/$produto->id"))
                            ->with('sucesso', "Extra $produto->nome atualizado com sucesso!");
        } else {
            /* Erro de validação */
            return redirect()->back()->with('errors_model', $this->produtoModel->errors())
                                    ->with('atencao', "Por favor, verifique os erros abaixo.")
                                    ->withInput();
        }
    }

    public function editarImagem($id = null) 
    {
        $produto = $this->buscaProdutoOu404($id);

        $data = [
            'titulo'     => "Editando a imagem do produto $produto->nome",
            'produto' => $produto,
        ];

        return view('Admin/Produtos/editar_imagem', $data);
    }

    public function upload($id = null) 
    {
        $produto = $this->buscaProdutoOu404($id);

        $imagem = $this->request->getFile('foto_produto');

        if (!$imagem->isValid()) {
            $codigoError = $imagem->getError();

            if ($codigoError == UPLOAD_ERR_NO_FILE) {
                return redirect()->back()->with('atencao', 'Nenhum arquivo foi selecionado.');
            }
        }


        $tamanhoImagen = $imagem->getSizeByUnit('mb');

        if ($tamanhoImagen > 2) {
            return redirect()->back()->with('atencao', 'O arquivo selecionado é muito grande. Máximo permitido é: 2MB.');
        }

        $tipoImagem = $imagem->getMimeType();
        $tipoImagemLimpo = explode('/', $tipoImagem);

        $tiposPermitidos = [
            'jpg', 'png', 'webp',
        ];
        
        if (!in_array($tipoImagemLimpo[1], $tiposPermitidos)) {
            return redirect()->back()->with('atencao', 'O arquivo não tem o formato permitido. Apenas: ' . implode(', ', $tiposPermitidos));
        }

        list($largura, $altura) = getimagesize($imagem->getPathName());

        if ($largura < "400" || $altura < "400") {
            return redirect()->back()->with('atencao', 'A imagem não pode ser menor do que 400 x 400 pixels.');
        }

        // --------------- A partir desse ponto fazemos o store da imagem. ------------- //

        /* Fazendo o store da imagem e recuperando o caminho da mesma. */
        $imagemCaminho = $imagem->store('produtos');

        $imagemCaminho = WRITEPATH . 'uploads/' . $imagemCaminho;

        /* Fazendo o resize da mesma imagem */
        service('image')
                ->withFile($imagemCaminho)
                ->fit(400, 400, 'center')
                ->save($imagemCaminho);

        /* Recuperando a imagem antiga para excluí-la. */
        $imagemAntiga = $produto->imagem;
        
        /* Atribuindo a nova imagem. */
        $produto->imagem = $imagem->getName();
        
        /* Atualizando a imagem do produto. */
        $this->produtoModel->save($produto);

        /* Definindo o caminho da imagem antiga. */
        $caminhoImagem = WRITEPATH . 'uploads/produtos/' . $imagemAntiga;
        
        if (is_file($caminhoImagem)) {
            unlink($caminhoImagem);
        }

        return redirect()->to(site_url("admin/produtos/show/$produto->id"))->with('sucesso', 'Imagem alterada com sucesso!');
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

    public function extras($id = null)
    {
        $produto = $this->buscaProdutoOu404($id);

        $data = [
            'titulo'     => "Gerenciar os extras do produto $produto->nome",
            'produto' => $produto,
            'extras' => $this->extraModel->where('ativo', true)->findAll(),
            'produtosExtras' => $this->produtoExtraModel->buscaExtrasDoProduto($produto->id),
        ];
        // dd($data);
        return view('Admin/Produtos/extras', $data);
    }

    public function excluir($id = null)
    {
        $produto = $this->buscaProdutoOu404($id);

        if ($produto->deletado_em != null) {
            return redirect()->back()->with('info', "O produto $produto->nome já encontra-se excluído!");
        }

        if ($this->request->getMethod() === 'post') {
            $this->produtoModel->delete($id);
            return redirect()->to(site_url('admin/produtos'))
                            ->with('sucesso', "Produto $produto->nome excluído com sucesso.");
        }

        $data = [
            'titulo'     => "Excluindo o produto $produto->nome",
            'produto' => $produto,
        ];

        return view('Admin/Produtos/excluir', $data);
    }

    public function desfazerExclusao($id = null)
    {
        $produto = $this->buscaProdutoOu404($id);
        
        if ($produto->deletado_em == null) {
            return redirect()->back()->with('info', "Apenas produtos excluídos podem ser recuperados.");
        }

        if ($this->produtoModel->desfazerExclusao($id)) {
            return redirect()->back()->with('sucesso', "Exclusão desfeita com sucesso!");
        } else {
            return redirect()->back()->with('errors_model', $this->produtoModel->errors())
                                    ->with('atencao', "Por favor verifique os erros abaixo.")
                                    ->withInput();
        }
    }

    /**
     * @param int $id
     * @return objeto produto
     */
    private function buscaProdutoOu404($id = null)
    {
        if (!$id || !$produto = $this->produtoModel->select('produtos.*, categorias.nome AS categoria')
                                    ->join('categorias', 'categorias.id = produtos.categoria_id')
                                    ->where('produtos.id', $id)
                                    ->withDeleted(true)->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o produto $id");
        }
        
        return $produto;
    }
}
