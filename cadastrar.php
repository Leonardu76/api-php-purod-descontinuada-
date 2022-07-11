<?php
// CABEÇALHOS OBRIGATOIOS

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");

include_once 'conn.php';

$response_json = file_get_contents("php://input");


$dados = json_decode($response_json, true);

$data['nome'] = addslashes($dados['nome']);
$data['email'] = addslashes($dados['email']);
$data['senha'] = addslashes($dados['senha']);


$bdEmail = $conn->prepare("SELECT * FROM usuario WHERE email = :e");
$bdEmail->bindValue(":e", $data['email']);
$bdEmail->execute();

if($bdEmail->rowCount() > 0){
  $response = [
    "erro" => true,
    "messagem" => "Email já existe no sistema!"
  ];
  

}elseif($data['nome'] AND $data['senha']  AND $data['email']!= ''){
    $query_usuario = "INSERT INTO usuario (nome, email, senha) VALUES (:n, :e, :s)";
    $cadastrar_usuario =  $conn->prepare($query_usuario);
   
    $cadastrar_usuario->bindParam(':n', $data['nome']);
    $cadastrar_usuario->bindParam(':e', $data['email']);
    $cadastrar_usuario->bindParam(':s', $data['senha']);
   
    $cadastrar_usuario->execute();
   
    if($cadastrar_usuario->rowCount()){
       $response = [
           "erro" => false,
           "messagem" => "Cadastrado com sucesso!"
         ];
       
   
    }else{
       $response = [
           "erro" => true,
           "messagem" => "Usuário não cadastrado!"
         ];
    }
   
    
   }else{
       $response = [
         "erro" => true,
         "messagem" => "Usuário não cadastrado!"
        ];
   }






http_response_code(200);
echo json_encode($response);