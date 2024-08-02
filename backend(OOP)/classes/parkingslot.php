<?php
require_once '../config/db.php';


class ParkingSlot {
    private $conn;
    private $table = "parking_slots";

    // Variables with data types
    private int $id;
    private int $slotTypeId;
    private string $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Getter and Setter methods
    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getSlotTypeId(): int {
        return $this->slotTypeId;
    }

    public function setSlotTypeId(int $slotTypeId): void {
        $this->slotTypeId = $slotTypeId;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function createParkingSlot($slotTypeId, $status) {
        $stmt = $this->conn->prepare("INSERT INTO $this->table (slotTypeId, status) VALUES (?, ?)");
        if ($stmt->execute([$slotTypeId, $status])) {
            return ['success' => true, 'message' => 'Parking slot created'];
        }
        return ['success' => false, 'message' => 'Error: ' . $stmt->errorInfo()[2]];
    }

    public function getParkingSlotDetails($parkingSlotId) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->execute([$parkingSlotId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateParkingSlot($parkingSlotId, $slotTypeId, $status) {
        $stmt = $this->conn->prepare("UPDATE $this->table SET slotTypeId = ?, status = ? WHERE id = ?");
        if ($stmt->execute([$slotTypeId, $status, $parkingSlotId])) {
            return ['success' => true, 'message' => 'Parking slot updated'];
        }
        return ['success' => false, 'message' => 'Error: ' . $stmt->errorInfo()[2]];
    }

    public function deleteParkingSlot($parkingSlotId) {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = ?");
        if ($stmt->execute([$parkingSlotId])) {
            return ['success' => true, 'message' => 'Parking slot deleted'];
        }
        return ['success' => false, 'message' => 'Error: ' . $stmt->errorInfo()[2]];
    }
}
?>