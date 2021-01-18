<?php
use Model\KanbanColumn as KanbanColumn;
//namespace KanbanProject\Model;

class Kanban {
 private $id;
 private $nom;
 private $owner;
 private $column;
 private $particip;
 private $public; //maybe change 
 
 function __construct(int $nid, String $nnom, int $nowner, boolean $npublic, array $nparticip){
	$this -> id = $nid;
	$this -> nom = $nnom;
	$this -> owner = $nowner;
	$this -> ppublic = $npublic;
	$this -> particip = $nparticip;
	$this -> column = array();
 }
 
 public function getId(){
	return $this -> id;
 }
 
 public function getNom(){
	return $this -> nom;
 }
 
 public function getOwner(){
	return $this -> owner;
 }
 
 public function isPublic(){
 	return $this -> ppublic;
  }
 
 public function getParticipants(){
     return $this -> particip;
 }
 
 public function addParticipant(User $user){
	$this -> particip[] = $user;
 }
 
 public function getColumn(String $name){
	 return $this -> column[$name];
 }
 
 public function setColumns(array $colarray){
	$this -> column = $colArray;
 }
 
 public function addColumn(KanbanColumn $kanbanColumn){
	 
	 $this -> column[] = $kanbanColumn;
	 
 }
 
 public function getColumnId(string $colName){
	foreach($this -> column as $col){
		if($col -> name === $colName){
			return $col -> id;
		}
	}
	
	return null;
 }
 
 public static function addParticipant(Kanban $kanban, String $mail) {
	 try{
		$bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8','projet','tejorp');
				
		$request = $bdd -> prepare('select * from Users where mail = :mail;');
		$request -> execute(array('mail' => $mail));
		$uData = $request -> fetch();
		
		$request = $bdd -> prepare('insert into kanbanParticip values(:uid, :kid);');
		$request -> execute(array('uid' => $uData['id'], 'kid' => $kanban -> getid()));
		
		$kanban -> addParticipant(new User($uData['id'],$uData['mail'],$uData['password']));
		
		
	 } catch(PDOException $pdoe){
		print "Error with PDO: ".$pdoe -> getMessage()."<br/>";
		die();
	}
 }
 
 public static function createKanban(String $nom, int $ownerId, boolean $public, array $particip){
	
	try{
		
		$bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8','projet','tejorp');
		
		$request = $bdd->prepare('select id from Users where nom=:nom and owner:=:owner;');
		
		$request -> execute(array('nom'=>$nom,'owner'=>$owner));
		
		$data = $request -> fetch();
		
		if($nom != "" && $data == null){
			
			if($public){
				$public = 1;
			} else {
				$public = 0;
			}
			
			$request = $bdd -> prepare('insert into Kanbans values(id,:nom,:owner,:public);');
			$request -> execute(array('nom' => $nom, 'owner'=> $owner,'public' => $public));
			
			$request = $bdd -> prepare('select * from Kanbans where nom = :nom and owner = :owner;');
			$request -> execute(array('nom'=>$nom,'owner'=>$owner));
			
			$data = $request -> fetch();
			
			if($data == null){
				return null;
			} else {
				
				foreach($particip as $user){
					$request = $bdd -> prepare('select id from users where mail = :mail');
					$request -> execute(array('mail' => $user));
					
					$arrayUser = $request -> fetch();
					
					$request = $bdd -> prepare('insert into kanbanParticip values (:id, :user);');
				    $request -> execute(array('id' => $data['id'], 'user' => $arrayUser['id']));
				    $request = null;
                 }
				
				$request = $bdd -> prepare('select * from kanbanParticip where Kid = :id;');
				$request -> execute(array('id' => $data['id']));
				$verif = $request -> fetch();
				
				if($verif != null){
					
					KanbanColumn::createKanbanColumn("Stories", $data['id']);
					$kanban = KanbanColumn::createKanbanColumn("Terminées", $data[id]);
					
					return $kanban;
                } else {
                	return null;
                }
			}
			
		} else {
			return null;
		}
	} catch(PDOException $pdoe){
		print "Error with PDO: ".$pdoe -> getMessage()."<br/>";
		die();
	}
	
 }
 
