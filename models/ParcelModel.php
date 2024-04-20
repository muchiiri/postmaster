<?php
class ParcelModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    // Create a new parcel record
    public function createParcel($delivery_user) {
        $sql = "INSERT INTO parcels (delivery_user) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$delivery_user]);
    }

    // Retrieve a parcel by ID
    public function getParcelById($parcel_id) {
        $sql = "SELECT parcel_id, delivery_user FROM parcels WHERE parcel_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$parcel_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update a parcel's delivery user
    public function updateParcel($parcel_id, $delivery_user) {
        $sql = "UPDATE parcels SET delivery_user = ? WHERE parcel_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$delivery_user, $parcel_id]);
    }

    // Delete a parcel
    public function deleteParcel($parcel_id) {
        $sql = "DELETE FROM parcels WHERE parcel_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$parcel_id]);
    }

    // List all parcels
    public function getAllParcels() {
        $sql = "SELECT parcel_id, delivery_user FROM parcels";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
