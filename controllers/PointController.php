<?php
require_once '../models/PointModel.php';
require_once '../models/DatabaseConnection.php';
// Creating a PDO connection
$pdoConnection = DatabaseConnection::getPDOConnection();

class PointController {
    private $recipientModel;

    public function __construct($dbConnection) {
        $this->recipientModel = new PointModel($dbConnection);
    }

    public function createRecipient($recipient_name, $recipient_address, $recipient_postalcode, $longitude_point, $latitude_point) {
        $result = $this->recipientModel->createRecipient($recipient_name, $recipient_address, $recipient_postalcode, $longitude_point, $latitude_point);
        echo $result ? 'Recipient created successfully' : 'Failed to create recipient';
    }

    public function getRecipientById($point_id) {
        $recipient = $this->recipientModel->getRecipientById($point_id);
        echo $recipient ? json_encode($recipient) : 'Recipient not found';
    }

    public function updateRecipient($point_id, $recipient_name, $recipient_address, $recipient_postalcode, $longitude_point, $latitude_point) {
        $result = $this->recipientModel->updateRecipient($point_id, $recipient_name, $recipient_address, $recipient_postalcode, $longitude_point, $latitude_point);
        echo $result ? 'Recipient updated successfully' : 'Failed to update recipient';
    }

    public function deleteRecipient($point_id) {
        $result = $this->recipientModel->deleteRecipient($point_id);
        echo $result ? 'Recipient deleted successfully' : 'Failed to delete recipient';
    }

    public function getAllRecipients() {
        $recipients = $this->recipientModel->getAllRecipients();
        echo json_encode($recipients);
    }
}

// Check if the script is accessed via a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pointController = new PointController($pdoConnection);

    // Retrieve form data
    $recipient_name = $_POST['recipient_name'];
    $recipient_address = $_POST['recipient_address'];
    $recipient_postalcode = $_POST['recipient_postalcode'];
    $longitude_point = $_POST['longitude_point'];
    $latitude_point = $_POST['latitude_point'];
    $operation = $_POST['operation'] ?? ''; // Get the operation

    // Check if it's a create or update operation
    if ($operation === 'create') {
        $pointController->createRecipient($recipient_name, $recipient_address, $recipient_postalcode, $longitude_point, $latitude_point);
    } elseif ($operation === 'update') {
        $point_id = $_POST['point_id']; // Make sure to retrieve this for updates
        $pointController->updateRecipient($point_id, $recipient_name, $recipient_address, $recipient_postalcode, $longitude_point, $latitude_point);
    }
}
?>