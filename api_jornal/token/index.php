<?php
 
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
    $method = $_SERVER["REQUEST_METHOD"];
    include("../connection/connection.php");
 
    if($method == "GET"){
        //criar resposta para GET
 
       
 
    }
    if($method=="POST"){
       
        // recupera dados do corpo (body) de uma requisão POST
        $dados = file_get_contents("php://input");
 
        // decodifica JSON, sem opção TRUE
        $dados = json_decode($dados); // isso retorna um ARRAY
 
     
 
        // função trim retira espaços que estão sobrando
        // recupera valores do objeto e atribui as variaveis
 
     
        try {
            if(empty($dados->e_mail) || !isset($dados->e_mail) ){
                // teste: se variavel email esta vazia ou se nao vairável email não existe
 
                throw new ErrorException("E-mail inválido", 1);
            }
            if(empty($dados->cpf) || !isset($dados->cpf) ){
                // teste: se variavel cpf esta vazia ou se nao vairável cpf não existe
 
                throw new ErrorException("CPF inválido", 1);
            }
            if(!filter_var($dados->e_mail,FILTER_VALIDATE_EMAIL)){
                // teste: validaçaõ do email (formato)
                throw new ErrorException("E-mail inválido", 1);
            }
 
           
            $e_mail = trim($dados->e_mail); // acessa valor de um OBJETO
            $cpf = trim($dados->cpf); // acessa valor de um OBJETO
 
            $curl = curl_init();
            $cpf_token = '6708%7CHyuYJ08gTJukpgyO6HSKBLnE1rFMGrpL';
            $end_point_cpf= 'https://api.invertexto.com/v1/validator';
 
            curl_setopt_array($curl, array(
              CURLOPT_URL => $end_point_cpf.'?token='.$cpf_token.'&value='.$cpf,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
            ));
           
            $response = curl_exec($curl);
            curl_close($curl);
 
            $response = json_decode($response);
           
            if(!$response->valid){
                // teste: validaçaõ do email (formato)
                throw new ErrorException("CPF INVÁLIDO", 1);
               
            }
 
 
 
            //passo1 - OK : pensar em uma estratégia de criar um token que nunca se repita
            //Token tem que ser unico
 
            $temp = $e_mail.$cpf.date('d/m/Y - H:i:s');
            $temp = hash("sha256", $temp); //transforma em sha (junta email cpf e data)
            $token = substr($temp, 0 , 6) . substr($temp, -6, 6);
           
            //passo2 - OK: criar nova tabela no banco de dados para armazenar os dados e o token criado
 
            //passo3: continuar alterando o codigo abaixo
           
 
 
            $sql = "INSERT INTO token(email, cpf , token, data_criacao )
                    VALUES (:email, :cpf, :token, now())";
 
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":email", $e_mail);
            $stmt->bindParam(":cpf", $cpf);
            $stmt->bindParam(":token", $token);
            $stmt->execute();
 
            $result = array("e-mail"=>$e_mail, "cpf"=>$cpf, "token"=>$token);
 
        } catch (PDOException $ex) {
 
            $erro = $ex-> errorInfo[1];
            if($erro == 1062){
                $result =["status"=> "fail", "error"=> "Erro de Inserção: CPF ou e-mail duplicados"];
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
        // Criar resposta
 
    }
 
    if($method=="DELETE"){
        // Criar Resposta
     
     
    }
 
 
 
 
 
 
 
?>