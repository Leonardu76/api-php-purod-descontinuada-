<?php
// CABEÇALHOS OBRIGATOIOS

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'conn.php';


$query_post = "SELECT id, titulo, conteudo, created_at, autor, img_post, id_usuario FROM post ";
$result_post = $conn ->prepare($query_post);
$result_post->execute();


if(($result_post) AND ($result_post->rowCount() > 0)){
    while($row_user = $result_post->fetch(PDO::FETCH_ASSOC)){
     extract($row_user);

     $lista_post["posts"][$id] = [

        'id' => $id,
        'titulo' => $titulo,
        'conteudo' => $conteudo,
        'created_at' => $created_at,
        'autor' => $autor,
        'img_post' => $img_post,
        'id_usuario' => $id_usuario



     ];
    }
    // RESPOSTA COM STATUS 200:

    http_response_code(200);


    // RETORNAR EM JSON:
    echo json_encode($lista_post);
}

















?>
