<?php

	namespace App\Models;

	use MF\MODEL\Model;

	class Usuario extends Model{

		private $id;
		private $nome;
		private $email;
		private $senha;

		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo, $valor){
			$this->$atributo=$valor;
		}

		//SALVAR
		public function salvar(){
			$query="INSERT INTO usuarios(nome,email,senha)VALUES(:nome,:email,:senha)";
			$stmt=$this->db->prepare($query);
			$stmt->bindValue(':nome',$this->__get('nome'));
			$stmt->bindValue(':email',$this->__get('email'));
			$stmt->bindValue(':senha',$this->__get('senha')); //MD5()-> HASH DE 32 CARACTERES
			$stmt->execute();

			return $this;
		}

		//VALIDAR SE UM CADASTRO PODE SER FEITO
		public function validarCadastro(){
			$valido=true;

			if(strlen($this->__get('nome'))<3){
				$valido=false;
			}

			if(strlen($this->__get('email'))<3){
				$valido=false;
			}

			if(strlen($this->__get('senha'))<3){
				$valido=false;
			}

			return $valido;
		}

		//RECUPERAR UM USUÁRIO POR EMAIL
		public function getUsuarioPorEmail(){
			$query="SELECT nome,email FROM usuarios WHERE email=:email";
			$stmt=$this->db->prepare($query);
			$stmt->bindValue(':email',$this->__get('email'));
			$stmt->execute();

			return $stmt->fetchALL(\PDO::FETCH_ASSOC);
		}

		public function autenticar(){
			$query="SELECT id,nome,email FROM usuarios WHERE email=:email AND senha=:senha";
			$stmt=$this->db->prepare($query);
			$stmt->bindValue(':email',$this->__get('email'));
			$stmt->bindValue(':senha',$this->__get('senha'));
			$stmt->execute();

			return $stmt->fetchALL(\PDO::FETCH_ASSOC);
		}

	}

?>