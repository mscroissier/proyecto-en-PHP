<?php
include('../Repository/IncidenceRepository.php');

class IncidenceController
{
    //llama al repositorio para que nos devuelva un array de objetos productos
    public function getAll()
    {

        $repositorio = new IncidenceRepository(); //se encarga de realizar acciones sobre la base de datos

        $arrayIncidencias =  $repositorio->getAll();
        return $arrayIncidencias;
    }
    public function delete($id)
    {
        $repositorio = new IncidenceRepository();
        $repositorio->delete($id);
    }
    public function insert($incidencia)
    {
        $repositorio = new IncidenceRepository();
        $repositorio->insert($incidencia);
    }
    public function update($id, $incidencias)
    {
        $repositorio = new IncidenceRepository();
        $datosRetorno = $repositorio->update($id, $incidencias);
        return $datosRetorno;
    }
    public function getById($id)
    {
        $repositorio = new IncidenceRepository();
        $idRetorno = $repositorio->getById($id);
        return $idRetorno;
    }

}
