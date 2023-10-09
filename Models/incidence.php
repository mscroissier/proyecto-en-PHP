<?php


class incidence
{
    private $id;
    private $descripcion;
    private $profesor;
    private $fecha;
    private $estado;
    private $admin;



    function __construct($id, $descripcion, $profesor, $fecha, $estado, $admin)
    {
        $this->id = $id;
        $this->descripcion = $descripcion;
        $this->profesor = $profesor;
        $this->fecha = $fecha;
        $this->estado = $estado;
        $this->admin = $admin;

    }


    public function getId()
    {
        return $this->id;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function getProfesor()
    {
        return $this->profesor;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function getEstado()
    {
        return $this->estado;
    }

    public function getAdmin()
    {
        return $this->admin;
    }

}
