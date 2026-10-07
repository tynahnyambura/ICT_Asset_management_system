<?php

session_start();

require_once "../db.php";

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {

    echo json_encode([
        "success" => false,
        "message" => "Please login first"
    ]);

    exit;
}


/* GET ASSETS */

if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $result = $conn->query(
        "SELECT * FROM assets
         ORDER BY id DESC"
    );

    $assets = [];

    while ($row = $result->fetch_assoc()) {

        $assets[] = $row;

    }

    echo json_encode([
        "success" => true,
        "assets" => $assets
    ]);

    exit;
}


/* ADD ASSET */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $asset_tag = $_POST["asset_tag"] ?? "";
    $asset_name = $_POST["asset_name"] ?? "";
    $category = $_POST["category"] ?? "";
    $brand = $_POST["brand"] ?? "";
    $model = $_POST["model"] ?? "";
    $serial_number = $_POST["serial_number"] ?? "";
    $purchase_date = $_POST["purchase_date"] ?? null;
    $purchase_cost = $_POST["purchase_cost"] ?? null;
    $location = $_POST["location"] ?? "";
    $condition_status = $_POST["condition_status"] ?? "Good";
    $asset_status = $_POST["asset_status"] ?? "Available";
    $description = $_POST["description"] ?? "";


    if (
        empty($asset_tag) ||
        empty($asset_name) ||
        empty($category)
    ) {

        echo json_encode([
            "success" => false,
            "message" => "Asset tag, name and category are required"
        ]);

        exit;
    }


    $sql = "INSERT INTO assets
    (
        asset_tag,
        asset_name,
        category,
        brand,
        model,
        serial_number,
        purchase_date,
        purchase_cost,
        location,
        condition_status,
        asset_status,
        description
    )

    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "sssssssisss",
        $asset_tag,
        $asset_name,
        $category,
        $brand,
        $model,
        $serial_number,
        $purchase_date,
        $purchase_cost,
        $location,
        $condition_status,
        $asset_status,
        $description
    );


    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Asset added successfully"
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Failed to add asset"
        ]);
    }

    exit;
}


/* DELETE ASSET */

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {

    parse_str(
        file_get_contents("php://input"),
        $_DELETE
    );

    $id = $_DELETE["id"] ?? 0;

    $stmt = $conn->prepare(
        "DELETE FROM assets WHERE id = ?"
    );

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {

        echo json_encode([
            "success" => true,
            "message" => "Asset deleted successfully"
        ]);

    } else {

        echo json_encode([
            "success" => false,
            "message" => "Failed to delete asset"
        ]);
    }

    exit;
}


echo json_encode([
    "success" => false,
    "message" => "Invalid request"
]);

?>