 public static function getKanbanByName(String $nom){
	 try {
		
		$bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8','projet','tejorp');
		
		$request = $bdd -> prepare('select * from Kanban where nom=:nom');
		
		$request -> execute(array('nom'=> $nom));
		
		if($data = $request -> fetch()){
			
			$request = $bdd -> prepare('select Uid from kanbanParticip where Kid = :id');
			$request -> execute(array('id' => $data['id']));
			
			$particip = array();
			
			while($uData = $request -> fetch()){
				$request  = $bdd -> prepare('select * from users where id = :id');
				$request -> execute(array('id' => $uData['Uid']));
				$particip[] = new User($uData['id'], $uData['mail'], $uData['pwd']);
				$request = null;
			}
			
			$kanban = new Kanban($data['id'],$data['nom'], $data['owner'], $data['public'], $particip);
			
			$data = KanbanColumn::getAllKanbanColumns($kanban -> id);
			
			$kanban->setColumns($data);
			
			return $kanban;
			
		} else {
			return null;
		}
		
	 } catch(PDOException $pdoe){
		 print "Error with PDO : ". $pdeo->getMessage()."<br/>";
		 //peut être changer par $pdeo->errorInfo[2]; pour avoir les erreur sql
		 die();
	 }
 }
 
 public static function getKanbanById(int $id){
	 try {
		
		$bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8','projet','tejorp');
		
		$request = $bdd -> prepare('select * from Kanban where id=:id');
		
		$request -> execute(array('id'=> $id));
		
		if($data = $request -> fetch()){
			
			$request = $bdd -> prepare('select Uid from kanbanParticip where Kid = :id');
			$request -> execute(array('id' => $data['id']));
			
			$particip = array();
			
			while($uData = $request -> fetch()){
				$request  = $bdd -> prepare('select * from users where id = :id');
				$request -> execute(array('id' => $uData['Uid']));
				$particip[] = new User($uData['id'], $uData['mail'], $uData['pwd']);
				$request = null;
			}
			
			$kanban = new Kanban($data['id'],$data['nom'], $data['owner'], $data['public'], $particip);
			
			$data = KanbanColumn::getAllKanbanColumns($kanban -> id);
			
			$kanban->setColumns($data);
			
			return $kanban;
			
		} else {
			return null;
		}
		
	 } catch(PDOException $pdoe){
		 print "Error with PDO : ". $pdeo->getMessage()."<br/>";
		 //peut être changer par $pdeo->errorInfo[2]; pour avoir les erreur sql
		 die();
	 }
 }

 public static function getPublicsKanban(){
	 try{
		
		$bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8','projet','tejorp');
		
		$request = $bdd -> prepare('select * from kanbans where public = 1;');
		$request -> execute(array());
		
		$pKanban = array();
		while($data = $request -> fetch()){
			
			$request = $bdd -> prepare('select * from kanbanParticip where Kid = :id;');
			$request -> execute(array('id' => $data['id']));
			
			$uKanban = array();
			while($pData = $request -> fetch()){
				$request = $bdd -> prepare('select * from users where id = :id;');
				$request -> execute(array('id' => pData['Uid']));
				$UData = $request -> fetch();
				
				$uKanban[] = new Users($UData['id'], $Udata['mail'], $UData['password']);
			}
			
			$kanban = new Kanban($data['id'],$data['nom'],$data['owner'],$data['public'],uKanban);
			
			$request = $bdd -> prepare('select * from kanbanColumns where kanbanId = :id');
			$request -> execute(array('id' => $kanban -> getId()));
			
			while($cData = $request -> fetch()){
				$column = new KanbanColumn($cData['id'], $cData['nom']);
				
				$request = $bdd -> prepare('select * from kanbanItems where kanbanColumnId = :id;');
				$request -> execute(array('id' => $cData['id']));
				
				while($iData = $request -> fetch()){
					$item = new kanbanItem($iData['id'], $iData['title'], $iData['owner'], $iData['deadline']);
					
					$request = $bdd -> prepare('select * from kanbanItemParticip where KIid = :id');
					$request -> execute(array('id' => $iData['id']));
					
					while($uData = $request -> fetch()){
						
						foreach($uKanban as $user){
							if($user -> getId() == $uData['id']){
								$item -> addParticipant($user);
								break;
							}
						}
						
						$item -> addParticipant(new User($uData['id'],$uData['mail'], $uData['password']));
					}
					
					$column -> addItem($item);
					
				}
				
				$kanban -> addColumn($column);
			}
			
			$pKanban[] = $kanban;
		}
		
		return $pKanban;
		
	 } catch(PDOException $pdoe){
		 print "Error with PDO : ". $pdeo->getMessage()."<br/>";
		 //peut être changer par $pdeo->errorInfo[2]; pour avoir les erreur sql
		 die();
	 }
 }
 
