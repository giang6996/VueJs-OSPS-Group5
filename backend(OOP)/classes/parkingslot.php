<?php
require_once '../configs/db.php';


class ParkingSlot {
    private $conn;
    private $table = "parking_slots";

    // Variables with data types
    private int $id;
    private string $slotName;
    private int $slotTypeId;
    private string $status;
    private float $price;

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

    public function getSlotName(): string {
        return $this->slotName;
    }
    public function setSlotName(string $slotName): void {
        $this->slotName = $slotName;
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

    public function getPrice(): float {
        return $this->price;
    }

    public function setPrice(float $price): void {
        $this->price = $price;
    }

    public function createParkingSlot($slotName, $slotTypeId, $status, $price) {
        $stmt = $this->conn->prepare("INSERT INTO $this->table (slotName, slotTypeId, status, price) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$slotName, $slotTypeId, $status, $price])) {
            return ['success' => true, 'message' => 'Parking slot created'];
        }
        return ['success' => false, 'message' => 'Error: ' . $stmt->errorInfo()[2]];
    }

    public function getParkingSlotDetails($parkingSlotId) {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->execute([$parkingSlotId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getParkingSlotAll() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getParkingSlotAvailable() {
        $stmt = $this->conn->prepare("SELECT * FROM $this->table WHERE status = 1 ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateParkingSlot($parkingSlotId, $slotTypeId, $status, $price) {
        $stmt = $this->conn->prepare("UPDATE $this->table SET slotTypeId = ?, status = ?, price = ? WHERE id = ?");
        if ($stmt->execute([$slotTypeId, $status, $price, $parkingSlotId])) {
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

    public function updateAvailability($id, $status) {
        $stmt = $this->conn->prepare("UPDATE $this->table SET status = ? WHERE id = ?");
        if ($stmt->execute([$status, $id])) {
            return ['success' => true, 'message' => 'Availability updated'];
        }
        return ['success' => false, 'message' => 'Error: ' . $stmt->errorInfo()[2]];
    }
}
?>
