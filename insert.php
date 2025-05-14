<?php 


include_once'database.php';
class Insert{
	public function insert(){
				$connection= new Connection();
				$conn= $connection->connect();

				$sid=2;
				$accid=2;
				$message="hello again";
				$stmt=$conn->prepare("INSERT INTO approvals(accid,sid,descriptions) VALUES(:a,:b,:c)");

				$stmt->bindParam(":a",$accid);
				$stmt->bindParam(":b",$sid);
				$stmt->bindParam(":c",$message);
				if($stmt->execute()){

					echo "Hello";
				}



			}
				}

			



 ?>