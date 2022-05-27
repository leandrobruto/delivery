<?php echo $this->extend('layout/base_email'); ?>

<!-- Aqui enviamos para o template principal o conteúdo -->
<?php echo $this->section('conteudo'); ?>

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;">
    <tbody>
    <tr>
        <td align="center" valign="top" class="section-heading" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;padding-bottom:15px;">
        <h5 style="color:#9B9B9B;font-size:11px;margin:0;padding:0;text-transform:uppercase;">Feature</h5>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" class="content-item" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;padding-bottom:25px;">
        <h1 style="color:#4A4A4A;font-size:18px;letter-spacing:-.7px;line-height:29px;margin:0;padding:0;">
            <span class="highlighted-text" style="color: #000">Olá, Ademiro!</span>
        </h1>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" class="content-item" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;padding-bottom:25px;">
        <!-- // Example block // -->
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;border-collapse:collapse;mso-table-lspace:0pt;mso-table-rspace:0pt;">
            <tbody>
            <tr>
                <td align="left" valign="top" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;">
                <img src="https://link-to-yet-another-hosted-image.png" alt="verification changes" class="is-fittogrid" style="-ms-interpolation-mode: bicubic; border: 0; display: block; max-width: 100%; outline: none; text-decoration: none; width: auto">
                </td>
            </tr>
            </tbody>
        </table>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" class="content-item" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;mso-table-lspace:0pt;mso-table-rspace:0pt;padding-bottom:25px;">
        <p style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;margin:0;">
        Clique no botão abaixo para redefinir a sua senha.</td>
    </tr>
    </tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" align="center" class="btn" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;border-collapse:separate;mso-table-lspace:0pt;mso-table-rspace:0pt;">
    <tbody>
    <tr>
        <td align="center" valign="middle" class="btn-content" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;background:#23179F;border:2px solid white;border-radius:30px;color:#fff;mso-table-lspace:0pt;mso-table-rspace:0pt;padding:4px 20px;" bgcolor="#A2F4DF">
        <a href="<?php echo site_url('password/reset/' . $token) ?>" target="_blank" style="-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;color:white !important;display:block;font-family:Arial, sans-serif;font-size:13px;font-weight:bold;text-decoration:none;">Redefinir</a>
        </td>
    </tr>
    </tbody>
</table>

<?php echo $this->endSection(); ?>