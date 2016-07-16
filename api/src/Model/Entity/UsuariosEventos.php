<?php
namespace Model\Entity;

class UsuariosEventos
{
    private $id;
    private $nome;
    private $email;
    private $img_documento;
    private $eu_vou;
    private $confirmacao_entrada;

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
    public function getEuVou()
    {
        return $this->eu_vou;
    }

    /**
     * @param mixed $eu_vou
     */
    public function setEuVou($eu_vou)
    {
        $this->eu_vou = $eu_vou;
    }

    /**
     * @return mixed
     */
    public function getConfirmacaoEntrada()
    {
        return $this->confirmacao_entrada;
    }

    /**
     * @param mixed $confirmacao_entrada
     */
    public function setConfirmacaoEntrada($confirmacao_entrada)
    {
        $this->confirmacao_entrada = $confirmacao_entrada;
    }

}