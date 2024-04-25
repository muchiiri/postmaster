<?php
require_once '../models/ParcelModel.php';
require_once '../models/DatabaseConnection.php';
// Creating a PDO connection
$pdoConnection = DatabaseConnection::getPDOConnection();

class ParcelController {
    private $parcelModel;

    public function __construct($dbConnection) {
        $this->parcelModel = new ParcelModel($dbConnection);
    }

    public function createParcel($delivery_user, $recipient_id) { // Add $recipient_id parameter
        $result = $this->parcelModel->createParcel($delivery_user, $recipient_id); // Pass $recipient_id to the model
        echo $result ? 'Parcel created successfully' : 'Failed to create parcel';
    }

    public function getParcelById($parcel_id) {
        $parcel = $this->parcelModel->getParcelById($parcel_id);
        echo $parcel ? json_encode($parcel) : 'Parcel not found';
    }

    public function updateParcel($parcel_id, $delivery_user, $recipient_id, $parcel_status, $user_type) {
        if ($user_type === 'admin') {
            $result = $this->parcelModel->updateParcel($parcel_id, $delivery_user, $recipient_id, $parcel_status);
        } else if ($user_type === 'delivery_user') {
            $result = $this->parcelModel->updateParcelStatusOnly($parcel_id, $parcel_status);
        } else {
            echo 'Unauthorized operation';
            return;
        }
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

// At the bottom of the ParcelController.php file

// Check if the script is accessed via a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dbConnection = DatabaseConnection::getPDOConnection();
    $parcelController = new ParcelController($dbConnection);

    // Retrieve common fields from the POST request
    $delivery_user = $_POST['delivery_user'] ?? '';
    $recipient_id = $_POST['recipient'] ?? '';
    $parcel_status = $_POST['status'] ?? '';
    $operation = $_POST['operation'] ?? '';

    // Determine the operation to perform
    if ($operation === 'create') {
        // Call the createParcel method with the form data
        $parcelController->createParcel($delivery_user, $recipient_id);
    } elseif ($operation === 'update') {
        // Make sure to retrieve the parcel_id for update operations
        $parcel_id = $_POST['parcel_id'] ?? '';
        $user_type = $_POST['user_type'] ?? '';
        // Call the updateParcel method with the form data
        $parcelController->updateParcel($parcel_id, $delivery_user, $recipient_id, $parcel_status, $user_type);
    }

    // Optionally, redirect to a confirmation page or back to the form
    // header('Location: path/to/confirmation_or_form_page.php');
    // exit;
}
?>