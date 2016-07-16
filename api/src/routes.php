<?php
use Model\Dao\DaoEventos;
use Model\Dao\DaoUsuarios;
use Model\Entity\Eventos;

$app->get('/eventos/{id}', function ($request, $response, $args) {

    $id = $args["id"];
	
	try{
        $daoEventos = new DaoEventos();
        $return = $daoEventos->find($id);
        $return_obj = json_decode($return);

        if($return_obj->success==true){
            $rowCount = $return_obj->rowCount;
            $tempoDeExecucao = $return_obj->tempoDeExecucao;

            $msg_log = "detalhes evento (".$rowCount.") ".$tempoDeExecucao.", ".$this->logApi;
            //$this->logger->info($msg_log);
        }
        return $return;
    }catch (Exception $e){
        $data                   = new stdClass();
        $data->success          = false;
        $data->error            = true;
        $data->message          = $e->getMessage();
        $msg_log = "listar eventos (".$e->getMessage()."), ".$this->logApi;
        //$this->logger->error($msg_log);
        return json_encode($data);
    }

});


$app->get('/eventos', function ($request, $response, $args) {
    try{
        $daoEventos = new DaoEventos();
        $return = $daoEventos->fetchAll();
        $return_obj = json_decode($return);

        if($return_obj->success==true){
            $rowCount = $return_obj->rowCount;
            $tempoDeExecucao = $return_obj->tempoDeExecucao;

            $msg_log = "listar eventos (".$rowCount.") ".$tempoDeExecucao.", ".$this->logApi;
            //$this->logger->info($msg_log);
        }
        return $return;
    }catch (Exception $e){
        $data                   = new stdClass();
        $data->success          = false;
        $data->error            = true;
        $data->message          = $e->getMessage();
        $msg_log = "listar eventos (".$e->getMessage()."), ".$this->logApi;
        //$this->logger->error($msg_log);
        return json_encode($data);
    }
});

$app->post('/eventos/insert', function ($request, $response, $args) {
    if($request->isPost()){
        try{
            $evento_data = $request->getParsedBody();

            if($_FILES['img']['name']){
                $uploaddir = 'img/eventos/';
                $img_name = basename($_FILES['img']['name']);
                $uploadfile = $uploaddir . $img_name;
                if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadfile)) {
                    $evento = new Eventos();
                    $evento->setTitulo($evento_data["titulo"]);
                    $evento->setSubTitulo($evento_data["sub_titulo"]);
                    $evento->setDescricao($evento_data["descricao"]);
                    $evento->setImg($img_name);
                    $data_evento = $evento_data["data_evento"];
                    $data_evento = explode("/",$data_evento);
                    $data_evento = $data_evento[2]."-".$data_evento[1]."-".$data_evento[0];
                    $data_evento_formatado = $data_evento;
                    $evento->setDataEvento($data_evento_formatado);
                    $daoEventos = new DaoEventos();
                    $addEvento = $daoEventos->add($evento);
                    return ($addEvento);
                } else {
                    $data                   = new stdClass();
                    $data->success          = false;
                    $data->error            = true;
                    $data->message          = "Não foi possível realizar o upload!";
                    return json_encode($data);
                }
            }else{
                $data                   = new stdClass();
                $data->success          = false;
                $data->error            = true;
                $data->message          = "A imagem é um campo obrigatório!";
                return json_encode($data);
            }


        }catch (Exception $e){
            $data                   = new stdClass();
            $data->success          = false;
            $data->error            = true;
            $data->message          = $e->getMessage();
            return json_encode($data);
        }
    }
});
$app->post('/eventos/update', function ($request, $response, $args) {
    if($request->isPost()){
        try{
            $evento_data = $request->getParsedBody();
            
                $uploaddir = 'img/eventos/';
                $img_name = basename($_FILES['img']['name']);
                $uploadfile = $uploaddir . $img_name;
                if (move_uploaded_file($_FILES['img']['tmp_name'], $uploadfile)) {
                    $evento = new Eventos();
                    $evento->setId($evento_data["id"]);
                    $evento->setTitulo($evento_data["titulo"]);
                    $evento->setSubTitulo($evento_data["sub_titulo"]);
                    $evento->setDescricao($evento_data["descricao"]);
                    $evento->setImg($img_name);
                    $data_evento = $evento_data["data_evento"];
                    $data_evento = explode("/",$data_evento);
                    $data_evento = $data_evento[2]."-".$data_evento[1]."-".$data_evento[0];
                    $data_evento_formatado = $data_evento;
                    $evento->setDataEvento($data_evento_formatado);
                    $daoEventos = new DaoEventos();
                    $addEvento = $daoEventos->update($evento);
                    return ($addEvento);
                } else {

                    $evento = new Eventos();
                    $evento->setId($evento_data["id"]);
                    $evento->setTitulo($evento_data["titulo"]);
                    $evento->setSubTitulo($evento_data["sub_titulo"]);
                    $evento->setDescricao($evento_data["descricao"]);
                    $evento->setImg($evento_data["img"]);
                    $data_evento = $evento_data["data_evento"];
                    $data_evento = explode("/",$data_evento);
                    $data_evento = $data_evento[2]."-".$data_evento[1]."-".$data_evento[0];
                    $data_evento_formatado = $data_evento;
                    $evento->setDataEvento($data_evento_formatado);
                    $daoEventos = new DaoEventos();
                    $addEvento = $daoEventos->update($evento);
                    return ($addEvento);
                }
            


        }catch (Exception $e){
            $data                   = new stdClass();
            $data->success          = false;
            $data->error            = true;
            $data->message          = $e->getMessage();
            return json_encode($data);
        }
    }
});

