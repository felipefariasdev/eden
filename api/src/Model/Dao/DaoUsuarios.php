<?php
namespace Model\Dao;
use Model\Entity\Usuarios;
use Model\Entity\UsuariosEventos;
use PDO;
use stdClass;
use Model\Compomentes\JsonEncodePrivate;

class DaoUsuarios {

    private $cn;

    public function __construct(){
        try{
            $this->cn = Connection::getInstance();
        }catch (\Exception $e){
            echo $e->getMessage();
        }

    }
	public function login($email,$senha){
        try{
            $this->cn->beginTransaction();
            $usuario = new Usuarios();
            $usuario->setEmail($email);
            $usuario->setSenha($senha);
            $sql = "SELECT id,nome,email FROM usuarios where email=:email and senha=:senha";
            $res = $this->cn->prepare($sql);
            $res->bindParam(":email", $usuario->getEmail(), PDO::PARAM_STR);
            $res->bindParam(":senha", $usuario->getSenha(), PDO::PARAM_STR);
            $res->execute();
            $obj    = $res->fetch(PDO::FETCH_OBJ);
            if($res->rowCount()){
                $user = array();
                $user["id"] = $obj->id;
                $user["nome"] = $obj->nome;
                $user["email"] = $obj->email;

                $this->cn->commit();
                $data                   = new stdClass();
                $data->success          = true;
                $data->error            = false;
                $data->user             = $user;
                return json_encode($data);
            }else{
                $data                   = new stdClass();
                $data->success          = false;
                $data->error            = true;
                $data->user             = false;
                return json_encode($data);
            }
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }
	
	public function vincular_usuario_evento($usuarios_id,$eventos_id){
        try{
            $this->cn->beginTransaction();
			
            $sql = "INSERT INTO usuarios_eventos (eventos_id,usuarios_id) VALUES (:eventos_id,:usuarios_id)";
            $res = $this->cn->prepare($sql);
            $res->bindParam(":eventos_id", $eventos_id, PDO::PARAM_STR);
            $res->bindParam(":usuarios_id", $usuarios_id, PDO::PARAM_STR);
            
            if($res->execute()){
				
				$this->cn->commit();
				$data                   = new stdClass();
				$data->success          = true;
				$data->error            = false;
				return json_encode($data);
	
            }else{
                $data                   = new stdClass();
                $data->success          = false;
                $data->error            = true;
                $data->user             = false;
                return json_encode($data);
            }
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }
	
	public function confirmar_entrada_do_no_usuario_evento($usuarios_id,$eventos_id){
        try{
            $this->cn->beginTransaction();
			
            $sql = "INSERT INTO usuarios_eventos (eventos_id,usuarios_id,confirmacao_casa) VALUES (:eventos_id,:usuarios_id,:confirmacao_casa)";
            $res = $this->cn->prepare($sql);
			$confirmacao_casa = "1";
            $res->bindParam(":eventos_id", $eventos_id, PDO::PARAM_STR);
            $res->bindParam(":usuarios_id", $usuarios_id, PDO::PARAM_STR);
            $res->bindParam(":confirmacao_casa", $confirmacao_casa, PDO::PARAM_STR);
            
            if($res->execute()){
				
				$this->cn->commit();
				$data                   = new stdClass();
				$data->success          = true;
				$data->error            = false;
				return json_encode($data);
	
            }else{
                $data                   = new stdClass();
                $data->success          = false;
                $data->error            = true;
                $data->user             = false;
                return json_encode($data);
            }
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }
	
	public function insert($nome,$email){
        try{
            $this->cn->beginTransaction();
			
            $usuario = new Usuarios();
            $usuario->setNome($nome);
            $usuario->setEmail($email);
            
            $sql = "INSERT INTO usuarios (nome,email) VALUES (:nome,:email)";
            $res = $this->cn->prepare($sql);
            $res->bindParam(":nome", $usuario->getNome(), PDO::PARAM_STR);
            $res->bindParam(":email", $usuario->getEmail(), PDO::PARAM_STR);
            
            if($res->execute()){
				
				$this->cn->commit();
				$data                   = new stdClass();
				$data->success          = true;
				$data->error            = false;
				return json_encode($data);
	
            }else{
                $data                   = new stdClass();
                $data->success          = false;
                $data->error            = true;
                $data->user             = false;
                return json_encode($data);
            }
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }
	
	public function insert_evento($nome,$email,$eventos_id,$img_documento){
        try{
            $this->cn->beginTransaction();
			
            $usuario = new Usuarios();
            $usuario->setNome($nome);
            $usuario->setEmail($email);
            $usuario->setImgDocumento($img_documento);

			
			//1 - insert do usuário no banco de dados na tabela usuarios
            $sql = "INSERT INTO usuarios (nome,email,img_documento) VALUES (:nome,:email,:img_documento)";
            
            $res = $this->cn->prepare($sql);
            $res->bindParam(":nome", $usuario->getNome(), PDO::PARAM_STR);
            $res->bindParam(":email", $usuario->getEmail(), PDO::PARAM_STR);
            $res->bindParam(":img_documento", $usuario->getImgDocumento(), PDO::PARAM_STR);
   
            
            if($res->execute()){
               $usuarios_id = $this->cn->lastInsertId();
           
				//2 - se o insert foi executado corretamente, então vou realizar o insert na tabela usuarios_eventos que faz o vinculo do email com o id do evento
				$sql = "INSERT INTO usuarios_eventos (usuarios_id,eventos_id,confirmacao_casa) VALUES (:usuarios_id,:eventos_id,:confirmacao_casa)";
				$res = $this->cn->prepare($sql);
                                $confirmacao_casa = 1;
				$res->bindParam(":usuarios_id", $usuarios_id, PDO::PARAM_STR);
				$res->bindParam(":eventos_id", $eventos_id, PDO::PARAM_STR);
				$res->bindParam(":confirmacao_casa", $confirmacao_casa, PDO::PARAM_STR);

				if($res->execute()){
					
					//3 - Se conseguiu inserir na tabela usuarios_eventos então realiza o commit
					$this->cn->commit();
					$data                   = new stdClass();
					$data->success          = true;
					$data->error            = false;
					return json_encode($data);
					
				}else{
					$data                   = new stdClass();
					$data->success          = false;
					$data->error            = true;
					$data->msg              = "Problema ao realizar o insert na tabela usuarios_eventos";

					return json_encode($data);

				}
	
            }else{
                $data                   = new stdClass();
                $data->success          = false;
                $data->error            = true;
                $data->user             = false;
                return json_encode($data);
            }
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }
	public function getQtdUsersEvent($id){
        $this->cn->beginTransaction();
        $start = microtime(true);
  
        $sql = "SELECT u.id FROM `usuarios` as u inner join usuarios_eventos as ue on (ue.usuarios_id=u.email)";
        if($pesquisar){
            $sql .= " where (ue.eventos_id='".$id."')";
        }
        $sql .= " group by u.id";
        $res = $this->cn->prepare($sql);
        $eventos        = $res->execute();
        $usuarios_obj    = $res->fetchAll(PDO::FETCH_OBJ);

        $this->cn->commit();

        $listaUsuarios = $this->addListItensUsuariosEventos($usuarios_obj);

        $total              = (microtime(true) - $start);
        $tempoDeExecucao    = number_format($total, 3);

        $data                   = new stdClass();
        $data->success          = true;
        $data->error            = false;
        $data->tempoDeExecucao  = $tempoDeExecucao;
        $data->rowCount		    = $res->rowCount();
 
        return json_encode($data);

    }
    
    private function addListItensUsuariosEventosId($l,$eventos_id){
        
        
        //aqui verifico se o o usuário está vinculado ao $eventos_id da url
        $arrayObjetos = array();

        
        foreach($l as $vl){

            $usuario = new Usuarios();
            
            $usuario->setId($vl->id);
            $usuario->setNome($vl->nome);
            $usuario->setEmail($vl->email);
            $usuario->setImgDocumento($vl->img_documento);
            $usuario->setVou($vl->vou);
            $usuario->setEntrou($vl->entrou);
        
            $arrayObjetos[] = JsonEncodePrivate::execute($usuario);
        }

        return $arrayObjetos;
    }
    
    public function getUsersEventosSearchId($eventos_id,$pesquisar=null){
        $this->cn->beginTransaction();
        $start = microtime(true);

        $sql = "SELECT u.id,u.nome,u.email,u.img_documento, (SELECT u_e.eventos_id FROM usuarios_eventos as u_e WHERE u_e.eventos_id=".$eventos_id." AND u_e.usuarios_id=u.id limit 1) as vou, (SELECT u_e.confirmacao_casa FROM usuarios_eventos as u_e WHERE u_e.eventos_id=".$eventos_id." AND u_e.usuarios_id=u.id limit 1) AS entrou FROM usuarios AS u";
        
		if($pesquisar){
			$sql .=" WHERE (u.nome LIKE '%".$pesquisar."%' OR u.email LIKE '%".$pesquisar."%')";
		}
		
		$res = $this->cn->prepare($sql);
        $eventos        = $res->execute();
        $usuarios_obj    = $res->fetchAll(PDO::FETCH_OBJ);

        $this->cn->commit();

        $listaUsuarios = $this->addListItensUsuariosEventosId($usuarios_obj,$eventos_id);

        $total              = (microtime(true) - $start);
        $tempoDeExecucao    = number_format($total, 3);

        $data                   = new stdClass();
        $data->success          = true;
        $data->error            = false;
        $data->tempoDeExecucao  = $tempoDeExecucao;
        $data->rowCount		    = $res->rowCount();
        $data->data_usuarios    = $listaUsuarios;

        return json_encode($data);

    }
    
	private function addListItensUsuariosEventos($l){
        $arrayObjetos = array();
        foreach($l as $vl){
		    $usuario = new UsuariosEventos();
            $arrayObjetosConfirmado = explode(",",$vl->confirmacao_casa);
            $euvouJsonTodos = array();
			$arrayObjetosEuVou = explode(",",$vl->eu_vou);
			foreach($arrayObjetosEuVou as $key=>$euVouValue){
                $euvou = new UsuariosEventos();
                $euvou->setEuVou($euVouValue);
                $euvou->setConfirmacaoEntrada($arrayObjetosConfirmado[$key]);
                $euvouJsonTodos[] = JsonEncodePrivate::execute($euvou);
			}
            $confirmadoJsonTodos = array();
            $arrayObjetosConfirmado = explode(",",$vl->confirmacao_casa);
            foreach($arrayObjetosConfirmado as $key=>$euConfirmadoValue){
                $confirmado = new UsuariosEventos();
                $confirmado->setConfirmacaoEntrada($euConfirmadoValue);
                $confirmadoJsonTodos[] = JsonEncodePrivate::execute($confirmado);
            }
            $usuario->setId($vl->id);
            $usuario->setNome($vl->nome);
            $usuario->setEmail($vl->email);
            $usuario->setImgDocumento($vl->img_documento);
            $usuario->setEuVou($euvouJsonTodos);
            $usuario->setConfirmacaoEntrada($confirmadoJsonTodos);

            $arrayObjetos[] = JsonEncodePrivate::execute($usuario);
        }

        return $arrayObjetos;
    }
	public function findEventSearch($eventos_id,$pesquisar){
        $this->cn->beginTransaction();
        $start = microtime(true);
        
        $aprovado = "S";

        $sql = "SELECT usuarios.* FROM `usuarios` inner join usuarios_eventos on (usuarios_eventos.usuarios_id=usuarios.email) where usuarios_eventos.eventos_id=".$eventos_id." and (usuarios.nome like '%".$pesquisar."%' OR usuarios.email like '%".$pesquisar."%')";
        $res = $this->cn->prepare($sql);
        $eventos        = $res->execute();
        $usuarios_obj    = $res->fetchAll(PDO::FETCH_OBJ);

        $this->cn->commit();

        $listaUsuarios = $this->addListItens($usuarios_obj);

        $total              = (microtime(true) - $start);
        $tempoDeExecucao    = number_format($total, 3);

        $data                   = new stdClass();
        $data->success          = true;
        $data->error            = false;
        $data->tempoDeExecucao  = $tempoDeExecucao;
        $data->rowCount		    = $res->rowCount();
        $data->data_usuarios    = $listaUsuarios;
        return json_encode($data);
    }
	
	
	public function findEventId($eventos_id){
        $this->cn->beginTransaction();
        $start = microtime(true);
        
        $aprovado = "S";

        $sql = "SELECT usuarios.* FROM `usuarios` inner join usuarios_eventos on (usuarios_eventos.usuarios_id=usuarios.email) where usuarios_eventos.eventos_id=".$eventos_id;
        $res = $this->cn->prepare($sql);
        $eventos        = $res->execute();
        $usuarios_obj    = $res->fetchAll(PDO::FETCH_OBJ);

        $this->cn->commit();

        $listaUsuarios = $this->addListItens($usuarios_obj);

        $total              = (microtime(true) - $start);
        $tempoDeExecucao    = number_format($total, 3);

        $data                   = new stdClass();
        $data->success          = true;
        $data->error            = false;
        $data->tempoDeExecucao  = $tempoDeExecucao;
        $data->rowCount		    = $res->rowCount();
        $data->data_usuarios    = $listaUsuarios;

        return json_encode($data);

    }
	
    public function fetchAll(){
        $this->cn->beginTransaction();
        $start = microtime(true);
        
        $aprovado = "S";

        $sql = "SELECT * FROM usuarios";
        $res = $this->cn->prepare($sql);
        $eventos        = $res->execute();
        $usuarios_obj    = $res->fetchAll(PDO::FETCH_OBJ);

        $this->cn->commit();

        $listaUsuarios = $this->addListItens($usuarios_obj);

        $total              = (microtime(true) - $start);
        $tempoDeExecucao    = number_format($total, 3);

        $data                   = new stdClass();
        $data->success          = true;
        $data->error            = false;
        $data->tempoDeExecucao  = $tempoDeExecucao;
        $data->rowCount		    = $res->rowCount();
        $data->data_usuarios    = $listaUsuarios;

        return json_encode($data);

    }
	private function addListItens($l){

        $arrayObjetos = array();

        foreach($l as $vl){

            $usuario = new Usuarios();
            
            $usuario->setId($vl->id);
            $usuario->setNome($vl->nome);
            $usuario->setEmail($vl->email);
            $usuario->setImgDocumento($vl->img_documento);
			
            $arrayObjetos[] = JsonEncodePrivate::execute($usuario);
        }

        return $arrayObjetos;
    }
}