<?php

class User {

	private Database $db;

	public function __construct() {
		$this->db = new Database();
	}

	public function emailExists($email,$role): bool {
		$this->db->query("SELECT * FROM users WHERE email = ? AND role = ?", $email,$role);
		return $this->db->rowCount() > 0;
	}

	public function correctPassword(string $email, string $password,$role): bool {
		$this->db->query("SELECT * FROM users where email = ? AND password = ? AND role = ?", $email, $password,$role);
		return $this->db->rowCount() > 0;
	}

	public function findUser(string $email): mixed {
		$this->db->query("SELECT * FROM users where email = ?", $email);
		return $this->db->singleRow();
	}

	public function register($data): bool {
		$this->db->query("INSERT INTO users (email, password, first_name, last_name,role) VALUES (?, ?, ?, ?, ?)",
			$data['email'], $data['pass'],$data['first_name'],$data['last_name'],"User");
		return $this->db->affectedRows() > 0;
	}

	public function createSession($user,string $role): void {
		$_SESSION[$role . '_email'] = $user->email;
		$_SESSION[$role . '_first_name'] = $user->first_name;
		$_SESSION[$role . '_last_name'] = $user->last_name;
	}

	public function logout(string $role): void {
		unset($_SESSION[$role . '_email'], $_SESSION[$role . '_first_name'], $_SESSION[$role . '_last_name']);
		session_destroy();
		redirect("pages/index");
	}
}