$app->post('/eventos/delete', function ($request, $response, $args) {
	
	return false;
	
    if($request->isPost()){
        try{
            $evento_data = $request->getParsedBody();

            $evento = new Eventos();
            $evento->setId($evento_data["id"]);

            $daoEventos = new DaoEventos();
            $addEvento = $daoEventos->delete($evento);
            return ($addEvento);
            
        }catch (Exception $e){
            $data                   = new stdClass();
            $data->success          = false;
            $data->error            = true;
            $data->message          = $e->getMessage();
            return json_encode($data);
        }
    }
});

$app->post('/usuario/insert', function ($request, $response, $args) {
    if($request->isPost()){
        try{
            $parsedBody = $request->getParsedBody();
			
			$nome  = ($parsedBody["nome"]);
			$email = ($parsedBody["email"]);
	
			$daoUsuarios = new DaoUsuarios();
                        $msg_log = "Usuário inserido sem vinculo a um evento: ".$email;
                        //$this->logger->info($msg_log);
			return ($daoUsuarios->insert($nome,$email));
            
        }catch (Exception $e){
            $data                   = new stdClass();
            $data->success          = false;
            $data->error            = true;
            $data->message          = $e->getMessage();
            return json_encode($data);
        }
    }
});

$app->post('/usuario/vincular_evento', function ($request, $response, $args) {
    if($request->isPost()){
        try{
            $parsedBody = $request->getParsedBody();
			
			$usuarios_id = ($parsedBody["usuarios_id"]);
			$eventos_id  = ($parsedBody["eventos_id"]);

			$daoUsuarios = new DaoUsuarios();
			return ($daoUsuarios->vincular_usuario_evento($usuarios_id,$eventos_id));
            
        }catch (Exception $e){
            $data                   = new stdClass();
            $data->success          = false;
            $data->error            = true;
            $data->message          = $e->getMessage();
            return json_encode($data);
        }
    }
});

$app->post('/usuario/confirmar_entrada', function ($request, $response, $args) {
    if($request->isPost()){
        try{
            $parsedBody = $request->getParsedBody();
		
			$usuarios_id = ($parsedBody["usuarios_id"]);
			$eventos_id = ($parsedBody["eventos_id"]);
			
			$daoUsuarios = new DaoUsuarios();
			return ($daoUsuarios->confirmar_entrada_do_no_usuario_evento($usuarios_id,$eventos_id));

            
        }catch (Exception $e){
            $data                   = new stdClass();
            $data->success          = false;
            $data->error            = true;
            $data->message          = $e->getMessage();
            return json_encode($data);
        }
    }
});



