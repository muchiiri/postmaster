<?php
class PointModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    // Create a new recipient record
    public function createRecipient($recipient_name, $recipient_address, $recipient_postalcode, $longitude_point, $latitude_point) {
        $sql = "INSERT INTO recipients (recipient_name, recipient_address, recipient_postalcode, longitude_point, latitude_point) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$recipient_name, $recipient_address, $recipient_postalcode, $longitude_point, $latitude_point]);
    }

    // Retrieve a recipient by point_id
    public function getRecipientById($point_id) {
        $sql = "SELECT point_id, recipient_name, recipient_address, recipient_postalcode, longitude_point, latitude_point 
                FROM recipients WHERE point_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$point_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update a recipient's information
    public function updateRecipient($point_id, $recipient_name, $recipient_address, $recipient_postalcode, $longitude_point, $latitude_point) {
        $sql = "UPDATE recipients SET recipient_name = ?, recipient_address = ?, recipient_postalcode = ?, longitude_point = ?, latitude_point = ?
                WHERE point_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$recipient_name, $recipient_address, $recipient_postalcode, $longitude_point, $latitude_point, $point_id]);
    }

    // Delete a recipient
    public function deleteRecipient($point_id) {
        $sql = "DELETE FROM recipients WHERE point_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$point_id]);
    }

    // List all recipients
    public function getAllRecipients() {
        $sql = "SELECT point_id, recipient_name, recipient_address, recipient_postalcode, longitude_point, latitude_point 
                FROM recipients";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
