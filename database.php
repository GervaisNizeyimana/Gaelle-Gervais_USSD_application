<?php 
include'utils.php';

class Connection{
		


	public function connect(){
		try {
			if(Utils::$conn==null){

			Utils::$conn= new PDO("mysql:host=".Utils::$hostname.";dbname=".Utils::$dbname,Utils::$username,Utils::$password,Utils::$options);
			Utils::$conn;
		}
		return Utils::$conn;

			
		} catch (PDOException $e) {
			echo "END Error: ".$e->getMessage();
			
		}

		

	}






}






 ?>