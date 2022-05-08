<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Categorias extends BaseController
{
    private $categoriaModel;

    public function __construct() {
        $this->categoriaModel = new \App\Models\CategoriaModel();
    }

    public function index()
    {
        $data = [
            'titulo'     => 'Listando as categorias',
            'categorias' => $this->categoriaModel->withDeleted(true)->paginate(10),
            'pager'      => $this->categoriaModel->pager,
        ];

        return view('Admin/Categorias/index', $data);
    }

    public function procurar()
    {
        if (!$this->request->isAjax()) 
        {
            exit('Página não encontrada');
        }

        $categorias = $this->categoriaModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach ($categorias as $categoria) {
            $data['id'] = $categoria->id;
            $data['value'] = $categoria->nome;

            $retorno[] = $data;
        }
        
        return $this->response->setJson($retorno);
    }

    public function show($id = null)
    {
        $categoria = $this->buscaCategoriaOu404($id);

        $data = [
            'titulo'     => "Detalhando a categoria $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/Categorias/show', $data);
    }

    public function editar($id = null)
    {
        $categoria = $this->buscaCategoriaOu404($id);

        if ($categoria->deletado_em != null) {
            return redirect()->back()->with('info', "A categoria $categoria->nome encontra-se excluído. Portanto, não é possível editá-la.");
        }
        
        $data = [
            'titulo'     => "Editando a categoria $categoria->nome",
            'categoria' => $categoria,
        ];

        return view('Admin/Categorias/editar', $data);
    }

    /**
     * @param int $id
     * @return objeto categoria
     */
    private function buscaCategoriaOu404($id = null)
    {
        if (!$id || !$categoria = $this->categoriaModel->withDeleted(true)->where('id', $id)->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos a categoria $id");
        }
        
        return $categoria;
    }

}
