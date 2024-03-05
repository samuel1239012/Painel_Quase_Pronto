<?php

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $method = $_SERVER["REQUEST_METHOD"];
    include("../connection/connection.php");
    include("../valida_token.php");

    if($method == "GET"){
        //echo "GET";

        if (!isset($_GET["id"])){

            // listar todos os registros
            try {
                
                $sql = "SELECT pk_id, fk_noticia, fk_redacao
                        FROM destaque_home";
                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $dados = $stmt->fetchall(PDO::FETCH_OBJ);

                $result["destaque_home"]=$dados;
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

                $sql= "SELECT pk_id, fk_noticia, fk_redacao
                        FROM destaque_home
                        WHERE pk_id=:id";
                
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();

                $dado = $stmt->fetch(PDO::FETCH_OBJ);
                $result['destaque_home'] = $dado;
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
        $destaque_home = trim($dados->destaque_home); // acessa valor de um OBJETO

        try {
            if(empty($destaque_home) ){
                // está vazio  : ERRO
                throw new ErrorException("Valor inválido", 1);
            }
            
            $sql = "INSERT INTO destaque_home(fk_noticia, fk_redacao) 
                    VALUES (:fk_noticia, :fk_redacao)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":destaque_home", $destaque_home);
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
    if($method=="PUT"){
        echo "PUT";
    }
    if($method=="DELETE"){
        echo "DELETE";
    }







?>