<?php
 
    $headers = apache_request_headers();
    $token = $headers["Authorization"];
 
 
    // if(!isset($_SERVER['HTTP_ACCESSTOKEN']) || empty($_SERVER['HTTP_ACCESSTOKEN'])){
    if(!isset($token) || empty($token)){
        // se a variavel HTTP_ACCESSTOKEN não existe ou esta vazia
        $result =["status"=> "fail", "error"=> "Token Error1"];
        http_response_code(200);
        echo json_encode($result);
        exit;
    }
 
    $acess_token = $token;
 
    // passo 1 - consultar banco verifica se token existe
    $sql = "SELECT pk_id, email, cpf
            FROM token
            WHERE token = :token";
           
    $stmt = $conn->prepare($sql);
    $stmt->BindParam(":token", $acess_token);
    $stmt->execute();
 
    $dado = $stmt->fetch(PDO::FETCH_OBJ);
 
    if(!$dado){
        $result =["status"=> "fail", "error"=> "Informado não encontrado Token"];
        http_response_code(200);
        echo json_encode($result);
        exit;
    }
 
?>