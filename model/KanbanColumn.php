<?php

namespace KanbanProject\Model;

class KanbanColumn {
	private $id;
	private $nom;
	
	function __construct($nid, $nnom){
		$this -> id = $nid;
		$this -> nom = $nnom;
	}
	
	public function getId(){
		return $this -> id;
	}
	
	public function getNom(){
		return $this -> nom;
	}
	
	public static function createKanbanColumn($nom, $kanbanId){
		
		try{
			
			$bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8','projet','tejorp');
			
			$request = $bdd->prepare('select id from KanbanColumns where nom = :nom and kanbanid = :kanbanId; ');
			
			$request -> execute(array('nom'=> $nom, 'kanbanid'=>$kanbanid));
			
			$data = $request -> fetch();
			
			if($nom != "" && $data == null){
				$request = $bdd -> prepare('insert into KanbanColumns values(id,:nom,:kanbanid);');
				$request -> execute(array('nom'=>$nom,'kanbanid'=>$kanbanid));
				
				$request = $bdd -> prepare('select * from KanbanColumns where nom = :nom && kanbanid = :kanbanid;');
				$request -> execute(array('nom'=>$nom, 'kanbanid' => $kanbanid));
				
				$data = $request -> fetch();
				
				if($data == null){
					return null;
				} else {
					
					$kanban = Kanban::getKanbanById($kanbanId);
					
					if($kanban != null){
						$kanban -> addColumn(new KanbanColumn($data['id'], $data['nom']));
					
						return $kanban;
					} else {
						return null;
					}
				}
				
			} else {
				return null;
			}
			
		} catch(PDOException $pdoe){
			print "Error with PDO: ".$pdoe ->getMessage()."<br/>";
			die();
		}
		
	}
	
	/**
	* Renvois toute les colonne associé au kanban d'id $kanbanId (potentiellement useless)
	*/
	public static function getAllKanbanColumns($kanbanId) {
	 try {
		
		$request = $bdd -> prepare('select * from KanbanColumns where kanbanId=:kanbanid');
		
		$request -> execute(array('kanbanid'=> $kanbanId));
		
		$ret = array();
		while($data = $request -> fetch()){
			$kanbanColumn = new KanbanColumn($data['id'],$data['nom']);
			
			$ret[] = $kanbanColumn;
		}
		
		return $ret;
		
	 } catch(PDOException pdoe){
		 print "Error with PDO : " $pdeo->getMessage()."<br/>";
		 //peut être changer par $pdeo->errorInfo[2]; pour avoir les erreur sql
		 die();
	 }
 }
}

?>