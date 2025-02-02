<?php

/**
 * Room DAO
 */
class Room {

	private Database $db;

	public function __construct() {
		$this->db = new Database();
	}

	/**
	 * Main query of the whole application
	 * Finds free rooms for the given date range and given number of people
	 * @param string $arrival
	 * @param string $departure
	 * @param int $guests
	 * @return array|null
	 */
	public function findAllAvailable(string $arrival, string $departure, int $guests): ?array {
		$this->db->query("SELECT room_type, description, price * DATEDIFF(?,?) as cost, pets_allowed
						      FROM `rooms` JOIN room_types rt on rt.name = rooms.room_type
							  WHERE room_num not IN (
							      SELECT room_num
							      FROM reservations
							      WHERE (reservations.arrival between ? and ?) or
							          (reservations.departure between ? and ?)
							  ) AND rt.max_person >= ?
							  GROUP BY room_type"
			, $departure, $arrival, $arrival, $departure, $arrival, $departure, $guests);
		if ($this->db->rowCount() > 0)
			return $this->db->resultSet();
		else return null;
	}

	/**
	 * Second core query of the application
	 * Finds next free room number for the given room type
	 * @return int
	 */
	public function findNextFree(): int {
		$this->db->query("SELECT room_num
							  FROM `rooms` JOIN room_types rt on rt.name = rooms.room_type
							  WHERE room_num not IN (
							      SELECT room_num
							      FROM reservations
							      WHERE (reservations.arrival between ? and ?) or
							          (reservations.departure between ? and ?)
							  ) AND rt.name = ?
							  order by room_num
							  limit 1",
			date_format($_SESSION['booking']['arrival'],"Y-m-d"),
			date_format($_SESSION['booking']['departure'],"Y-m-d"),
			date_format($_SESSION['booking']['arrival'],"Y-m-d"),
			date_format($_SESSION['booking']['departure'],"Y-m-d"),
			$_SESSION['booking']['room_type']);
			return $this->db->singleRow()->room_num;
	}

	/**
	 * Filters rooms by specified criteria
	 * Also merges filters with main data array
	 * Uses FilterStatementBuilder to build the query
	 * @param array $data
	 * @return array|null - array of rooms or null if no rooms found
	 */
	public function filterRooms(array &$data): ?array {
		$filters = [
			'price' => isset($_GET['price']) ? extractPrice($_GET['price']) : null,
			'floor' => $_GET['floor'] ?? null,
			'pets' => isset($_GET['pets']) ? (int)$_GET['pets'] : null,
		];
		$data = array_merge($data, $filters);

		$statementBuilder = (new FilterStatementBuilder
		("SELECT room_type, description, price * DATEDIFF(?,?) as cost, pets_allowed
						      FROM `rooms` JOIN room_types rt on rt.name = rooms.room_type
							  WHERE room_num not IN (
							      SELECT room_num
							      FROM reservations
							      WHERE (reservations.arrival between ? and ?) or
							          (reservations.departure between ? and ?)
							  ) AND rt.max_person >= ?",
			[$data['departure'], $data['arrival'], $data['arrival'],
				$data['departure'], $data['arrival'], $data['departure'], $data['guests']]
		))->build($filters);

		$this->db->query($statementBuilder->getQuery(), ...$statementBuilder->getArgs());
		return $this->db->rowCount() > 0 ? $this->db->resultSet() : null;
	}

}