<?php
include_once 'database.php'; 
include'sms.php';


class Menu {
    private $sessionId;
    private $phoneNumber;
    private $serviceCode;
    private $text;
    private $textArray;
    private $errMessage;

    function __construct($sessionId, $phoneNumber, $serviceCode, $text) {
        $this->phoneNumber = $phoneNumber;
        $this->sessionId = $sessionId;
        $this->text = $text;
        $this->serviceCode = $serviceCode;
    }






    public function handleRequest() {
        header("Content-type: text/plain");

        try {
            $connection = new Connection();
            $connect = $connection->connect();

            if ($this->isRegistered($connect)) {
                $textArray = explode("*", $this->text);
                if($this->text==""){
                    $this->home();
                }
                else{

                    switch ($textArray[0]) {
                        case '1':
                            $this->sendMoneyToBank($textArray);
                            break;
                                case '2':
                                    $this->getMoneyFromBank($textArray);
                                    break; 
                                    case '3':
                                    $this->linkToBank($textArray);
                                    break;
                                        case '4':
                                    $this->withdraw($textArray);
                                    break; 
                                        case '5':
                                    $this->sendMoney($textArray);
                                    break; 
                                        case '6':
                                            $this->history($textArray);
                                            break;
                                                case '7':
                                                    $this->checkBalance($textArray);
                                                    break;
                                                    case '8':
                                                        $this->approvals($textArray);

                                                        break;

                        
                        default:
                            echo"END Invalid option\n";



                            break;
                            
                            
                    }
                }
                
                
            } 


            else {
                $response = "END Please, go to our nearest Agent or service center.\n";
                $response .= "Thank You!";
                echo $response;
            }
        } catch (PDOException $e) {
            echo "END Error: " . $e->getMessage();
        }
    }




    public function home(){
        


        $response = "CON Welcome to MTN  mobile System\n";
            $response .= "1. Transfer money to Bank\n";
            $response .= "2. Get money from Bank\n";
            $response .="3. Link account to Bank\n";
            $response .= "4. Withdraw money\n";
            $response .= "5. Send Money\n";
            $response .= "6. View History\n";
            $response .= "7. Check balance\n";
            $response .="8. Pending Approvals\n\n\n";
            
            

            
            echo $response;



    }





    public function isRegistered($connect) {
        $stmt = $connect->prepare("SELECT * FROM subscribers WHERE phoneNumber = :phone");
        $stmt->bindParam(":phone", $this->phoneNumber);
        $stmt->execute();
        return $stmt->fetch();
    }






