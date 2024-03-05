<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET, POST, PUT");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $method = $_SERVER["REQUEST_METHOD"];
    include("../connection/connection.php");
    //include("../valida_token.php");

    if($method == "GET"){
        //echo "GET";

        if(!empty($_GET["email"]) && !empty($_GET["senha"])){

            $email = trim($GET["email"]);
            $senha = trim($GET["senha"]);

            try{
                $sql = "
                SELECT pk_id, nome
                FROM clientes
                WHERE email LIKE :email
                AND senha LIKE :senha
                ";

                $stmt = $conn->prepare($sql);
                $stmt = bindparam(":email",$email);
                $stmt = bindparam(":nome",$nome);
                $stmt = bindparam(":cpf",$cpf);
                $stmt = bindparam(":whatsapp",$whatsapp);
                $stmt = bindparam(":senha",$senha);
                $stmt = execute();

                $dados = $stmt->fetch(PDO::FETCH_OBJ);

                $result["cliente"]=$dados;
                $result["status"]="success";

                http_response_code(200);


            }catch (PDOException $ex) {
                // echo "error: ". $ex->getMEssage();
                $result =["status"=> "fail", "error"=> $ex->getMEssage()];
                http_response_code(200);
            }finally{
                $conn = null;
                echo json_encode($result);
            }
        }

        else if (!isset($_GET["id"])){

            // listar todos os registros
            try {
                
                $sql = "SELECT pk_id, nome, email, cpf, whatsapp, habilita 
                        FROM clientes";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $dados = $stmt->fetchall(PDO::FETCH_OBJ);

                $result["clientes"]=$dados;
                $result["status"] = "success";

                http_response_code(200);

            } catch (PDOException $ex) {
                // echo "error: ". $ex->getMEssage();
                $result =["status"=> "fail", "error"=> $ex->getMEssage()];
                http_response_code(200);
            }finally{
                $conn = null;
                echo json_encode($result);
            }
        }else{
            // listar um registro
            try{

                if(empty($_GET["id"]) || !is_numeric($_GET["id"])){
                    // está vazio ou não é numérico : ERRO
                    throw new ErrorException("Valor inválido", 1);
                }
                $id = $_GET["id"];

                $sql = "SELECT pk_id, nome, email, cpf, whatsapp, habilita 
                        FROM clientes
                        WHERE pk_id=:id";
                
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();

                $dado = $stmt->fetch(PDO::FETCH_OBJ);
                $result['clientes'] = $dado;
                $result["status"] = "success";

            }catch(PDOException $ex){
                $result =["status"=> "fail", "error"=> $ex->getMEssage()];
                http_response_code(200);
            }catch(Exception $ex){
                $result =["status"=> "fail", "error"=> $ex->getMEssage()];
                http_response_code(200);
            }finally{
                $conn = null;
                echo json_encode($result);
            }
            
        }

       
    }
    if($method=="POST"){
       
        // recupera dados do corpo (body) de uma requisão POST
        $dados = file_get_contents("php://input");

        // decodifica JSON, sem opção TRUE
        $dados = json_decode($dados); // isso retorna um OBJETO

        // função trim retira espaços que estão sobrando
        $nome = trim($dados->nome); // acessa valor de um OBJETO
        $cpf = trim($dados->cpf); // acessa valor de um OBJETO
        $email = trim($dados->email); // acessa valor de um OBJETO
        $whatsapp = trim($dados->whatsapp); // acessa valor de um OBJETO
        $senha = hash("sha256", trim($dados->senha)); // acessa valor de um OBJETO

        try {
            if(empty($email) ){
                // está vazio  : ERRO
                throw new ErrorException("E_mail inválido", 1);
            }else if(empty($cpf)){
            throw new ErrorException("CPF inválido", 1);
            }   



            $sql = "INSERT INTO clientes (nome, cpf, whatsapp, email, senha) 
                    VALUES (:nome, :cpf, :whatsapp, :email,  :senha)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":cpf", $cpf);
            $stmt->bindParam(":whatsapp", $whatsapp);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":senha", $senha);
            $stmt->execute();

            $result = array("status"=>"success");

        } catch (PDOException $ex) {
            $err = $ex->errorInfo[1];
            if($err == 1062){
            $result =["status"=> "fail", "error"=> "Não permitido: E-mail ou CPF duplicado"];
        }else{
            $result =["status"=> "fail", "error"=> $ex->getMEssage()];
        }
            http_response_code(200);
        }catch(Exception $ex){
            $result =["status"=> "fail", "error"=> $ex->getMEssage()];
            http_response_code(200);
        }finally{
            $conn = null;
            echo json_encode($result);
        }



    }
    if($method=="PUT"){
        // recupera dados do corpo (body) de uma requisão POST
        $dados = file_get_contents("php://input");

        // decodifica JSON, sem opção TRUE
        $dados = json_decode($dados); // isso retorna um OBJETO

        // função trim retira espaços que estão sobrando
         $email = trim($dados->email); // acessa valor de um OBJETO
         $nome = trim($dados->nome); // acessa valor de um OBJETO
         $cpf = trim($dados->cpf); // acessa valor de um OBJETO
         $whatsapp = trim($dados->whatsapp); // acessa valor de um OBJETO
         $senha = trim($dados->senha); // acessa valor de um OBJETO
         $habilita = trim($dados->habilita); // acessa valor de um OBJETO
         $id = trim($dados->id); // acessa valor de um OBJETO
       
        try {
            if(empty($email) ){
                // está vazio  : ERRO
                throw new ErrorException("E-mail inválido", 1);
            }
            
            if (!empty($senha)){
                $sql = "UPDATE clientes SET nome=:nome, cpf=:cpf, whatsapp=:whatsapp, email=:email, senha=:senha
                        WHERE pk_id=:id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":nome", $nome);
                $stmt->bindParam(":senha", $senha);
                $stmt->bindParam(":id", $id);

            }else{
                $sql = "UPDATE clientes SET nome=:nome, cpf=:cpf, whatsapp=:whatsapp, email=:email
                        WHERE pk_id=:id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":nome", $nome);
                $stmt->bindParam(":cpf", $cpf);
                $stmt->bindParam(":whatsapp", $whatsapp);
                $stmt->bindParam(":email", $email);

                $stmt->bindParam(":id", $id);
            }
            
            $stmt->execute();

            $result = array("status"=>"success");

        } catch (PDOException $ex) {
            $result =["status"=> "fail", "error"=> $ex->getMEssage()];
            http_response_code(200);
        }catch(Exception $ex){
            $result =["status"=> "fail", "error"=> $ex->getMEssage()];
            http_response_code(200);
        }finally{
            $conn = null;
            echo json_encode($result);
        }

    }

    if($method=="DELETE"){
        try{

            if(empty($_GET["id"]) || !is_numeric($_GET["id"])){
                // está vazio ou não é numérico : ERRO
                throw new ErrorException("Valor inválido", 1);
            }
            $id = $_GET["id"];

            $sql= "DELETE FROM clientes 
                    WHERE pk_id=:id";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            
            $result["status"] = "success";

        }catch(PDOException $ex){
            $result =["status"=> "fail", "error"=> $ex->getMEssage()];
            http_response_code(200);
        }catch(Exception $ex){
            $result =["status"=> "fail", "error"=> $ex->getMEssage()];
            http_response_code(200);
        }finally{
            $conn = null;
            echo json_encode($result);
        }
     
    }







?>




