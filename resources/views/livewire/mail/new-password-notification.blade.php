<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <meta content="width=device-width" name="viewport" />
    <meta content="IE=edge" http-equiv="X-UA-Compatible" />
    <style>
        @media (max-width: 620px) {
            .block-grid,
            .col {
                min-width: 320px !important;
                max-width: 100% !important;
                display: block !important;
            }

            .block-grid {
                width: 100% !important;
            }

            .col {
                width: 100% !important;
            }

            .col > div {
                margin: 0 auto;
            }

            img.fullwidth,
            img.fullwidthOnMobile {
                max-width: 100% !important;
            }
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .header-footer {
            background-color: #1988cc;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            background-color: white;
            padding: 20px;
        }

        .button {
            background-color: #1988cc;
            color: white;
            padding: 12px 24px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .footer {
            background-color: #1988cc;
            color: white;
            text-align: left;
            padding: 10px;
            font-size: 12px;
        }

        .link {
            color: #1988cc;
            text-decoration: none;
        }

        .text-left {
            text-align: left;
        }

        .content p {
            font-size: 14px;
            line-height: 1.6;
            margin: 10px 0;
        }

        .separator {
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <table class="container" cellpadding="0" cellspacing="0" role="presentation">
        <tbody>
            <tr>
                <td>
                    <div class="header-footer">
                        <img src="{{ asset('assets/logo-branca-horizontal.png') }}" alt="Logo" style="max-width: 200px" />
                    </div>

                    <div class="content">
                        <div class="text-left">
                            <h1 style="font-size: 24px; margin-bottom: 15px">Redefinição de Senha</h1>
                            <p>Olá,</p>
                            <p>Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para a sua conta.</p>
                            <p>Clique no botão abaixo para redefinir sua senha:</p>
                        </div>

                        <div style="text-align: center; margin: 20px 0">
                            <a href="{{ $url }}" class="button">Redefinir Senha</a>
                        </div>

                        <div class="text-left">
                            <p>Se você não solicitou a redefinição de senha, nenhuma ação adicional será necessária.</p>
                            <p>Atenciosamente,</p>
                            <p>{{ config('app.name') }}</p>
                        </div>

                        <div class="separator"></div>

                        <div>
                            <p>Se tiver problemas com o botão "Redefinir senha", copie e cole a seguinte url no seu navegador:</p>
                            <p><a href="{{ $url }}" class="link">{{ $url }}</a></p>
                        </div>
                    </div>

                    <div class="footer">
                        <p
                            style="margin: 0"
                        >Esta é uma mensagem automática do Projeto Padrão. Você está recebendo esta mensagem porque uma solicitação de redefinição de senha foi feita para sua conta.</p>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
