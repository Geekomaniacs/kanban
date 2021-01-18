<?php

//namespace KanbanProject\Model;

class User {
	private $mail;
	private $id;
	private $pwd;
	
	function __construct($nid, $nmail, $npwd){
		$this -> mail = $nmail;
		$this -> id = $nid;
		$this -> pwd = $npwd;
	}
	
	public function getId(){
		return $this -> id;
	}
	
	public function getMail(){
		return $this -> mail;
	}
	
	public function getPwd(){
		return $this -> pwd;
	}
	
	public static function createUser($mail, $pwd){
		
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8','projet','tejorp');
			
			if($mail == "" || $pwd == ""){
				return null;
			} else {
				$request =$bdd -> prepare('select * from users where mail= :mail and password =:pwd');
				$request -> execute(array('mail'=>$mail, 'pwd'=>$pwd));
				
				$data = $request -> fetch();
				
				if($data != null){
					return null;
				}else {
					$request = $bdd->prepare('insert into users values(id,:mail,:mdp);');
				
				    $request ->execute(array('mail'=>$mail,'mdp'=>$pwd));
				
				    $request = $bdd -> prepare('select * from users where mail=:mail;');
				
				    $request -> execute(array('mail'=>$mail));

				    $data = $request-> fetch();
				
				    if($data == null){
					    $bdd = null;
					    return null;
				    } else {
					    $bdd = null;
					    return new User($data[0], $data[1], $data[2]);
				    }
				}
			}
			
		} catch (PDOException $pdoe){
				print "Error with PDO : ". $pdoe -> getMessage()."<br/>";
				die();
		}
	}
	
	public static function getUser($mail){
		
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8','projet','tejorp');
			
			$request = $bdd->prepare('Select * from users where mail=:mail;');
			
			$request -> execute(array('mail'=>$mail));
			
			if($data = $request->fetch()){
				$bdd = null;
				return new User($data['id'],$data['mail'],$data['password']);
			} else {
				$bdd = null;
				return null;
			}
			
		} catch (PDOException $pdoe){
				print "Error with PDO : ". $pdoe -> getMessage()."<br/>";
				die();
		}
		
	}
	
	public static function accountExist($mail, $pwd){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8','projet','tejorp');
			
			$request = $bdd -> prepare('select * from users where mail= :mail and password= :pwd'); 
			$request -> execute(array('mail' => $mail, 'pwd' => $pwd));
			
			$data = $request -> fetch();
			if(data == null){
				return false;
			} else {
				return true;
			}
		}catch (PDOException $pdoe){
				print "Error with PDO : ". $pdoe -> getMessage()."<br/>";
				die();
		}
	}

	/*public static function removeUser($user){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8','projet','tejorp');
			
			$request = $bdd -> prepare('select * from users where id = :id');
			$request -> execute('id' => $user -> getId());
			
			if($request -> fetch() != null){
				$request => $bdd -> prepare('delete from users where id = :id');
				$request -> execute('id' => $user -> id);
				
				$user = null;
				
			}
			
		}catch (PDOException $pdoe){
				print "Error with PDO : ". $pdoe -> getMessage()."<br/>";
				die();
		}
	}*/
}

?>
