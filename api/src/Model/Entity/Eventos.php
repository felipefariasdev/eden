<?php
namespace Model\Entity;
use stdClass;
class Eventos {

    private $id;
    private $titulo;
    private $sub_titulo;
    private $descricao;
    private $img;
    private $data_evento;
    private $data_hora_insert;
    private $aprovado;

    /**
     * @return mixed
     */
    public function getSubTitulo()
    {
        return $this->sub_titulo;
    }

    /**
     * @param mixed $sub_titulo
     */
    public function setSubTitulo($sub_titulo)
    {
        $this->sub_titulo = $sub_titulo;
    }


    /**
     * @return mixed
     */
    public function getDataEvento()
    {
        return $this->data_evento;
    }

    /**
     * @param mixed $data_evento
     */
    public function setDataEvento($data_evento)
    {
        $this->data_evento = $data_evento;
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * @param mixed $titulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @return mixed
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * @param mixed $img
     */
    public function setImg($img)
    {
        $this->img = $img;
    }

    /**
     * @return mixed
     */
    public function getDataHoraInsert()
    {
        return $this->data_hora_insert;
    }

    /**
     * @param mixed $data_hora_insert
     */
    public function setDataHoraInsert($data_hora_insert)
    {
        $this->data_hora_insert = $data_hora_insert;
    }
    
    /**
     * @return mixed
     */
    public function getAprovado()
    {
        return $this->aprovado;
    }

    /**
     * @param mixed $aprovado
     */
    public function setAprovado($aprovado)
    {
        $this->aprovado = $aprovado;
    }
} 