    public function sendMoneyToBank($textArray){


        $this->textArray=$textArray;

        $level=count($this->textArray);
        if($level==1 && $this->textArray[0]=='1'){

            $response="CON Enter Bank Account Number\n";
            echo $response;
        }
        else if($this->textArray[0]=='1' &&$level==2){
            $connection=new Connection();
            $connect=$connection->connect();
            $stmt =$connect->prepare("SELECT * FROM accounts WHERE accnumber=:accn");
            $stmt->bindParam(":accn",$this->textArray[1]);
            $stmt->execute();
            $acc= $stmt->fetch();
            if($acc){
                    
                 $response="CON Enter Bank PIN\n";
                 echo $response;
                
            }
            else{

                $response="END ".$this->textArray[1]." Account not found\n";
                $response .="Thank for using our service\n";
                echo $response;
                return;


            }

           

        }
        else if($this->textArray[0]=='1' &&$level==3){

            $connection=new Connection();
            $connect=$connection->connect();
            $query="SELECT a.accnumber,b.pin 
                    FROM 
                    accounts a JOIN clients b 
                    ON a.cid=b.cid 
                    WHERE a.accnumber=:accn
                    ";


            $stmt =$connect->prepare($query);
            $stmt->bindParam(":accn",$this->textArray[1]);
            $stmt->execute();
            $client=$stmt->fetch();
            if($client['pin']==$this->textArray[2]){

                $response="CON Enter Amount\n";
                echo $response;

            }
            else{

                $response="END Invalid PIN\n";
                echo $response;
            }



            

        }
        else if($this->textArray[0]=='1' &&$level==4){
            $connection=new Connection();
            $connect=$connection->connect();
            $stmt =$connect->prepare("SELECT * FROM subscribers WHERE phoneNumber=:phone");
            $stmt->bindParam(":phone",$this->phoneNumber);
            $stmt->execute();
            $subscriber= $stmt->fetch();
            if(floatval($this->textArray[3])<=$subscriber['balance']){
                $response="CON Enter  PIN\n";
                echo $response;


            }
            else{

                $response="END Insuffient balance\n";
                $response .="Thank for using our services\n";
                echo $response;
            }

            

        }
        else if($this->textArray[0]=='1' &&$level==5){
             $connection=new Connection();
            $connect=$connection->connect();
            $stmt =$connect->prepare("SELECT * FROM subscribers WHERE phoneNumber=:phone");
            $stmt->bindParam(":phone",$this->phoneNumber);
            $stmt->execute();
            $subscriber= $stmt->fetch();
            if(intval(($this->textArray[4]))==$subscriber['pin']){
                $acc=$this->textArray[1];
                $amount=$this->textArray[3];

                $response="CON Do you really want to send ".$amount." to ".$acc."\n";
                 $response .="1.Confirm\n";
                 $response .="2.Cancel\n";

                echo $response;


            }
            else{

                $response="END Invalid PIN\n";
                $response .="Thank for using our services\n";
                echo $response;
            }

            

            


           


            

        }

        else if($this->textArray[0]=='1' &&$level==6){

            if ($this->textArray[5] == '1') {
    $connection = new Connection();
    $connect = $connection->connect();

    $query = "SELECT * FROM subscribers WHERE phoneNumber = :phone";
    $stmt = $connect->prepare($query); 
    $stmt->bindParam(":phone", $this->phoneNumber);
    $stmt->execute();
    $subscriber = $stmt->fetch();

    if ($subscriber) {
        $response = "END You've sent " . $this->textArray[3] . " to " . $this->textArray[1] . "\n";
        $sid = $subscriber['sid'];

        // Insert transaction
        $query = "INSERT INTO transactions(type, status, description, sid) VALUES(:t, :s, :d, :si)";
        $stmt = $connect->prepare($query);
        $type = "send money to bank";
        $status = "success";
        $stmt->bindParam(":t", $type);
        $stmt->bindParam(":s", $status);
        $stmt->bindParam(":d", $message);
        $stmt->bindParam(":si", $sid);
        $stmt->execute();
        
        
        
        
        $message = "You've sent " . $this->textArray[3] . " to " . $this->textArray[1] . "\n";
        

        $sms= new sms($this->phoneNumber);
        $sent = $sms->sendSMS($message,$this->phoneNumber);
        if($sent['status']=='success' || $sent['status']=='Success' ){
            echo$response ." \n You will recieve SMS shortly\n Thank for using our services!\n";
        }
        else{

            echo"END Fail to send SMS!\n";
        }


        

        
    } else {
        $message = "END Failed to send " . $this->textArray[3] . " to " . $this->textArray[1] . "\n";

        
        $query = "INSERT INTO transactions(type, status, description, sid) VALUES(:t, :s, :d, NULL)";
        $stmt = $connect->prepare($query);
        $type = "send money to bank";
        $status = "fail";
        $stmt->bindParam(":t", $type);
        $stmt->bindParam(":s", $status);
        $stmt->bindParam(":d", $message);
        $stmt->execute();

                $sms= new sms($this->phoneNumber);
                $recipient="+250786139330";
                $sent = $sms->sendSMS($response,$recipient);
                if(is_array($sent) && strtolower($sent['success'])=='success'){
                     echo $message;

                  


                }
                else{

                    echo "END Failed to send  SMS!";
                }


       
    }
}
            else if($this->textArray[5]=='2'){

                $response="END you've cancelled \n";
                $response .="Thank you for using our service \n";
                echo $response;
                 return;

            }

        }



    }





