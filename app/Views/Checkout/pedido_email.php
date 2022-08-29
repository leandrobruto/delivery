<h1>Pedido <?php echo esc($pedido->codigo); ?> realizado com sucesso!</h1>

<p>Olá, <strong><?php echo esc($pedido->usuario->nome); ?></strong>, recebemo o seu perdido: <strong><?php echo esc($pedido->codigo); ?></strong></p>

<p>Estamo acelerando do lado de cá para que o seu pedido fique pronto rapidinho. Logo logo ele sairá para a entrega.</p>

<p>Não se preocupe, quando isso acontecer, avisaremos você por e-mail, beleza?</p>

<p>
    Enquanto isso, <a href="<?php echo site_url('conta') ?>">Clique aqui para ver os seus perdidos.</a>
</p>