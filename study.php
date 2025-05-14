
<?php 
class Menu{

	private $sessionId;
	private $phoneNumber;
	private $text;
	private $serviceCode;
	private $textArray;

	function __construct($sessionId,$serviceCode,$phoneNumber,$text){


		$this->sessionId=$sessionId;
		$this->serviceCode=$serviceCode;
		$this->phoneNumber = $phoneNumber;
		$this->text=$text;
		
		

	}

	public function handleRequest(){
		$textArray=explode("*", $this->text);

		if($this->text==''){

			$this->home();
		}
		else{
			switch ($textArray[0]) {
				case '1':
					 echo"END Hi\n";
					break;
					case '2':
						echo"END hello\n";
				
				default:
					// code...
					break;
			}


		}

	}
	
	public function home(){

		
		$response="CON Welcome to XYZ Mobile system\n";
		$response .="1. Login\n";
		$response .="2. Register\n";
		echo  $response;
	}








}


$sessionId= $_POST['sessionId']  ?? '';
$phoneNumber = $_POST['phoneNumber'] ?? '';
$serviceCode =$_POST['serviceCode'] ?? '';
$text = $_POST['text'] ?? '';

$menu = new Menu($sessionId,$serviceCode,$phoneNumber,$text);
$menu->handleRequest();





 ?>