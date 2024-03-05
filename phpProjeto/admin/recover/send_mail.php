<?php
 




//- verificar se e-mail foi digitado ou se existe na requisição POST
if(!isset($_POST["email"]) || empty($_POST["email"])){
    // finalizar o que será feito quando entrar no erro
    echo "E-mail vazio";
    exit;
}
// - verificar se e-mail digitado é válido
if(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
        // finalizar o que será feito quando entrar no erro
        echo "E-mail invalido";
        exit;
 
}
 
$email = $_POST["email"];
 
 
// - verificar se e-mail existe no cadastro; API consulta (GET)
$curl = curl_init();
 
$end_point = 'http://localhost/api_jornal/usuarios/';
$token='f6a95880e88e';
 
curl_setopt_array($curl, array(
  CURLOPT_URL => $end_point.'?email='.$email,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'ACCESSTOKEN: '.$token
  ),
));
 
$response = curl_exec($curl);
 
curl_close($curl);
 
$dado = json_decode($response);
$usuario = $dado -> usuarios;


if(!$usuario){
    //finalizar o que sera feito quando entrar no erro
    echo "E-mail não cadastrado";
    exit;
}
 
// echo "<pre>";
// print_r($dado);
// echo "</pre>";
// exit;
 
// echo print_r($usuario);
 
$codigo = hash("sha256", $email.date('d/m/Y - H:i:s'));
$codigo = substr($codigo, -6,6);
$id = $usuario->pk_id;
 


$post_body = json_encode([
    'id' => $id,
    'e_mail' => $email,
    'senha' => '',
    'habilita' => '',
    'cargo' => '',
    'codigo' => $codigo,
]);
 

 
 
 
// montar body JSON
$curl = curl_init();
 
curl_setopt_array($curl, array(
  CURLOPT_URL => $end_point,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PUT',
  CURLOPT_POSTFIELDS => $post_body,
  CURLOPT_HTTPHEADER => array(
    'ACCESSTOKEN:'.$token,
    'Content-Type: application/json'
  ),
));
 
$response = curl_exec($curl);
$response = json_decode($response);
 
// echo "<pre>";
// print_r(json_decode($post_body));
// echo "</pre>";
// exit;
// echo "<pre>";
// print_r($response);
// echo "</pre>";
// exit;
 

 
 
//enviar e-mail
require_once("../../vendor/plugins/PHPMailer/src/PHPMailer.php");
require_once("../../vendor/plugins/PHPMailer/src/SMTP.php");
require_once("../../vendor/plugins/PHPMailer/src/Exception.php");
 
 
 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
 
//Load Composer's autoloader
// require 'vendor/autoload.php';
 
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
 
try {
//Server settings
// $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output : = SMTP::DEBUG_SERVER;  
// SMTP::DEBUG_OFF (0): Desativar o debug (você pode deixar sem preencher este valor, uma vez que esta opção é o padrão).
// SMTP::DEBUG_CLIENT (1): Imprimir mensagens enviadas pelo cliente.
// SMTP::DEBUG_SERVER (2): similar ao 1, mais respostas recebidas dadas pelo servidor (esta é a opção mais usual).
// SMTP::DEBUG_CONNECTION (3): similar ao 2, mais informações sobre a conexão inicial - este nível pode auxiliar na ajuda com falhas STARTTLS.
// SMTP::DEBUG_LOWLEVEL (4): similar ao 3, mais informações de baixo nível, muito prolixo, não use para debugar SMTP, apenas em problemas de baixo nível.
 
 
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'mail.glaucosantos.com.br';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'ti_manha@glaucosantos.com.br';                 //SMTP username
$mail->Password   = 'Senac2023';                               //SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
 
//Recipients
$mail->setFrom('ti_manha@glaucosantos.com.br', 'SISTEMA-SUPORTE'); //remetente
$mail->addAddress($email);     //Add a recipient
// $mail->addAddress('ellen@example.com');               //Name is optional
// $mail->addReplyTo('info@example.com', 'Information');
// $mail->addCC('cc@example.com');
// $mail->addBCC('bcc@example.com');
 
//Attachments
// $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
 
//Content
$mail->isHTML(true);  
$mail->charset="UTF-8";                               //Set email format to HTML
$mail->Subject = 'Troca de senha';
$mail->Body    = "Este é o seu código para recuperação de senha: <br> <strong>Código: </strong>".$codigo ;
$mail->AltBody = "Este é o seu código para recuperação de senha: <br> <strong>Código: </strong>".$codigo ;
 
$mail->send();
// echo 'E-mail enviado com sucesso!';
header("location: recover-password.php");
} catch (Exception $e) {
echo "E-mail não pode ser enviado. Error: {$mail->ErrorInfo}";
}
 
 
 
?>