<?php
    require_once 'classes/classe-usuarios.php';
    $u = new Usuario;
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="styles/index.css">
</head>

<body>
    <section class="login">
        <h1 class="titulo">Cadastrar</h1>
        <div class="teste">
            <form class="form_login" method="POST" />
            <input type="text" name="nome" placeholder="Nome Completo" maxlength="30" />
            <input type="tel" name="telefone" id="" placeholder="Telefone" maxlength="15" />
            <input type="email" name="email" id="" placeholder="E-mail" maxlength="40" />
            <input type="password" name="senha" id="" placeholder="Senha" maxlength="15" />
            <input type="password" name="confSenha" id="" placeholder="Confirmar Senha" maxlength="15" />
            <input class="btn" type="submit" value="CADASTRAR">
            </form>
        </div>
        <a class="voltar" href="index.php"> Voltar</a>

        <?php
            //verificar se a pessoa clicou no botao
            if(isset($_POST['nome']))
            {
                $nome = addslashes($_POST['nome']);
                $telefone = addslashes($_POST['telefone']);
                $email = addslashes($_POST['email']);
                $senha = addslashes($_POST['senha']);
                $confirmarSenha = addslashes($_POST['confSenha']);
                
                //verificar se esta preenchido
                if(!empty($nome) && !empty($telefone) && !empty($telefone) && !empty($email) && !empty($senha) && !empty($confirmarSenha))
                {
                    $u->conectar("crudpdo","localhost","root","");
                    if($u->msgErro == "") // se estiver vazia, está tudo ok
                    {
                        if($senha == $confirmarSenha)
                        {
                            if($u->cadastrar($nome,$telefone,$email,$senha))
                            {
                                ?>
        <div class="msg_sucesso">
            <h4>Cadastrado com sucesso! acesse para entrar!</h4>
        </div>
        <?php
                            }
                            else
                            {   
                                ?>
        <div class="msg-erro">
            <h4>Email já cadastrado!</h4>
        </div>
        <?php
                            }
                        }
                        else
                        {
                            ?>
        <div class="msg-erro">
            <h4>Senha e confirmar senha não correspondem!</h4>
        </div>
        <?php                            
                        }
                    }
                    else
                    {
                        ?>
        <div class="msg-erro">
            <h4><?php echo "Erro: ".$u->msgErro; ?></h4>
        </div>
        <?php                         
                        
                    }
                }
                else
                {
                    ?>
        <div class="msg-erro">
            <h4>Preencha todos os campos</h4>
        </div>
        <?php 

                }
            }
        ?>

    </section>
</body>

</html>