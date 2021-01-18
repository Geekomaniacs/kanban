<?php

//namespace KanbanProject\Model;

class KanbanItem{
	private $id;
	private $title;
	private $owner;
	private $deadline;
	private $participant;
	
	function __construct($nid, $ntitle, $owner, $deadline){
		$this -> id = $nid;
		$this -> title = $ntitle;
		$this -> owner = $owner;
		$this -> deadline = $ndeadline;
		$this -> participant = array();
	}
	
	public function getId(){
		return $this -> id;
	}
	
	public function getTitle(){
		return $this -> title;
    }
    
    public function getDate(){
        return $this -> deadline;
    }
    
    public function getOwner(){
        return $this -> owner;
    }
    
	public function getParticipant(){
		return $this -> participant;
	}
	
    public function setParticipant($nparticip){
    	$this -> participant = $nparticip;
    }
	
	public function addParticipant($nuser){
		$this -> participant[] = $nuser;
	}
	
	public static funtction createKanbanItem($title, $deadline, $owner, $columnId, $parti){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8','projet','tejorp');
			
			$request = $bdd -> prepare('select * from kanbanItems where title = :title and kanbanColumnId = :columnId; ');
		    $request -> execute(array('title' => $title, 'columnId' => $columnId));
		    
		    $data = $request -> fetch();
			
			if($data != null){
				
				$request = $bdd -> prepare('insert into kanbanItems values(id,:title,:desc,:owner,:colid,to_date(:deadline));');
				$request -> execute(array('title' => $title, 'owner' => $owner -> id, 'colid' => $columnId, 'deadline' => $deadline));
				
				$request = $bdd -> prepare('select * from kanbanItems where title = :title and kanbanColumnId = :colid');
				$request -> execute(array('title' => $title, 'colid' => $columnId));
				
				$data = $request -> fetch();
				if($data != null){
				
					foreach($parti as $user){
						$request = $bdd -> prepare('insert into kanbanItemParticip values(:uid,:KIid)');
						$request -> execute(array('uid' => $user -> getId(), 'KIid' => $data['id']));
						$request = null;
						
					}
					
					$item = new KanbanItem($data['id'],$data['title'], $data['owner'], $data['deadline']);
					
					$item -> setParticipant($parti);
					
					return $item;
				} else {
					return null;
				}
				
			} else {
				return null;
			}
        } catch(PDOException $pdoe){
			print "Error with PDO: ".$pdoe ->getMessage()."<br/>";
			die();
		}
	}
	
	public static function addParticipantTo($user, $kanbanItem){
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8','projet','tejorp');
		
			$request = $bdd ->prepare('select * from users where id = :id');
			$request -> execute('id' => $user -> getId());
			
			if($request -> fetch() == null){
				return null;
			}
			
			$request = $bdd -> prepare('select * from kanbanItems where id = :id');
			$request -> execute('id' => $kanbanItem -> getId());
			
			if($request -> fetch() == null){
				return null;
			}
			
			$request = $bdd -> prepare('insert into kanbanItemParticip values(:uid,:kid)');
			$request -> execute('uid' => $user -> getId(), 'kid' => $kanbanItem -> getId());
			
			$kanbanItem -> addParticipant($user);
			
			return $kanbanItem;
			
			
		} catch(PDOException $pdoe){
			print "Error with PDO: ".$pdoe ->getMessage()."<br/>";
			die();
		}
	}
}
?>