    public function getMoneyFromBank($textArray){

        $this->textArray=$textArray;

        $level=count($this->textArray);

        if($this->textArray[0]=='2' && $level==1){

            $response="CON Enter PIN \n";
            echo $response;
        }
        else if($this->textArray[0]=='2' && $level==2){
            $connection=new Connection();
            $connect=$connection->connect();
            $stmt =$connect->prepare("SELECT * FROM subscribers WHERE phoneNumber=:phone");
            $stmt->bindParam(":phone",$this->phoneNumber);
            $stmt->execute();
            $subscriber= $stmt->fetch();
            if(intval(($this->textArray[1]))==$subscriber['pin']){

                $response="CON Enter Amount \n";
                echo $response;
                

               


            }
            else{

                $response="END Invalid PIN\n";
                $response .="Thank for using our services\n";
                echo $response;
            }


            


        }
        else if($this->textArray[0]=='2' && $level==3){
            $connection=new Connection();
            $connect=$connection->connect();
            $stmt =$connect->prepare("SELECT * FROM subscribers WHERE phoneNumber=:phone");
            $stmt->bindParam(":phone",$this->phoneNumber);
            $stmt->execute();
            $subscriber= $stmt->fetch();
            if(floatval($this->textArray[2])<=$subscriber['balance']){
                $response="CON Enter Bank Account Number\n";
                echo $response;


            }
            else{

                $response="END Insuffient balance\n";
                $response .="Thank for using our services\n";
                echo $response;
            }


            


        }
        else if($this->textArray[0]=='2' && $level==4){

            $connection=new Connection();
            $connect=$connection->connect();
            $stmt =$connect->prepare("SELECT * FROM accounts WHERE accnumber=:accn");
            $stmt->bindParam(":accn",$this->textArray[3]);
            $stmt->execute();
            $acc= $stmt->fetch();
            if($acc){
                $response="CON Enter Bank PIN \n";
                echo $response;

            }
            else{

                $response="END ".$this->textArray[3]." Account not found\n";
                $response .="Thank for using our service\n";
                echo $response;
                return;


            }




            


        }
        else if($this->textArray[0]=='2' && $level==5){
            $connection=new Connection();
            $connect=$connection->connect();
            $query="SELECT a.accnumber,b.pin 
                    FROM 
                    accounts a JOIN clients b 
                    ON a.cid=b.cid 
                    WHERE a.accnumber=:accn
                    ";


            $stmt =$connect->prepare($query);
            $stmt->bindParam(":accn",$this->textArray[3]);
            $stmt->execute();
            $client=$stmt->fetch();
            if($client['pin']==$this->textArray[4]){

                $response="CON Do you really want to get ".$this->textArray[2]." from ".$this->textArray[3]."\n";
            $response .="1. Confirm\n";
            $response .="2. Cancel\n";

            echo $response;

            }
            else{

                $response="END Invalid PIN\n";
                echo $response;
            }

            


        }
        else if($this->textArray[0]=='2' && $level==6){


            if($this->textArray[5]=='1'){

                $connection = new Connection();
                $connect= $connection->connect();
                $query = "SELECT * FROM accounts where accnumber=:code";
                $stmt= $connect->prepare($query);
                $stmt->bindParam(":code",$this->textArray[3]);
                $stmt->execute();
                $account=$stmt->fetch();
                if($account){

                    $query = "SELECT * FROM subscribers WHERE phoneNumber = :phone";
                    $stmt = $connect->prepare($query);
                    $stmt->bindParam(":phone", $this->phoneNumber);
                    $stmt->execute();
                    $subscriber = $stmt->fetch();
                    if ($subscriber) {
                        $sid = $subscriber['sid'];
                        $acode = $account['accnumber'];
                        $amount = $this->textArray[2];
                        $bank = $this->textArray[3];
                        $response = "You've sent $amount to your mobile account from $bank bank Account\n";

                        $type = "get money from bank";
                        $status = "success";
                        

                        $query = "INSERT INTO transactions(type, status, description, sid) VALUES(:t, :s, :d, :sid)";
                        $stmt = $connect->prepare($query);
                        $stmt->bindParam(":t", $type);
                        $stmt->bindParam(":s", $status);
                        $stmt->bindParam(":d", $response);
                        $stmt->bindParam(":sid", $sid);

                        
                        if ($stmt->execute()) {
                                echo "END You will receive SMS shortly\nThank you for using our service\n";
                            } 
                        else {
                                $failResponse = "Failed to send $amount to your mobile account from $bank bank Account\n";

                                $status = "fail";
                                $stmt = $connect->prepare($query);
                                $stmt->bindParam(":t", $type);
                                $stmt->bindParam(":s", $status);
                                $stmt->bindParam(":d", $failResponse);
                                $stmt->bindParam(":sid", $sid); // Still try to log with subscriber ID

                                $stmt->execute();

                                echo "END Transaction failed\nThank you for using our service\n";
                            }
                                                


                        


                        
                        

                    }
                    else{
                        echo"END Technical issue\n,Please call for help\n";
                    }



                    
                 

                return;
                    

                }
                else{
                    $message="END No account found";
                    echo $message;
                }


                
            }
            else if($this->textArray[5]=='2'){

                $response .="You've cancelled\n";
                $response .="Thank you for using our service\n";
                echo $response;
                return;


            }

            
            


        }


    }


