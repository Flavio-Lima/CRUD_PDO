<?php
    session_start();
    if(!isset($_SESSION['id_usuario']))
    {
        header("location: index.php");
        exit;
    }

    require_once './classes/classe-pessoa.php';
    $p = new Pessoa("crudpdo","localhost","root", ""); // p: objeto da classe pessoa
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin</title>
    <link rel="stylesheet" href="styles/painelAdmin.css">

</head>

<body>

    <?php
        if(isset($_POST['nome'])) // CLICOU NO BOTAO CADASTRAR OU EDITAR
        {

            if(isset($_GET['id_up']) && !empty($_GET['id_up'])) // BOTAO EDITAR
            {
                
                $id_udp = addslashes($_GET['id_up']);
                $nome = addslashes($_POST['nome']);
                $telefone = addslashes($_POST['telefone']);
                $email = addslashes($_POST['email']);
                
                if(!empty($nome) && !empty($telefone) && !empty($email))
                {
                    //ATUALIZAR
                    !$p->atualizarDados($id_udp, $nome, $telefone, $email);
                    header("location: painelAdmin.php");
                }
                else
                {
                    
                        ?>
    <div class="aviso">
        <img src="images/aviso.png" alt="Exclamação de aviso" />
        <h4>Preencha todos os campos!</h4>
    </div>
    <?php
                    
                }


            }
            else //BOTAO CADASTRAR
            {
                $nome = addslashes($_POST['nome']);
                $telefone = addslashes($_POST['telefone']);
                $email = addslashes($_POST['email']);
                
                if(!empty($nome) && !empty($telefone) && !empty($email)){
                    //CADASTRAR
                    if(!$p->cadastrarPessoa($nome, $telefone, $email))
                    {
            
                        ?>
    <div class="aviso">
        <img src="images/aviso.png" alt="Exclamação de aviso" />
        <h4>Email já está cadastrado!</h4>
    </div>
    <?php
                    }
                }
                else
                {
                    ?>
    <div class="aviso">
        <img src="images/aviso.png" alt="Exclamação de aviso" />
        <h4>Preencha todos os campos!</h4>
    </div>
    <?php
                }
            }
        }
    ?>

    <?php
        if(isset($_GET['id_up'])) //VERIFICA SE A PESSOA CLICOU NO BOTAO EDITAR
        {
            $id_update = addslashes($_GET['id_up']);
            $res = $p->buscarDadosPessoa($id_update);
        }
    
    ?>

    <section class="left">
        <form method="POST">
            <h2>CADASTRAR PESSOA</h2>

            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" value="<?php if(isset($res)){echo $res['nome'];} ?>" />

            <label for="telefone">Telefone</label>
            <input type="tel" name="telefone" id="telefone" value="<?php if(isset($res)){echo $res['telefone'];} ?>" />

            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" value="<?php if(isset($res)){echo $res['email'];} ?>" />

            <input type="submit" value="<?php if(isset($res)){ echo "Atualizar";} else{echo "Cadastrar";} ?> " />

        </form>
    </section>

    <section class="right">
        <table>
            <tr class="title">
                <td>NOME</td>
                <td>TELEFONE</td>
                <td colspan="2">EMAIL</td>
            </tr>

            <?php
                $dados = $p->buscarDados();

                if(count($dados) > 0) // se tem pesssoas cadastradas no banco, faz a busca dos dados.
                {
                    for ($i=0; $i < count($dados); $i++) 
                    { 
                        echo "<tr>";                        
                            foreach ($dados[$i] as $k => $v) //v vai armazenar todas as informacoes de nome, email, teledone
                            {
                                if($k != "id")
                                {
                                    echo "<td>".$v."</td>";
                                }                    
                            }

            ?>

            <td>
                <a href="painelAdmin.php?id_up=<?php echo $dados[$i]['id'] ?>">Editar</a>
                <a href="painelAdmin.php?id=<?php echo $dados[$i]['id'] ?>">Excluir</a>
            </td>
            <?php

                        echo "</tr>";
                    }
                    
                }
                else //o banco está vazio.
                {   
                    ?>
        </table>

        <div class="aviso-cadastro">
            <h4>Ainda não há pessoas cadastradas!</h4>
        </div>

        <?php
                }
                         ?>
        <a class="btn-sair" href="sair.php">Sair</a>
    </section>
</body>

</html>

<?php
    if(isset($_GET['id']))
    {
        $id_pessoa = addslashes($_GET['id']);
        $p->excluirPessoa($id_pessoa);
        header("location: painelAdmin.php");
    }

?>