<?php
    include("../validar_sessao.php");

    if (!empty($_POST)){  
        $nome = $_POST["nome"];          
        $cpf = $_POST["cpf"];          
        $whatsapp = $_POST["whatsapp"];    
        $email = $_POST["email"];
        $senha1 = $_POST["senha1"];
        $senha2 = $_POST["senha2"];          
            

        if(empty($email)){
            $msg = "Campo e_mail é obrigatório";
            $status = 'fail';
            header("location: form.php?msg=$msg&status=$status");
            exit;
        }
              
        // endpoint da API
        $end_point = "http://localhost/api_jornal/clientes/";

        // Inicializa o CURL
        $curl = curl_init();

        $id = "";
        if (empty($_POST["id"])){
            // se ID é vazio será realizado POST
            $method = "POST";

            if(empty($senha1) || empty($senha2)){
                $msg = "Campo senha é obrigatório";
                $status = 'fail';
                header("location: form.php?msg=$msg&status=$status");
                exit;
            }
            if($senha1 != $senha2){
                $msg = "As Senhas informadas precisam ser iguais!";
                $status = 'fail';
                header("location: form.php?msg=$msg&status=$status");
                exit;
            }

            $senha = hash('sha256', $senha1);

            // if(empty($_POST["cargo"])){
            //     $msg= "Campo cargo obrigatório";
            //     $status = 'fail';
            //     header("location: index.php?msg=$msg&status=$status");
            //     exit;
            // }

        }else{
            // se ID NÃO é vazio será realizado PUT
            $method = "PUT";
            $id = $_POST['id'];


            if((!empty($senha1) || !empty($senha2) ) && ($senha1 != $senha2)){
                $msg = "As Senhas informadas precisam ser iguais!";
                $status = 'fail';
                header("location: index.php?msg=$msg&status=$status");
                exit;
            }
            if(empty($senha1) && empty($senha2)){
                $senha = "";
            }else{
                $senha = hash('sha256', $senha1);
            }
         
        }
     

        $post_body = json_encode([
            'id' => $id,
            'nome' => $nome,
            'cpf' => $cpf,
            'whatsapp' => $whatsapp,
            'email' => $email, 
            'senha' => $senha, 
            // 'habilita' => $habilita,
        ]);

        // configurações do CURL
        curl_setopt_array($curl,[            
            CURLOPT_URL => $end_point,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $post_body,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => array(
                'Authorization: '. $token
              ),
        ]);

        // envio do comando CURL e armazenamento da resposta
        $response = curl_exec($curl);

        // conersão do JSON para ARRAY
        $dado = json_decode($response, TRUE);

        // testar Retorno da API
        if ($dado["status"]=='fail'){
            $msg = "Erro ao inserir o registro";
            $status = 'fail';
            header("location: form.php?msg=$msg&status=$status");
            exit;
        }

        // tudo OK - inserio informação com sucesso
        $msg = "Registro inserido com sucesso";
        $status = 'success';
        header("location: index.php?msg=$msg&status=$status");
        exit;

    }else{
        $msg = "Padrão errado do protocolo de comuniação. Informe o Suporte!";
        $status = 'fail';
        header("location: index.php?msg=$msg&status=$status");
        exit;
    }


?>