<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Pedido extends Entity
{
    protected $dates   = [
        'criado_em', 
        'atualizado_em', 
        'deletado_em'
    ];

    public function exibeSituacaoDoPedido() {

        switch ($this->situacao) {
            case 0:
                echo "<i class='fa fa-thumbs-up fa-lg text-primary' aria-hidden='true'></i>&nbsp;Pedido realizado";
                break;
            case 1:
                echo "<i class='fa fa-motorcycle fa-lg text-success' aria-hidden='true'></i>&nbsp;Saiu para a entrega";
                break;
            case 2:
                echo "<i class='fa fa-money fa-lg text-success' aria-hidden='true'></i>&nbsp;Pedido entregue";
                break;
            case 3:
                echo "<i class='fa fa-thumbs-down fa-lg text-danger' aria-hidden='true'></i>&nbsp;Pedido cancelado";
                break;
        }
    }
}
