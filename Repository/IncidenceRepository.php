<?php

include('../Models/incidence.php');
include_once('../Controllers/BD.php');

class IncidenceRepository
{

    // Devuelve el Incidence con ese id
    public function getById($id)
    {

        $conexion = db::getConexion();
        $incidence = null;
        $query = $conexion->query('SELECT * FROM incidencia WHERE id=' . $id);
        while ($filaIncidenceEnDB = $query->fetchObject()) {
            $incidence = new Incidence(
                $filaIncidenceEnDB->id,
                $filaIncidenceEnDB->descripcion,
                $filaIncidenceEnDB->profesor,
                $filaIncidenceEnDB->fecha,
                $filaIncidenceEnDB->estado,
                $filaIncidenceEnDB->admin
            );
        }
        return $incidence;
    }

    public function insert($incidencia)
    {

        //Esto solo es valido para PDO.
        $conexion = db::getConexion();
        //Create our INSERT SQL query.
        $sql = "INSERT INTO incidencia ( descripcion, profesor, fecha) VALUES (:description,:profesor, :fecha)";
        //Prepare our statement.
        $statement = $conexion->prepare($sql);
        //Bind our values to our parameters (we called them :make and :model).
        $statement->bindValue(':descripcion', $incidencia->getDescription());
        $statement->bindValue(':profesor', $incidencia->getProfesor());
        $statement->bindValue(':fecha', $incidencia->getFecha());
        $isInserted = $statement->execute();
        $conexion = null;
        return $isInserted;
    }

    public function delete($id)
    {
        $conexion = $this->getConexion('mantenimiento');
        $borrar = $conexion->query('DELETE FROM incidencia WHERE id=' . $id);
        $conexion = null;
        return $borrar;
    }

    // Retornar un array de Incidencias
    public function getAll()
    {
        $incidencias = [];

        $conexion = $this->getConexion('mantenimiento');
        $stringQuery = "SELECT * FROM incidencia";
        $queryIncidencias = $conexion->query( $stringQuery);
        //Recorremos cada fila que devuelve la query  de DB y la transforma en un Modelo product.
        while ($filaIncidenciaEnDB = $queryIncidencias->fetchObject()) {
            //Creamos un Modelo Incidencia con los datos de la fila
            $incidencia = new Incidence(
                $filaIncidenciaEnDB->id,
                $filaIncidenciaEnDB->descripcion,
                $filaIncidenciaEnDB->profesor,
                $filaIncidenciaEnDB->fecha,
                $filaIncidenciaEnDB->estado,
                $filaIncidenciaEnDB->admin
            );

            // almacenamos el modelo produto recien creado en el array de Incidencias
            $incidencias[] = $incidencia;
        }

        $conexion = null;
        return $incidencias;
    }
    public function update($id, $incidencias)
    {
        $conexion = db::getConexion();
        $sql = "UPDATE  incidencia SET admin= :administrador,  WHERE id= $id";
        $statement = $conexion->prepare($sql);
        $statement->bindValue(':administrador', $incidencias->getAdmin());
        $isInserted = $statement->execute();
        $conexion = null;
        return $isInserted;
    }


    //Functiones de utilidad
    public function getConexion($dbname)
    {

        //  Realizar una conexion a base de datos mediante usando PDO
        $conexion = new PDO("mysql:host=localhost;dbname=" . $dbname, "root", ""); //los campos vacios son usuario y contraseña respectivamente
        return $conexion;
    }
}
