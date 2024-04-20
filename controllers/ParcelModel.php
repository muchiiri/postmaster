<?php
require_once 'ParcelModel.php';

class ParcelController {
    private $parcelModel;

    public function __construct($dbConnection) {
        $this->parcelModel = new ParcelModel($dbConnection);
    }

    public function createParcel($delivery_user) {
        $result = $this->parcelModel->createParcel($delivery_user);
        echo $result ? 'Parcel created successfully' : 'Failed to create parcel';
    }

    public function getParcelById($parcel_id) {
        $parcel = $this->parcelModel->getParcelById($parcel_id);
        echo $parcel ? json_encode($parcel) : 'Parcel not found';
    }

    public function updateParcel($parcel_id, $delivery_user) {
        $result = $this->parcelModel->updateParcel($parcel_id, $delivery_user);
        echo $result ? 'Parcel updated successfully' : 'Failed to update parcel';
    }

    public function deleteParcel($parcel_id) {
        $result = $this->parcelModel->deleteParcel($parcel_id);
        echo $result ? 'Parcel deleted successfully' : 'Failed to delete parcel';
    }

    public function getAllParcels() {
        $parcels = $this->parcelModel->getAllParcels();
        echo json_encode($parcels);
    }
}
?>
