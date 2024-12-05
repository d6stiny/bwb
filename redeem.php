<?php

require_once 'controllers/Auth.php';
require_once 'models/Bottle.php';

try {
    // Initialize auth and get current user
    $auth = new AuthController();
    $user = $auth->getCurrentUser();

    // Get and decode JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        throw new Exception('Invalid JSON input', 400);
    }

    // Validate required fields
    $bottleId = trim($input['bottleId'] ?? '');
    $bottleName = trim($input['bottleName'] ?? '');

    if (empty($bottleId)) {
        throw new Exception('Bottle ID is required', 400);
    }

    if (empty($bottleName)) {
        throw new Exception('Bottle name is required', 400);
    }

    // Validate input lengths
    if (strlen($bottleId) < 3) {
        throw new Exception('Bottle ID must be at least 3 characters', 400);
    }

    if (strlen($bottleName) < 3) {
        throw new Exception('Bottle name must be at least 3 characters', 400);
    }

    // Initialize bottle model and redeem bottle
    $bottleModel = new Bottle();
    $result = $bottleModel->redeem($bottleId, $user['id'], $bottleName);

    if (!$result) {
        throw new Exception('Bottle not found or already redeemed', 404);
    }

    // Return success response
    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'message' => 'Bottle redeemed successfully'
    ]);

} catch (Exception $e) {
    // Return error response
    http_response_code($e->getCode() ?: 500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}