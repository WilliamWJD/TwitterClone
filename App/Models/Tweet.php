<?php

	namespace App\Models;

	use MF\MODEL\Model;

	class Tweet extends Model{
		private $id;
		private $id_usuario;
		private $tweet;
		private $data;

		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($valor,$atributo){
			$this->$atributo=$valor;
		}

		public function salvar(){
			$query="INSERT INTO tweets (id_usuario,tweet)VALUES(:id_usuario, :tweet)";
			$stmt=$this->db->prepare($query);
			$stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
			$stmt->bindValue(':tweet',$this->__get('tweet'));
			$stmt->execute();

			return $this;
		}

		public function getAll(){
			$query="SELECT id,id_usuario,tweet,data FROM tweets";
			$stmt=$this->db->prepare($query);
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}
	}

?>