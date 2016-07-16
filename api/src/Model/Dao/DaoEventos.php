<?php

namespace Model\Dao;
use Model\Entity\Eventos;
use PDO;
use stdClass;
use Model\Compomentes\JsonEncodePrivate;

class DaoEventos {

    private $cn;

    public function __construct(){
        try{
            $this->cn = Connection::getInstance();
        }catch (\Exception $e){
            echo $e->getMessage();
        }

    }

    public function add($evento){
        $this->cn->beginTransaction();

        $sql = "INSERT INTO eventos (titulo,sub_titulo,descricao,data_evento,img) VALUES (:titulo,:sub_titulo,:descricao,:data_evento,:img)";
        $res = $this->cn->prepare($sql);
        $res->bindParam(":titulo", $evento->getTitulo(), PDO::PARAM_STR);
        $res->bindParam(":sub_titulo", $evento->getSubTitulo(), PDO::PARAM_STR);
        $res->bindParam(":descricao", $evento->getDescricao(), PDO::PARAM_STR);
        $res->bindParam(":data_evento", $evento->getDataEvento(), PDO::PARAM_STR);
        $res->bindParam(":img", $evento->getImg(), PDO::PARAM_STR);
        $res->execute();
        $this->cn->commit();
        $data                   = new stdClass();
        $data->success          = true;
        $data->error            = false;
        return json_encode($data);

    }

    public function update($evento){
        $this->cn->beginTransaction();

        $sql = "UPDATE eventos SET titulo=:titulo,sub_titulo=:sub_titulo,descricao=:descricao,data_evento=:data_evento,img=:img WHERE id=:id";
	
        $res = $this->cn->prepare($sql);
        $res->bindParam(":id", $evento->getId(), PDO::PARAM_STR);
        $res->bindParam(":titulo", $evento->getTitulo(), PDO::PARAM_STR);
        $res->bindParam(":sub_titulo", $evento->getSubTitulo(), PDO::PARAM_STR);
        $res->bindParam(":descricao", $evento->getDescricao(), PDO::PARAM_STR);
        $res->bindParam(":data_evento", $evento->getDataEvento(), PDO::PARAM_STR);
        $res->bindParam(":img", $evento->getImg(), PDO::PARAM_STR);
        
        $res->execute();
        $this->cn->commit();
        $data                   = new stdClass();
        $data->success          = true;
        $data->error            = false;
        return json_encode($data);

    }
    public function delete($evento){
        $this->cn->beginTransaction();

        $sql = "DELETE FROM eventos WHERE id=:id";
        $res = $this->cn->prepare($sql);
        $res->bindParam(":id", $evento->getId(), PDO::PARAM_STR);
        $res->execute();
        $this->cn->commit();
        $data                   = new stdClass();
        $data->success          = true;
        $data->error            = false;
        return json_encode($data);

    }
    
	public function find($id){
        $this->cn->beginTransaction();
        $start = microtime(true);
        $aprovado = "S";

        $sql = "SELECT DATE_FORMAT(eventos.data_evento,'%d/%m/%Y') as data_evento_formatado,eventos.* FROM eventos where id=:id";
        $res = $this->cn->prepare($sql);
        $res->bindParam(":id", $id, PDO::PARAM_STR);
        $res->execute();
        $eventos_obj    = $res->fetchAll(PDO::FETCH_OBJ);

        $this->cn->commit();

        $listaEventos = $this->addItem($eventos_obj);

        $total              = (microtime(true) - $start);
        $tempoDeExecucao    = number_format($total, 3);

        $data                   = new stdClass();
        $data->success          = true;
        $data->error            = false;
        $data->tempoDeExecucao  = $tempoDeExecucao;
        $data->rowCount         = $res->rowCount();
        $data->eventos          = $listaEventos;

        return json_encode($data);

    }
	
	
    public function fetchAll(){
        $this->cn->beginTransaction();
        $start = microtime(true);
        $aprovado = "S";

        $sql = "SELECT DATE_FORMAT(eventos.data_evento,'%d/%m/%Y') as data_evento_formatado,eventos.* FROM eventos where aprovado=:aprovado order by data_hora_insert desc limit 50";
        $res = $this->cn->prepare($sql);
        $res->bindParam(":aprovado", $aprovado, PDO::PARAM_STR);
        $res->execute();
        $eventos_obj    = $res->fetchAll(PDO::FETCH_OBJ);

        $this->cn->commit();

        $listaEventos = $this->addListItens($eventos_obj);

        $total              = (microtime(true) - $start);
        $tempoDeExecucao    = number_format($total, 3);

        $data                   = new stdClass();
        $data->success          = true;
        $data->error            = false;
        $data->tempoDeExecucao  = $tempoDeExecucao;
        $data->rowCount         = $res->rowCount();
        $data->eventos          = $listaEventos;

        return json_encode($data);

    }
	private function addItem($l){

        $arrayObjetos = array();

        foreach($l as $vl){

            $comentarios = new Eventos();
            $comentarios->setId($vl->id);
            $comentarios->setSubTitulo($vl->sub_titulo);
            $comentarios->setTitulo($vl->titulo);
            $comentarios->setDescricao($vl->descricao);
            $comentarios->setImg($vl->img);
            $comentarios->setDataEvento($vl->data_evento_formatado);
            $comentarios->setDataHoraInsert($vl->data_hora_insert);
            $arrayObjetos = JsonEncodePrivate::execute($comentarios);
        }

        return $arrayObjetos;
    }
    private function addListItens($l){

        $arrayObjetos = array();

        foreach($l as $vl){

            $comentarios = new Eventos();
            $comentarios->setId($vl->id);
            $comentarios->setSubTitulo($vl->sub_titulo);
            $comentarios->setTitulo($vl->titulo);
            $comentarios->setDescricao($vl->descricao);
            $comentarios->setImg($vl->img);
            $comentarios->setDataEvento($vl->data_evento_formatado);
            $comentarios->setDataHoraInsert($vl->data_hora_insert);
            $comentarios->setAprovado($vl->aprovado);
            $arrayObjetos[] = JsonEncodePrivate::execute($comentarios);
        }

        return $arrayObjetos;
    }
} 