$app->post('/usuario_evento/insert', function ($request, $response, $args) {
    //#todo - ao adicionar e já vincular o usuário a um evento o nome da imagem deve ter uma identificação com o id do usuário inserido
	if($request->isPost()){
        try{
            $parsedBody = $request->getParsedBody();
			
			
			
			$nome  = ($parsedBody["nome"]);
			$email = ($parsedBody["email"]);
			$eventos_id = ($parsedBody["eventos_id"]);

            if($_FILES['img_documento']['name']){
                $pasta_upload_documento = 'img/documento_perfil/';
                $img_documento = basename($_FILES['img_documento']['name']);
				
                $uploadfile = $pasta_upload_documento . $img_documento;
                if (move_uploaded_file($_FILES['img_documento']['tmp_name'], $uploadfile)) {
                    
                    //$this->logger->info("Inserir usuário vinculado a um evento, ".$this->logApi." nome ou email: ".$nome." no evento: ".$email);
                    
                    $daoUsuarios = new DaoUsuarios();
                    return ($daoUsuarios->insert_evento($nome,$email,$eventos_id,$img_documento));
                }
            }
        }catch (Exception $e){
            $data                   = new stdClass();
            $data->success          = false;
            $data->error            = true;
            $data->message          = $e->getMessage();
            return json_encode($data);
        }
    }
});

$app->get('/usuario_evento/list/{eventos_id}', function ($request, $response, $args) {    

	try{
        $eventos_id = $args["eventos_id"];
		$daoUsuarios = new DaoUsuarios();
		return ($daoUsuarios->getUsersEventosSearchId($eventos_id));
		
	}catch (Exception $e){
		$data                   = new stdClass();
		$data->success          = false;
		$data->error            = true;
		$data->message          = $e->getMessage();
		return json_encode($data);
	}
});

$app->get('/usuario_evento/list/{eventos_id}/{pesquisar}', function ($request, $response, $args) {    

	$pesquisar = $args["pesquisar"];
	$eventos_id = $args["eventos_id"];

	try{
                
                //$this->logger->info("Pesquisar usuário, ".$this->logApi." nome ou email: ".$pesquisar." no evento: ".$eventos_id);
            
		$daoUsuarios = new DaoUsuarios();
		return ($daoUsuarios->getUsersEventosSearchId($eventos_id,$pesquisar));
		
	}catch (Exception $e){
		$data                   = new stdClass();
		$data->success          = false;
		$data->error            = true;
		$data->message          = $e->getMessage();
		return json_encode($data);
	}
});

//não está na documentação, mas lista todos os usuários
$app->get('/users', function ($request, $response, $args) {    

	$id = $args["id"];

	try{
		$daoUsuarios = new DaoUsuarios();
		return ($daoUsuarios->fetchAll());
		
	}catch (Exception $e){
		$data                   = new stdClass();
		$data->success          = false;
		$data->error            = true;
		$data->message          = $e->getMessage();
		return json_encode($data);
	}
});

$app->post('/login', function ($request, $response, $args) {
    if($request->isPost()){
        try{
            $req = $request->getParsedBody();
            $daoUsuarios = new DaoUsuarios();
            $login_verificar = $daoUsuarios->login($req["email"],$req["senha"]);
            return ($login_verificar);
        }catch (Exception $e){
            $data                   = new stdClass();
            $data->success          = false;
            $data->error            = true;
            $data->message          = $e->getMessage();
			return json_encode($data);
        }
    }
});

$app->post('/login_admin', function ($request, $response, $args) {
    if($request->isPost()){
        try{
			$req = $request->getParsedBody();
			
			if($req["login"]=="admin" and $req["senha"]=="admin123"){
				$data                   = new stdClass();
				$data->success          = false;
				$data->error            = false;
				$data->message          = "Login som sucesso";
				$data->login            = $req["login"];
				
			}
			return json_encode($data);
        }catch (Exception $e){
            $data                   = new stdClass();
            $data->success          = false;
            $data->error            = true;
            $data->message          = "Usuario não encontrado!";
			return json_encode($data);
        }
    }
});

$app->post('/login_entrada', function ($request, $response, $args) {
    if($request->isPost()){
        try{
			$req = $request->getParsedBody();
			
			if($req["login"]=="entrada" and $req["senha"]=="entrada123"){
				$data                   = new stdClass();
				$data->success          = false;
				$data->error            = false;
				$data->message          = "Login som sucesso";
				$data->login            = $req["login"];
				
			}
			return json_encode($data);
        }catch (Exception $e){
            $data                   = new stdClass();
            $data->success          = false;
            $data->error            = true;
            $data->message          = "Usuario não encontrado!";
			return json_encode($data);
        }
    }
});

$app->get('/', function ($request, $response, $args) {
    //$this->logger->info("HOME, ".$this->logApi);
    return $this->renderer->render($response, 'inicio.phtml', $args);
});

