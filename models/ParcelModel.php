<?php
class ParcelModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    // Create a new parcel record
    public function createParcel($delivery_user, $recipient_id) { // Add $recipient_id parameter
        $sql = "INSERT INTO parcels (delivery_user, recipient_id) VALUES (?, ?)"; // Update SQL to include recipient_id
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$delivery_user, $recipient_id]); // Pass $recipient_id to the execute method
    }

    // Retrieve a parcel by ID
    public function getParcelById($parcel_id) {
        $sql = "SELECT parcel_id, delivery_user, parcel_status, recipient_id FROM parcels WHERE parcel_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$parcel_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update a parcel's delivery user and recipient
    public function updateParcel($parcel_id, $delivery_user, $recipient_id,  $parcel_status) {
        $sql = "UPDATE parcels SET delivery_user = ?, recipient_id = ?, parcel_status = ? WHERE parcel_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$delivery_user, $recipient_id, $parcel_status, $parcel_id]);
    }

    // Update only a parcel's status
    public function updateParcelStatusOnly($parcel_id, $parcel_status) {
        $sql = "UPDATE parcels SET parcel_status = ? WHERE parcel_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$parcel_status, $parcel_id]);
    }

    // Delete a parcel
    public function deleteParcel($parcel_id) {
        $sql = "DELETE FROM parcels WHERE parcel_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$parcel_id]);
    }

    // List all parcels
    public function getAllParcels() {
        $sql = "SELECT parcels.parcel_id, parcels.delivery_user, parcels.parcel_status, recipients.recipient_name 
                FROM parcels 
                JOIN recipients ON parcels.recipient_id = recipients.point_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch parcels assigned to a specific delivery user
    public function getParcelsByDeliveryUser($deliveryUser) {
        $sql = "SELECT parcels.parcel_id, parcels.delivery_user, parcels.parcel_status, recipients.recipient_name 
                FROM parcels 
                JOIN recipients ON parcels.recipient_id = recipients.point_id
                WHERE parcels.delivery_user = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$deliveryUser]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to get total parcels
    public function getTotalParcels() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM parcels");
        return $stmt->fetchColumn(); // fetchColumn() returns a single value directly
    }
}
?>
