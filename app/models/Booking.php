<?php

/**
 * Booking DAO
 */
class Booking {

	/**
	 * Database handler instance
	 * @var Database
	 */
	private Database $db;

	/**
	 * To generate id for booking
	 * @var RandomStringGenerator
	 */
	private RandomStringGenerator $generator;

	/**
	 * @var int
	 */
	private static int $idLength = 10;

	public function __construct() {
		$this->db = new Database();
		$this->generator = new RandomStringGenerator();
	}

	/**
	 * Function to create booking
	 * @param Room $roomModel
	 * @return array
	 */
	private function generateBookingData(Room $roomModel): array {
		return [
			'bookingID' => $this->generator->generate(Booking::$idLength),
			'userEmail' => $_SESSION['user_email'],
			'guestID' => $this->createGuest(),
			'roomNum' => $roomModel->findNextFree(),
			'guest' => $_SESSION['booking']['guests'],
			'arrival' => date_format($_SESSION['booking']['arrival'], "Y-m-d"),
			'departure' => date_format($_SESSION['booking']['departure'], "Y-m-d"),
			'total' => $_SESSION['booking']['total_costs'],
		];
	}

	/**
	 * Complex method to create booking
	 * Firstly inserts reservation data into reservation table
	 * Then checks if there are any services selected and inserts them into reservation_services table
	 * Finally creates a new entry in reservation_events table with new status
	 * @param Room $roomModel
	 * @return bool
	 */
	public function createBooking(Room $roomModel): bool {
		$data = $this->generateBookingData($roomModel);
		$this->db->query("insert into reservations
    						  (res_id, user_email, guest_id, room_num, guests, arrival, departure, total_price)
							  values (?,?,?,?,?,?,?,?)", ...$data);
		if ($this->db->affectedRows() > 0) {
			if (isset($_SESSION['booking']['services'])) {
				$success = $this->addServices($data['bookingID']);
				if (!$success)
					return false;
			}
			if ($this->addEvent($data['bookingID'], "new", "New booking created by user " . $_SESSION['user_email'])) {
				unset($_SESSION['guest'], $_SESSION['booking']);
				return true;
			}
		}
		return false;
	}

	/**
	 * Adds a new status event to the database
	 * @param string $bookingID
	 * @param string $status
	 * @param string $details
	 * @return bool
	 */
	public function addEvent(string $bookingID, string $status, string $details): bool {
		$this->db->query("insert into 
    						  reservation_events (res_id, user_email, status, details)
							  values (?,?,?,?)", $bookingID, $_SESSION['user_email'], $status, $details);
		return $this->db->affectedRows() > 0;
	}

	/**
	 * Loop through services and add them to the database
	 * @param string $bookingID
	 * @return bool
	 */
	public function addServices(string $bookingID): bool {
		foreach ($_SESSION['booking']['services'] as $name => $price) {
			$this->db->query("INSERT INTO 
    							  reservation_services (res_id, service_name)
								  VALUES (?,?);", $bookingID, $name);
			if ($this->db->affectedRows() < 1)
				return false;
		}
		return true;
	}

	/**
	 * Method to insert guest data into database
	 * @return int
	 */
	public function createGuest(): int {
		$this->db->query("INSERT INTO 
    						  motelx.guests (first_name, last_name, address, city, dob, phone)
							  VALUES (?,?,?,?,?,?)",
			$_SESSION['guest']['first_name'],
			$_SESSION['guest']['last_name'],
			$_SESSION['guest']['address'],
			$_SESSION['guest']['city'],
			$_SESSION['guest']['dob'],
			$_SESSION['guest']['phone']);
		return $this->db->lastInsertID();
	}

	/**
	 * Same as below but for single booking
	 * @param string $resId
	 * @return mixed
	 */
	public function fetchSingle(string $resId): mixed {
		$this->db->query("SELECT r.res_id,
       						  r.user_email,
       						  g.first_name,
       						  g.last_name,
       						  g.address,
       						  g.city,
       						  g.phone,
       						  r.room_num,
       						  rt.name,
       						  rt.price * datediff(r.departure, r.arrival) as room_price,
       						  r.guests,
       						  rooms.floor,
       						  r.arrival,
       						  r.departure,
       						  datediff(r.departure, r.arrival) as nights,
       						  r.transaction_date,
       						  re1.status,
       						  r.total_price,
       						  GROUP_CONCAT(service_name) as services
							  FROM reservations r
							           JOIN reservation_events re1 on r.res_id = re1.res_id
							           JOIN reservation_services rs on r.res_id = rs.res_id
							           JOIN guests g on g.guest_id = r.guest_id
							           JOIN rooms on rooms.room_num = r.room_num
							           JOIN room_types rt on rooms.room_type = rt.name
							  WHERE re1.created_at = (SELECT MAX(re2.created_at)
							                          FROM reservation_events re2
							                          WHERE re1.res_id = re2.res_id)
							  AND r.res_id = ?
							  GROUP BY r.res_id, r.transaction_date
							  order by r.transaction_date", $resId);
		return $this->db->singleRow();
	}

	/**
	 * Method for fetching all bookings
	 * Where clause is used for picking the latest status update event for each booking
	 * @return array|null
	 */
	public function fetchAll(): ?array {
		$this->db->query("SELECT r.res_id,
							         r.user_email,
							         g.first_name,
							         g.last_name,
							         g.address,
							         g.city,
							         g.phone,
							         r.room_num,
							         r.guests,
							         r.arrival,
							         r.departure,
							         r.transaction_date,
							         re1.status,
							         r.total_price,
							         GROUP_CONCAT(service_name) as services
							  FROM reservations r
							           JOIN reservation_events re1 on r.res_id = re1.res_id
							           JOIN reservation_services rs on r.res_id = rs.res_id
							           JOIN guests g on g.guest_id = r.guest_id
							  WHERE re1.created_at = (SELECT MAX(re2.created_at)
							                         from reservation_events re2
							                         where re1.res_id = re2.res_id)
							  GROUP BY r.res_id, r.transaction_date
							  order by r.transaction_date desc");
		if ($this->db->rowCount() > 0)
			return $this->db->resultSet();
		else return null;
	}

	/**
	 * Method to update the status of a reservation by
	 * inserting a new event into the reservation_events table
	 * @param string $res_id
	 * @param string $status
	 * @return bool
	 */
	public function changeStatus(string $res_id, string $status): bool {
		$this->db->query("INSERT INTO reservation_events (res_id, user_email, status, details)
							  VALUES (?,?,?,?)", $res_id, $_SESSION['admin_email'], $status, "");
		return $this->db->affectedRows() > 0;
	}

	/**
	 * Method to fetch bookings of specific status
	 * Used in admin dashboard
	 * @param string $status
	 * @return array|null
	 */
	public function filter(string $status): ?array {
		$this->db->query("SELECT r.res_id,
							         r.user_email,
							         g.first_name,
							         g.last_name,
							         g.address,
							         g.city,
							         g.phone,
							         r.room_num,
							         r.guests,
							         r.arrival,
							         r.departure,
							         r.transaction_date,
							         re1.status,
							         r.total_price,
							         GROUP_CONCAT(service_name) as services
							  FROM reservations r
							           JOIN reservation_events re1 on r.res_id = re1.res_id
							           JOIN reservation_services rs on r.res_id = rs.res_id
							           JOIN guests g on g.guest_id = r.guest_id
							  WHERE re1.created_at = (SELECT MAX(re2.created_at)
							                         from reservation_events re2
							                         where re1.res_id = re2.res_id)
							  		AND re1.status = ?
							  GROUP BY r.res_id, r.transaction_date
							  order by r.transaction_date", $status);
		if ($this->db->rowCount() > 0)
			return $this->db->resultSet();
		else return null;
	}

}