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
    <title>Sistema</title>
    <link rel="stylesheet" href="styles/index.css">
</head>

<body>
    <section class="login">
        <h1 class="titulo">Entrar</h1>
        <div class="form_wrapper">
            <form class="form_login" method="POST">
                <input type="email" name="email" id="" placeholder="Usuário" />
                <input type="password" name="senha" id="" placeholder="Senha" />
                <input class="btn" type="submit" value="ACESSAR" />
            </form>
        </div>

        <a class="cadastre-se" href="cadastrar.php">Ainda não é inscrito? <strong>Cadastre-se!</strong></a>

        <?php 
    
        if(isset($_POST['email']))
        {
            $email = addslashes($_POST['email']);
            $senha = addslashes($_POST['senha']);
            
            //verificar se esta preenchido
            if(!empty($email) && !empty($senha))
            {
                $u->conectar("crudpdo","localhost","root","");

                if($u->msgErro == "") // se estiver vazia, está tudo ok
                {
                    if($u->logar($email, $senha))
                    {
                        header("location: painelAdmin.php");
                    }
                    else
                    {
                        ?>
        <div class="msg-erro">
            <h4>E-mail e\ou senha estão incorretos!</h4>
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
            <h4>Preencha todos os campos!</h4>
        </div>
        <?php
                
            }
        }
        

    ?>
    </section>



</body>

</html>