<?php
// CABEÇALHOS OBRIGATOIOS

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");

include_once 'conn.php';


$response_json = file_get_contents("php://input");

$dados = json_decode($response_json, true);

$data['email'] = addslashes($dados['email']);
$data['senha'] = addslashes($dados['senha']);


$query = "SELECT * FROM usuario WHERE email = :e AND senha = :s";

$result_usuarios = $conn->prepare($query);
$result_usuarios->bindValue(":e", $data['email']);
$result_usuarios->bindValue(":s", $data['senha']);
$result_usuarios->execute();

if ($result_usuarios->rowCount()) {

    while($row_user = $result_usuarios->fetch(PDO::FETCH_ASSOC)){
        extract($row_user);
   
        $response["user"] = [
   
            'id' => $id,
            'nome' => $nome,
            'email' => $email,
            'senha' => $senha
        ];
        
       }

    // RESPOSTA COM STATUS 200:


}else{
        $response = [
            "erro" => true,
            "messagem" => "Usuário não encontrado!"
          ];
     
}


http_response_code(200);


// RETORNAR EM JSON:
echo json_encode($response);





?>