 public static function getMyKanban(String $email){
	try{
		
		$bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8','projet','tejorp');		
		$request = $bdd -> prepare('select id from users where mail = :mail');
		$request -> execute(array('mail' => $email));
		$tmp = $request -> fetch();
		
		$request = $bdd -> prepare('select * from kanbans where owner = :id;');
		$request -> execute(array('id' => $tmp['id']));
		
		$pKanban = array();
		while($data = $request -> fetch()){
			
			$request = $bdd -> prepare('select * from kanbanParticip where Kid = :id;');
			$request -> execute(array('id' => $data['id']));
			
			$uKanban = array();
			while($pData = $request -> fetch()){
				$request = $bdd -> prepare('select * from users where id = :id;');
				$request -> execute(array('id' => pData['Uid']));
				$UData = $request -> fetch();
				
				$uKanban[] = new Users($UData['id'], $Udata['mail'], $UData['password']);
			}
			
			$kanban = new Kanban($data['id'],$data['nom'],$data['owner'],$data['public'],uKanban);
			
			$request = $bdd -> prepare('select * from kanbanColumns where kanbanId = :id');
			$request -> execute(array('id' => $kanban -> getId()));
			
			while($cData = $request -> fetch()){
				$column = new KanbanColumn($cData['id'], $cData['nom']);
				
				$request = $bdd -> prepare('select * from kanbanItems where kanbanColumnId = :id;');
				$request -> execute(array('id' => $cData['id']));
				
				while($iData = $request -> fetch()){
					$item = new kanbanItem($iData['id'], $iData['title'], $iData['owner'], $iData['deadline']);
					
					$request = $bdd -> prepare('select * from kanbanItemParticip where KIid = :id');
					$request -> execute(array('id' => $iData['id']));
					
					while($uData = $request -> fetch()){
						
						foreach($uKanban as $user){
							if($user -> getId() == $uData['id']){
								$item -> addParticipant($user);
								break;
							}
						}
						
						$item -> addParticipant(new User($uData['id'],$uData['mail'], $uData['password']));
					}
					
					$column -> addItem($item);
					
				}
				
				$kanban -> addColumn($column);
			}
			
			$pKanban[] = $kanban;
		}
		
		return $pKanban;
		
	 } catch(PDOException $pdoe){
		 print "Error with PDO : ".$pdeo->getMessage()."<br/>";
		 //peut être changer par $pdeo->errorInfo[2]; pour avoir les erreur sql
		 die();
	 }
 }

 public static function getKanbanAccessible(String $email){
	 try{
		
		$bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8','projet','tejorp');		
		$request = $bdd -> prepare('select id from users where mail = :mail');
		$request -> execute(array('mail' => $email));
		$tmp = $request -> fetch();
		
		
		$request = $bdd -> prepare('select * from kanbans where id in(select id from kanbanParticip where Uid = :uid);');
		$request -> execute(array('uid' => $tmp['id']));
		
		$pKanban = array();
		while($data = $request -> fetch()){
			
			$request = $bdd -> prepare('select * from kanbanParticip where Kid = :id;');
			$request -> execute(array('id' => $data['id']));
			
			$uKanban = array();
			while($pData = $request -> fetch()){
				$request = $bdd -> prepare('select * from users where id = :id;');
				$request -> execute(array('id' => pData['Uid']));
				$UData = $request -> fetch();
				
				$uKanban[] = new Users($UData['id'], $Udata['mail'], $UData['password']);
			}
			
			$kanban = new Kanban($data['id'],$data['nom'],$data['owner'],$data['public'],uKanban);
			
			$request = $bdd -> prepare('select * from kanbanColumns where kanbanId = :id');
			$request -> execute(array('id' => $kanban -> getId()));
			
			while($cData = $request -> fetch()){
				$column = new KanbanColumn($cData['id'], $cData['nom']);
				
				$request = $bdd -> prepare('select * from kanbanItems where kanbanColumnId = :id;');
				$request -> execute(array('id' => $cData['id']));
				
				while($iData = $request -> fetch()){
					$item = new kanbanItem($iData['id'], $iData['title'], $iData['owner'], $iData['deadline']);
					
					$request = $bdd -> prepare('select * from kanbanItemParticip where KIid = :id');
					$request -> execute(array('id' => $iData['id']));
					
					while($uData = $request -> fetch()){
						
						foreach($uKanban as $user){
							if($user -> getId() == $uData['id']){
								$item -> addParticipant($user);
								break;
							}
						}
						
						$item -> addParticipant(new User($uData['id'],$uData['mail'], $uData['password']));
					}
					
					$column -> addItem($item);
					
				}
				
				$kanban -> addColumn($column);
			}
			
			$pKanban[] = $kanban;
		}
		
		return $pKanban;
		
	 } catch(PDOException $pdoe){
		 print "Error with PDO : ". $pdeo->getMessage()."<br/>";
		 //peut être changer par $pdeo->errorInfo[2]; pour avoir les erreur sql
		 die();
	 }
 }
 

 }
?>