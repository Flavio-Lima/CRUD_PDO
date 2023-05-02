<?php

    Class Pessoa{

        private $pdo;

        //CONEXAO COM O BANCO DE DADOS
        public function __construct($dbname,$host, $user, $senha)
        {
            try
            {
                $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user, $senha);
            }
            catch(PDOException $e)
            {
                echo "Erro com banco de dados: ".$e->getMessage();
                exit();
            }
            catch(Exception $e){
                echo "Erro genérico: ".$e->getMessage();
                exit();
            }
        }

        //FUNCAO PARA BUSCAR DADOS E EXINIR PESSOAS NA TABELA DO CANTO DIREITO 
        public function buscarDados()
        {
            $res = array();

            $cmd = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");

            $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
            
            return $res;
        }

        //FUNCAO PARA CADASTARAR PESSOAS NO BANCO
        public function cadastrarPessoa($nome, $telefone, $email)
        {
            
            //ANTES DE CADASTRAR, VERIFICAR SE O EMAIL JÁ FOI CADASTRADO
            $cmd = $this->pdo->prepare("SELECT id from pessoa WHERE email = :e");
            $cmd->bindValue(":e", $email);
            $cmd->execute();

            if($cmd->rowCount() > 0) // verifica se o email já existe no banco
            {
                return false;
            }
            else //nao foi encontrado o email
            {
                $cmd = $this->pdo->prepare("INSERT INTO pessoa(nome, telefone, email) VALUES (:n, :t, :e)");

                $cmd->bindValue(":n", $nome);
                $cmd->bindValue(":t", $telefone);
                $cmd->bindValue(":e", $email);
                $cmd->execute();

                return true;
            }
        }

        //FUNCAO PARA EXCLUIR PESSOAS DO BANCO
        public function excluirPessoa($id)
        {
            $cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");

            $cmd->bindValue(":id", $id);
            $cmd->execute();
        }

        //BUSCAR DADOS DE UMA PESSOA 
        public function buscarDadosPessoa($id)
        {
            $res = array();
            $cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
            $cmd->bindValue(":id", $id);
            $cmd->execute();
            $res = $cmd->fetch(PDO::FETCH_ASSOC); //fetch pois vou receber os dados de apenas uma pessoa 
            return $res;
        }


        //ATUALIZAR OS DADOS NO BANCO 
        public function atualizarDados($id, $nome, $telefone, $email)
        {
            
            $cmd = $this->pdo->prepare("UPDATE pessoa SET nome = :n, telefone = :t, email = :e WHERE id = :id");

            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":t", $telefone);
            $cmd->bindValue(":e", $email);
            $cmd->bindValue(":id", $id);
            $cmd->execute();
            
            
        }
    }

?>