    public function linkToBank($textArray){

        $this->textArray=$textArray;
        $level=count($this->textArray);
        if($this->textArray[0]=='3' && $level==1){

            $response="CON Enter PIN\n";
            echo $response;

        }
        else if ($this->textArray[0]=='3' && $level==2) {
            $connection=new Connection();
            $connect=$connection->connect();
            $stmt =$connect->prepare("SELECT * FROM subscribers WHERE phoneNumber=:phone");
            $stmt->bindParam(":phone",$this->phoneNumber);
            $stmt->execute();
            $subscriber= $stmt->fetch();
            if(intval(($this->textArray[1]))==$subscriber['pin']){

                $response="CON Enter Bank Account Number\n";
                 echo $response;
                

               


            }
            else{

                $response="END Invalid PIN\n";
                $response .="Thank for using our services\n";
                echo $response;
            }



            
        }
        else if ($this->textArray[0]=='3' && $level==3) {
            $connection=new Connection();
            $connect=$connection->connect();
            $stmt =$connect->prepare("SELECT * FROM accounts WHERE accnumber=:accn");
            $stmt->bindParam(":accn",$this->textArray[2]);
            $stmt->execute();
            $acc= $stmt->fetch();
            if($acc){
                $response="CON Enter Bank Account PIN\n";
                 echo $response;
            }
            else{

                $response="END ".$this->textArray[2]." Account not found\n";
                $response .="Thank for using our service\n";
                echo $response;
                return;


            }


            
        }
        else if ($this->textArray[0]=='3' && $level==4) {

            $connection=new Connection();
            $connect=$connection->connect();
            $query="SELECT a.accnumber,b.pin 
                    FROM 
                    accounts a JOIN clients b 
                    ON a.cid=b.cid 
                    WHERE a.accnumber=:accn
                    ";


            $stmt =$connect->prepare($query);
            $stmt->bindParam(":accn",$this->textArray[2]);
            $stmt->execute();
            $client=$stmt->fetch();
            if($client['pin']==$this->textArray[3]){

             $response="CON Do you really want to link ".$this->phoneNumber." to ".$this->textArray[2]."?\n";
            $response .="1.confirm\n";
            $response .="2. cancel\n";
            echo $response;

            }
            else{

                $response="END Invalid PIN\n";
                echo $response;
            }

            

            
        }

        else if ($this->textArray[0]=='3' && $level==5) {

            if($this->textArray[4]=='1'){

                $connection= new Connection();
                $connect= $connection->connect();
                $query ="SELECT * FROM subscribers WHERE phoneNumber=:phone";
                $stmt= $connect->prepare($query);
                $stmt->bindParam(":phone",$this->phoneNumber);
                $stmt->execute();
                $subscriber=$stmt->fetch();
                if ($subscriber) {
                $no = "no";

                // Begin transaction
                

                // Fetch unlinked account associated with this phone number
                $stmt = $connect->prepare("SELECT subscribers.sid, accounts.accid 
                                           FROM accounts 
                                           JOIN subscribers ON accounts.sid = subscribers.sid 
                                           WHERE accounts.linked = :no");
                // $stmt->bindParam(":phone", $this->phoneNumber);
                $stmt->bindParam(":no", $no);
                $stmt->execute();
                $detail = $stmt->fetch();

                if ($detail) {
                    $accid = $detail['accid'];
                    $link = "yes";

                    // Update the account to mark it as linked
                    $stmt = $connect->prepare("UPDATE accounts SET linked = :link AND sid=:sid WHERE accid = :accid");
                    $stmt->bindParam(":link", $link);
                    $stmt->bindParam(":accid", $subscriber['sid']);
                    $stmt->bindParam(":accid", $accid);

                    if ($stmt->execute()) {
                        
                        echo "END Linking successful\n";
                    } else {
                        
                        echo "END Linking failed!\n";
                    }

                } else {
                    
                    echo "END Already linked\n";
                }

            } else {
                echo "END Failed to link account\n";
            }

                

               

            }
            if($this->textArray[4]=='2'){

                $response="END You've cancelled linking process\n";
                $response .="Thank you for using our service\n";
                echo $response;

            }

            
        }


    }


    public function withdraw($textArray){


        $this->textArray=$textArray;
        $level=count($this->textArray);

        if($this->textArray[0]=='4' && $level==1){

            $response ="CON Enter Amount to withdraw\n";
            echo $response;
        }
        else if($this->textArray[0]=='4' && $level==2){

            $connection=new Connection();
            $connect=$connection->connect();
            $stmt =$connect->prepare("SELECT * FROM subscribers WHERE phoneNumber=:phone");
            $stmt->bindParam(":phone",$this->phoneNumber);
            $stmt->execute();
            $subscriber= $stmt->fetch();
            if(floatval($this->textArray[1])<=$subscriber['balance']){

                $stmt2= $connect->prepare("SELECT * FROM agents");

                $stmt2->execute();
                $agnts=$stmt2->fetchall();
                if($agnts !=null){
                    $response= "CON Enter Agent by mumber(i.e 1)\n";
                    foreach ($agnts as $agent ) {
                        $response .=$agent['aid']."=> ".$agent['acode']."\n";
                        // code...
                    }
                    echo $response;
                    
                }
                else{

                    echo"END No Agent found\n";
                }
                
                


                 



            }
            else{

                $response="END Insuffient balance\n";
                $response .="Thank for using our services\n";
                echo $response;
            }


           

        }

        else if($this->textArray[0]=='4' && $level==3){

            $connection3=new Connection();
            $connect3=$connection3->connect();
            
            $stmt3= $connect3->prepare("SELECT * FROM agents where aid=:id");
            $stmt3->bindParam(":id",$this->textArray[2]);
            $stmt3->execute();
            $agent=$stmt3->fetch();
                $connection= new Connection();
                $conn= $connection->connect();
                $query ="SELECT accounts.accid,subscribers.sid FROM subscribers JOIN accounts ON accounts.sid=subscribers.sid WHERE subscribers.phoneNumber=:phone";
                $stmt= $conn->prepare($query);
                $stmt->bindParam(":phone",$this->phoneNumber);
                $stmt->execute();
                $infos= $stmt->fetch();


                $sid=$infos['sid'];
                $accid=$infos['accid'];
                $message="hello then";
                $stmt=$conn->prepare("INSERT INTO approvals(accid,sid,descriptions) VALUES(:a,:b,:c)");

                $stmt->bindParam(":a",$accid);
                $stmt->bindParam(":b",$sid);
                $stmt->bindParam(":c",$message);
                $stmt->execute();
                 $amount = floatval($this->textArray[1]);
                $id = intval($this->textArray[2]);

                $amount = floatval($this->textArray[1]);
                $id = intval($this->textArray[2]);
                $type="withdraw money";
                $status="success";
                $description=" You've withdrawn ".$amount." from your Mobile account";

               
                if ($agent['balance'] >= $amount) {

                    $stmt = $conn->prepare("UPDATE agents SET balance = balance + :amount WHERE aid = :id");
                    $stmt->bindParam(":amount", $amount);
                    $stmt->bindParam(":id", $id);
                    
                    if ($stmt->execute()) {
                        $stmt = $conn->prepare("INSERT INTO transactions(type,status,description,sid) VALUES(:a,:b,:c,:d)");
                        $stmt->bindParam(":a", $type);
                        $stmt->bindParam(":b",$status);
                        $stmt->bindParam(":c",$description);
                        $stmt->bindParam(":d",$id);
                        if($stmt->execute()){
                            $response="You've withdrawn ".$amount." from your Mobile account\n";
                            $sms= new sms($this->phoneNumber);
                            $recipient=$this->phoneNumber;
                            $sent = $sms->sendSMS($response,$recipient);
                            if($sent['status']=='success' || $sent['status']=='Success'){
                                 echo"END You've withdrawn ".$amount." from your Mobile account\n";

                  


                                }
                                else{

                                    echo "END Failed to send  SMS!";
                                }

                            

                        }
                        else{
                            echo " END Failed to withdraw\n";
                        }

                        
                    } else {
                        echo "END Failed to update balance.\n";
                    }

                } else {
                    echo "END Insufficient balance.";
                }





                    
                


           
            

        

            
            

        





            
            


        }

    }



    public function sendMoney($textArray){

        $this->textArray=$textArray;
        $level=count($this->textArray);

        if($this->textArray[0]=='5' && $level==1){

            $response ="CON Enter Phone Number to send to\n";
            echo $response;
        }
        else if($this->textArray[0]=='5' && $level==2){
            $fullphone="+25" . $this->textArray[1];

            $connection5= new Connection();
            $connect5= $connection5->connect();
            $stmt5 = $connect5->prepare("SELECT * FROM subscribers WHERE phoneNumber=:phone");
            $stmt5->bindParam(":phone",$fullphone);
            $stmt5->execute();
            $recipient = $stmt5->fetch();
            if($recipient && $recipient['phoneNumber'] !=$this->phoneNumber){

                $response ="CON Enter amount you want to ".$this->textArray[1]."\n";

           
                echo $response;


            }else{
                echo"END number not found\n";

                
            }




            


        }
        else if($this->textArray[0]=='5' && $level==3){
             

            $connection6= new Connection();
            $connect6= $connection6->connect();
            $stmt6 = $connect6->prepare("SELECT * FROM subscribers WHERE phoneNumber=:phone");
            $stmt6->bindParam(":phone",$this->phoneNumber);
            $stmt6->execute();
            $subscriber=$stmt6->fetch();
            if(floatval($this->textArray[2]) <= $subscriber['balance']){

                $response ="CON Enter PIN\n";
           
                 echo $response;

            }
            else{

                echo "END Insufficient balance\n";
            }

            


        }
        else if($this->textArray[0]=='5' && $level==4){


            $connection7= new Connection();
            $connect7= $connection7->connect();
            $stmt7 = $connect7->prepare("SELECT * FROM subscribers WHERE phoneNumber=:phone");
            $stmt7->bindParam(":phone",$this->phoneNumber);
            $stmt7->execute();
            $subscriber=$stmt7->fetch();
            if($subscriber && $subscriber['pin']==intval($this->textArray[3])){
                $response ="CON Do you really want to send ".$this->textArray[2]."amount to".$this->textArray[1]."\n";
                $response .="1. Confirm\n";
                 $response .="2. Cancel\n";

           
            echo $response;


            }
            else{

                echo"END Invalid PIN\n";
            }
            

        }
        else if($this->textArray[0]=='5' && $level==5){

            if($this->textArray[4]=='1'){

                $response ="END You've sent ".$this->textArray[2]." to ".$this->textArray[1]."\n";
                
           
                echo $response;
                return;


            }

            else if($this->textArray[4]=='2'){

                $response ="END cancelled!\n";
                
           
                echo $response;
                return;


            }
            


        }

        


    }


    public function history($textArray){

        $this->textArray=$textArray;
        $level = count($this->textArray);

        if($this->textArray[0]=='6' && $level==1){

            $response= "CON Enter PIN\n";
            echo $response;

        }
        else if($this->textArray[0]=='6' && $level==2){
            $connection8= new Connection();
            $connect8=$connection8->connect();
            $stmt8=$connect8->prepare("SELECT * FROM subscribers WHERE phoneNumber=:phone");

            $stmt8->bindParam(":phone",$this->phoneNumber);
            $stmt8->execute();
            $subscriber=$stmt8->fetch();
            if($subscriber && $subscriber['pin']==intval($this->textArray[1])){


                    
            
            $stmt8= $connect8->prepare("SELECT * FROM transactions a 
                JOIN subscribers s ON a.sid=s.sid WHERE s.phoneNumber=:phone");
            $stmt8->bindParam(":phone",$this->phoneNumber);
            $stmt8->execute();

            $transactions= $stmt8->fetchall();

            if(count($transactions)>0){
                $response="END ";
                $i=1;
                

                foreach ($transactions as $transaction ) {
                    $response .="transaction ".$i."\n\n";

                    $response .="Type: ".$transaction['type']."\n";
                    $response .="Status: ".$transaction['status']."\n";
                    $response .="Description: ".$transaction['description']."\n";
                    $response .="\n\n";
                    $i++;
                    

                }

                echo $response;

                


                
                
            }
            else{

                echo"END no history\n";


            }



            }
            else{

                echo"END TOOOO\n";


            }

        
        

        }




            
        
    }


    public function checkBalance($textArray){

        $this->textArray=$textArray;
        $level = count($this->textArray);

        if($this->textArray[0]=='7' && $level==1){

            $response= "CON Enter PIN\n";
            echo $response;

        }
        else if($this->textArray[0]=='7' && $level==2){
            $connection8= new Connection();
            $connect8=$connection8->connect();
            $stmt8=$connect8->prepare("SELECT * FROM subscribers WHERE phoneNumber=:phone");

            $stmt8->bindParam(":phone",$this->phoneNumber);
            $stmt8->execute();
            $subscriber=$stmt8->fetch();
            if($subscriber && intval($textArray[1])==$subscriber['pin']){

                echo"END Your balance: ".$subscriber['balance']."\n";
            }
            else{

                echo "END Invalid PIN\nThank you for using our services\n";


            }



            
        }


    }


    public function approvals($textArray){

        $this->textArray=$textArray;
        $level = count($this->textArray);

        if($this->textArray[0]=='8' && $level==1){

            $response= "CON Enter PIN\n";
            echo $response;

        }
        else if($this->textArray[0]=='8' && $level==2){
            $connection8= new Connection();
            $connect8=$connection8->connect();
            $stmt8=$connect8->prepare("SELECT * FROM subscribers WHERE phoneNumber=:phone");

            $stmt8->bindParam(":phone",$this->phoneNumber);
            $stmt8->execute();
            $subscriber=$stmt8->fetch();
            if($subscriber && intval($textArray[1])==$subscriber['pin']){
                $stmt8=$connect8->prepare("SELECT * FROM approvals a JOIN subscribers s ON a.sid=s.sid 
                    WHERE s.phoneNumber=:phone AND a.created_at >= NOW() - INTERVAL 3 MINUTE ORDER BY created_at DESC LIMIT 3");

                $stmt8->bindParam(":phone",$this->phoneNumber);
                $stmt8->execute();
                $approvals= $stmt8->fetchall();
                    $response="END ";

                
                 if(count($approvals) > 0){
                    $i=1;

                    foreach ($approvals as $approval) {
                        $response .="\n ".$i.": ".$approval['descriptions'];
                        echo $response;
                    }

                
                }
                else{

                    echo" END No pendings\n";


                }




            }
            else{

                echo "END Invalid PIN\nThank you for using our services\n";


            }

            
        }


    }












    
}

$sessionId   = $_POST['sessionId']   ?? '';
$phoneNumber = $_POST['phoneNumber'] ?? '';
$serviceCode = $_POST['serviceCode'] ?? '';
$text        = $_POST['text']        ?? '';

$menu = new Menu($sessionId, $phoneNumber, $serviceCode, $text);
$menu->handleRequest();
?>
