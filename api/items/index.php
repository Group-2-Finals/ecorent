<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$db = "ecorent";

$conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n" . $conn->error);

try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$db", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (!$conn) {
    die("Connection Failed. " . mysqli_connect_error());
    echo "can't connect to database";
}

function executeQuery($query)
{
    $conn = $GLOBALS['conn'];
    return mysqli_query($conn, $query);
}

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

try {
    switch ($method) {
        case 'GET':
            handleGet($pdo);
            break;
        case 'POST':
            handlePost($pdo, $input);
            break;
        case 'PUT':
            handlePut($pdo, $input);
            break;
        case 'DELETE':
            handleDelete($pdo, $input);
            break;
        default:
            http_response_code(405);
            echo json_encode(['message' => 'Invalid request method']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['message' => 'Internal Server Error', 'error' => $e->getMessage()]);
}

function handleGet($pdo)
{
    try {
        $sql = "SELECT itemID, itemName, itemType, gasEmissionSaved, pricePerDay, itemSpecifications, location FROM items";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($result)) {
            http_response_code(404);
            echo json_encode(['message' => 'No items found']);
        } else {
            echo json_encode($result);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Database query error', 'error' => $e->getMessage()]);
    }
}
function handlePost($pdo, $input)
{
    if (empty($input) || !is_array($input)) {
        http_response_code(400);
        echo json_encode(['message' => 'Input must be a non-empty array']);
        return;
    }

    try {
        $sql = "INSERT INTO items (itemName, itemType, gasEmissionSaved, pricePerDay, itemSpecifications, location) 
        VALUES (:itemName, :itemType, :gasEmissionSaved, :pricePerDay, :itemSpecifications, :location)";

        $stmt = $pdo->prepare($sql);

        foreach ($input as $item) {
            if (!validateInput($item, ['itemName', 'itemType', 'gasEmissionSaved', 'pricePerDay', 'itemSpecifications', 'location'])) {
                http_response_code(400);
                echo json_encode(['message' => 'Missing required fields']);
                return;
            }

            if (is_numeric($item['itemType'])) {
                http_response_code(400);
                echo json_encode(['message' => 'itemType cannot be a number']);
                return;
            }

            if (!is_string($item['itemName']) || !is_string($item['itemType']) || !is_numeric($item['gasEmissionSaved']) || !is_numeric($item['pricePerDay'])) {
                http_response_code(400);
                echo json_encode(['message' => 'Invalid data types for one or more fields']);
                return;
            }

            $checkSql = "SELECT COUNT(*) FROM items WHERE itemName = :itemName AND location = :location";
            $checkStmt = $pdo->prepare($checkSql);
            $checkStmt->execute([
                'itemName' => $item['itemName'],
                'location' => $item['location']
            ]);
            $duplicateCount = $checkStmt->fetchColumn();

            if ($duplicateCount > 0) {
                http_response_code(409);
                echo json_encode(['message' => 'Item with the same name and location already exists']);
                return;
            }

            $stmt->execute([
                'itemName' => $item['itemName'],
                'itemType' => $item['itemType'],
                'gasEmissionSaved' => $item['gasEmissionSaved'],
                'pricePerDay' => $item['pricePerDay'],
                'itemSpecifications' => $item['itemSpecifications'],
                'location' => $item['location'],
            ]);
        }

        http_response_code(201);
        echo json_encode(['message' => 'Items created successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Database insertion error', 'error' => $e->getMessage()]);
    }
}


function handlePut($pdo, $input)
{
    if (empty($input) || !is_array($input)) {
        http_response_code(400);
        echo json_encode(['message' => 'Input must be a non-empty array']);
        return;
    }

    try {
        $sql = "UPDATE items SET
            itemName = :itemName,
            itemType = :itemType,
            gasEmissionSaved = :gasEmissionSaved,
            pricePerDay = :pricePerDay,    
            itemSpecifications = :itemSpecifications,
            location = :location
            WHERE itemID = :itemID";

        $stmt = $pdo->prepare($sql);

        foreach ($input as $item) {
            if (!validateInput($item, ['itemID', 'itemName', 'itemType', 'gasEmissionSaved', 'pricePerDay', 'itemSpecifications', 'location'])) {
                http_response_code(400);
                echo json_encode(['message' => 'Missing required fields']);
                return;
            }

           
            if (is_numeric($item['itemType'])) {
                http_response_code(400);
                echo json_encode(['message' => 'itemType cannot be a number']);
                return;
            }

            if (!is_numeric($item['itemID']) || !is_string($item['itemName']) || !is_string($item['itemType']) || !is_numeric($item['gasEmissionSaved']) || !is_numeric($item['pricePerDay'])) {
                http_response_code(400);
                echo json_encode(['message' => 'Invalid data types for one or more fields']);
                return;
            }

            $checkSql = "SELECT COUNT(*) FROM items WHERE itemName = :itemName AND location = :location AND itemID != :itemID";
            $checkStmt = $pdo->prepare($checkSql);
            $checkStmt->execute([
                'itemName' => $item['itemName'],
                'location' => $item['location'],
                'itemID' => $item['itemID'] 
            ]);
            $duplicateCount = $checkStmt->fetchColumn();

            if ($duplicateCount > 0) {
                http_response_code(409); 
                echo json_encode(['message' => 'Item with the same name and location already exists']);
                return;
            }

            $stmt->execute([
                'itemName' => $item['itemName'],
                'itemType' => $item['itemType'],
                'gasEmissionSaved' => $item['gasEmissionSaved'],
                'pricePerDay' => $item['pricePerDay'],
                'itemSpecifications' => $item['itemSpecifications'],
                'location' => $item['location'],
                'itemID' => $item['itemID']
            ]);
        }

        http_response_code(200);
        echo json_encode(['message' => 'Items updated successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Database update error', 'error' => $e->getMessage()]);
    }
}

function handleDelete($pdo, $input)
{
    if (empty($input) || !is_array($input)) {
        http_response_code(400);
        echo json_encode(['message' => 'Input must be a non-empty array of IDs']);
        return;
    }

    foreach ($input as $item) {
        if (!isset($item['itemID']) || !is_numeric($item['itemID'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Each item must contain a valid itemID']);
            return;
        }
    }

    $itemIDs = array_map(function ($item) {
        return $item['itemID'];
    }, $input);

    try {
        $placeholders = implode(',', array_fill(0, count($itemIDs), '?'));
        $sql = "DELETE FROM items WHERE itemID IN ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($itemIDs); 

        http_response_code(200);
        echo json_encode(['message' => 'Items deleted successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Database deletion error', 'error' => $e->getMessage()]);
    }
}

function validateInput($input, $requiredFields)
{
    foreach ($requiredFields as $field) {
        if (empty($input[$field])) {
            return false;
        }
    }
    return true;
}

?>