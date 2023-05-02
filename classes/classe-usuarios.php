<?php

    Class Usuario
    {   
        private $pdo;
        public $msgErro = "";

        
        //VAI FAZER A CONEXAO COM O BANCO
        public function conectar($nome, $host, $usuario, $senha)
        {
            global $pdo;
            global $msgErro;

            try 
            {
                $pdo = new PDO("mysql:dbname=".$nome.";host=".$host,$usuario,$senha);
            }
            catch (PDOException $e) 
            {               
                $msgErro = $e->getMessage();
            }
        }
        

        //VAI ENVIAR AS INFORMACOES PARA O BANCO
        public function cadastrar($nome, $telefone, $email, $senha)
        {
            global $pdo;

            //VERIFICA SE JE EXISTE UM EMAIL CADASTRADO

            $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e");
            $sql->bindValue(":e", $email);
            $sql->execute();          
            
            if($sql->rowCount() > 0) //rowCount conta as linhas que vieram do banco. 
            {
                return false; // ja esta cadastrado
            }
            else
            {
                //SE NAO ESTIVER CADASTRADO
                
                $sql = $pdo->prepare("INSERT INTO usuarios (nome, telefone, email, senha) VALUES (:n, :t, :e, :s)");
                $sql->bindValue(":n", $nome);
                $sql->bindValue(":t", $telefone);
                $sql->bindValue(":e", $email);
                $sql->bindValue(":s", md5($senha));
                $sql->execute();         
                return true; //tudo ok
            }            
        }

        
        //VAI VERIFICAR SE A PESSOA ESTÁ CADASTRADA
        public function logar($email, $senha)
        {
            global $pdo;

            //verifica se o email e senha estao cadastrados
            $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e AND senha = :s");
            $sql->bindValue(":e", $email);
            $sql->bindValue(":s", md5($senha));
            $sql->execute(); 


            // se estiver cadastrado, entrar no sistema
            if ($sql->rowCount() > 0)
            {
                $dado = $sql->fetch();
                session_start();
                $_SESSION['id_usuario'] = $dado['id_usuario'];
                return true; //logado com sucesso
            }
            else
            {
                return false; // nao foi possivel logar
            }

        }
    }

?>