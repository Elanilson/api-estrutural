<?php
require "../config.php";

$method = strtolower( $_SERVER['REQUEST_METHOD']);
if($method === 'delete'){
    
    parse_str(file_get_contents('php://input'),$input);

   // $id = (!empty($input['id'])) ? $input['id'] : null; // não usando php 7.4
   // $title = (!empty($input['title'])) ? $input['title'] : null; // não usando php 7.4
  //  $body = (!empty($input['body'])) ? $input['body'] : null; // não usando php 7.4
    $id = $input['id'] ?? null; // usando php 7.4 +
    
    $id = filter_var($id);
   

    if($id){

        $sql = $pdo->prepare('SELECT * FROM notes WHERE id = :id');
        $sql->bindValue(':id',$id);
        $sql->execute();

        if($sql->rowCount() > 0){

            $sql = $pdo->prepare('DELETE  FROM notes WHERE id = :id');
            $sql->bindValue(':id', $id);
            $sql->execute();


        }else{
            $array['error'] = 'Id inexistente.';
        }
    }else{
        $array['error'] = 'ID não enviados.';
    }

}else{
    $array['error'] = 'Metodo não permitido (Apenas DELETE).';
}

require "../return.php";