<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Entregador;

class Entregadores extends BaseController
{
    private $entregadorModel;
    
    public function __construct()
    {
        $this->entregadorModel = new \App\Models\EntregadorModel();
    }

    public function index()
    {
        $data = [
            'titulo' => 'Listando os entregadores',
            'entregadores' => $this->entregadorModel->withDeleted(true)->paginate(10),
            'pager' => $this->entregadorModel->pager,
        ];

        return view('Admin/Entregadores/index', $data);
    }

    public function procurar()
    {
        if (!$this->request->isAjax()) 
        {
            exit('Página não encontrada');
        }

        $entregadores = $this->entregadorModel->procurar($this->request->getGet('term'));

        $retorno = [];

        foreach ($entregadores as $entregador) {
            $data['id'] = $entregador->id;
            $data['value'] = $entregador->nome;

            $retorno[] = $data;
        }
        
        return $this->response->setJson($retorno);
    }

    public function criar()
    {

        $entregador = new Entregador();

        $data = [
            'titulo'     => "Criando novo entregador",
            'entregador' => $entregador,
        ];
        
        return view('Admin/Entregadores/criar', $data);
    }

    public function cadastrar()
    {
        if ($this->request->getMethod() === 'post') {
            
            $entregador = new Usuario($this->request->getPost());
        
            if ($this->entregadorModel->protect(false)->save($entregador)) {
                return redirect()->to(site_url("admin/entregadores/show/" . $this->entregadorModel->getInsertID()))
                                ->with('success', "Entregador $entregador->nome cadastrado com sucesso!");
            } else {
                return redirect()->back()->with('errors_model', $this->entregadorModel->errors())
                                        ->with('atencao', "Por favor verifique os erros abaixo.")
                                        ->withInput();
            }

        } else {
            /* Não é POST */
            return redirect()->back();
        }

    }

    public function show($id = null)
    {
        $entregador = $this->buscaEntregadorOu404($id);

        $data = [
            'titulo'     => "Detalhando o entregador $entregador->nome",
            'entregador' => $entregador,
        ];

        return view('Admin/Entregadores/show', $data);
    }

    public function editar($id = null)
    {
        $entregador = $this->buscaEntregadorOu404($id);

        if ($entregador->deletado_em != null) {
            return redirect()->back()->with('info', "O entregador $entregador->nome encontra-se excluído. Portanto, não é possível editá-lo.");
        }
        
        $data = [
            'titulo'     => "Editando o entregador $entregador->nome",
            'entregador' => $entregador,
        ];

        return view('Admin/Entregadores/editar', $data);
    }

    public function atualizar($id = null)
    {
        if ($this->request->getMethod() === 'post') {
            $entregador = $this->buscaEntregadorOu404($id);

            if ($entregador->deletado_em != null) {
                return redirect()->back()->with('info', "O entregador $entregador->nome encontra-se excluído. Portanto, não é possível editá-lo.");
            }

        } else {
            /* Não é POST */
            return redirect()->back();
        }

        $post = $this->request->getPost();
        
        // if (empty($post['password'])) {
        //     $this->usuarioModel->desabilitaValidacaoSenha();
        //     unset($post['password']);
        //     unset($post['password_confirmation']);
        // }

        $entregador->fill($post);
        
        if (!$entregador->hasChanged()) {
            return redirect()->back()->with('info', "Não há dados para atualizar.");
        }
        
        if ($this->entregadorModel->protect(false)->save($entregador)) {
            return redirect()->to(site_url("admin/entregadores/show/$entregador->id"))
                            ->with('sucesso', "Entregador $entregador->nome atualizado com sucesso!");
        } else {
            return redirect()->back()->with('errors_model', $this->entregadorModel->errors())
                                    ->with('atencao', "Por favor, verifique os erros abaixo.")
                                    ->withInput();
        }
    }

    public function excluir($id = null)
    {
        $entregador = $this->buscaEntregadorOu404($id);

        if ($entregador->deletado_em != null) {
            return redirect()->back()->with('info', "O entregador $entregador->nome já encontra-se excluído!");
        }

        // if ($usuario->is_admin) {
        //     return redirect()->back()->with('info', "Não é possível excluir um Usuário <b>Administrador</b>.");
        // }

        if ($this->request->getMethod() === 'post') {
            $this->entregadorModel->delete($id);
            return redirect()->to(site_url('admin/entregadores'))
                            ->with('sucesso', "Entregador $entregador->nome excluído com sucesso.");
        }

        $data = [
            'titulo'     => "Excluindo o entregador $entregador->nome",
            'entregador' => $entregador,
        ];

        return view('Admin/Entregador/excluir', $data);
    }

    public function desfazerExclusao($id = null)
    {
        $entregador = $this->buscaEntregadorOu404($id);
        
        if ($entregador->deletado_em == null) {
            return redirect()->back()->with('info', "Apenas entregadores excluídos podem ser recuperados.");
        }

        if ($this->entregadorModel->desfazerExclusao($id)) {
            return redirect()->back()->with('sucesso', "Exclusão desfeita com sucesso!");
        } else {
            return redirect()->back()->with('errors_model', $this->entregadorModel->errors())
                                    ->with('atencao', "Por favor verifique os erros abaixo.")
                                    ->withInput();
        }
    }

    /**
     * @param int $id
     * @return objeto entregador
     */
    private function buscaEntregadorOu404($id = null)
    {
        if (!$id || !$entregador = $this->entregadorModel->withDeleted(true)->where('id', $id)->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o entregador $id");
        }
        
        return $entregador;
    }
}
