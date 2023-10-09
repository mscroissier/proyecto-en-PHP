
<?php
	class  Db{
		private static $conexion=NULL;
		private static $dbName = 'mantenimiento'; 

		public static function getConexion(){
			$conexion = new PDO("mysql:host=localhost;dbname=".self::$dbName, "root", "");
			return $conexion;
		}
		
	} 
?>





