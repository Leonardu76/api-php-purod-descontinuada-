<?php
// CABEÇALHOS OBRIGATOIOS

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'conn.php';


$query_usuarios = "SELECT id, nome, email FROM usuario ";
$result_usuarios = $conn ->prepare($query_usuarios);
$result_usuarios->execute();


if(($result_usuarios) AND ($result_usuarios->rowCount() > 0)){
    while($row_user = $result_usuarios->fetch(PDO::FETCH_ASSOC)){
     extract($row_user);

     $lista_usuarios["records"][$id] = [

        'id' => $id,
        'nome' => $nome,
        'email' => $email
     ];
    }
    // RESPOSTA COM STATUS 200:

    http_response_code(200);


    // RETORNAR EM JSON:
    echo json_encode($lista_usuarios);
}

















?>
