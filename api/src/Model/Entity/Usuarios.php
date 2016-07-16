<?php
namespace Model\Entity;

class Usuarios
{
    private $id;
    private $nome;
    private $email;
    private $senha;
    private $img_documento;
    private $data_hora_insert;
    private $vou;
    private $entrou;

    /**
     * @return mixed
     */
    public function getEntrou()
    {
        return $this->entrou;
    }

    /**
     * @param mixed $entrou
     */
    public function setEntrou($entrou)
    {
        $this->entrou = $entrou;
    }
    
    /**
     * @return mixed
     */
    public function getVou()
    {
        return $this->img_documento;
    }

    /**
     * @param mixed $vou
     */
    public function setVou($vou)
    {
        $this->vou = $vou;
    }
    /**
     * @return mixed
     */
    public function getImgDocumento()
    {
        return $this->img_documento;
    }

    /**
     * @param mixed $img_documento
     */
    public function setImgDocumento($img_documento)
    {
        $this->img_documento = $img_documento;
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
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param mixed $senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }



}