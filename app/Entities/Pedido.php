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

    public function exibeSituacaoPedido() {

        switch ($this->situacao) {
            case 0:
                echo "<i class='fa fa-thumbs-up' text-primary aria-hidden='true'></i>&nbsp; Pedido realizado.";
                break;
            case 1:
                echo "<i class='fa fa-motorcycle' text-success aria-hidden='true'>&nbsp; Saiu para a entrega.</i>";
                break;
            case 2:
                echo "<i class='fa fa-money' text-success aria-hidden='true'></i>&nbsp; Pedido entregue.";
                break;
            case 3:
                echo "<i class='fa fa-thumbs-down' text-danger aria-hidden='true'></i>&nbsp; Pedido cancelado.";
                break;
        }
    }
}
