<?php
require_once 'PointModel.php';

class PointController {
    private $recipientModel;

    public function __construct($dbConnection) {
        $this->recipientModel = new RecipientModel($dbConnection);
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
?>