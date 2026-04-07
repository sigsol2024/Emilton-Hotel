<?php
/**
 * Rooms API Endpoint
 * Handle room CRUD operations
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireLogin();

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

try {
    switch ($method) {
        case 'GET':
            if (isset($_GET['id'])) {
                // Get single room
                $id = intval($_GET['id']);
                $stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = ?");
                $stmt->execute([$id]);
                $room = $stmt->fetch();
                
                if ($room) {
                    // Decode JSON fields
                    $room['gallery_images'] = json_decode($room['gallery_images'] ?? '[]', true);
                    $room['features'] = json_decode($room['features'] ?? '[]', true);
                    $room['amenities'] = json_decode($room['amenities'] ?? '[]', true);
                    $room['tags'] = json_decode($room['tags'] ?? '[]', true);
                    $room['included_items'] = json_decode($room['included_items'] ?? '[]', true);
                    $room['good_to_know'] = json_decode($room['good_to_know'] ?? '{}', true);
                    jsonResponse(['success' => true, 'room' => $room]);
                } else {
                    jsonResponse(['success' => false, 'message' => 'Room not found'], 404);
                }
            } else {
                // List rooms
                $page = max(1, intval($_GET['page'] ?? 1));
                $perPage = 20;
                $offset = ($page - 1) * $perPage;
                
                $where = [];
                $params = [];
                
                if (isset($_GET['status']) && $_GET['status'] !== '') {
                    $status = intval($_GET['status']);
                    $where[] = "is_active = ?";
                    $params[] = $status;
                }
                
                if (isset($_GET['featured']) && $_GET['featured'] !== '') {
                    $featured = intval($_GET['featured']);
                    $where[] = "is_featured = ?";
                    $params[] = $featured;
                }
                
                $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
                
                $countStmt = $pdo->prepare("SELECT COUNT(*) FROM rooms {$whereClause}");
                $countStmt->execute($params);
                $total = $countStmt->fetchColumn();
                
                $stmt = $pdo->prepare("SELECT * FROM rooms {$whereClause} ORDER BY display_order ASC, created_at DESC LIMIT ? OFFSET ?");
                $params[] = $perPage;
                $params[] = $offset;
                $stmt->execute($params);
                $rooms = $stmt->fetchAll();
                
                jsonResponse([
                    'success' => true,
                    'rooms' => $rooms,
                    'pagination' => [
                        'page' => $page,
                        'per_page' => $perPage,
                        'total' => $total,
                        'pages' => ceil($total / $perPage)
                    ]
                ]);
            }
            break;
            
        case 'POST':
            // Verify CSRF token for POST requests
            $headers = getAllHeaders();
            $csrfToken = $headers['X-CSRF-Token'] ?? ($_POST['csrf_token'] ?? '');
            if (!verifyCSRFToken($csrfToken)) {
                jsonResponse(['success' => false, 'message' => 'Invalid security token'], 403);
            }
            
            if ($action === 'reorder') {
                // Update display order
                $input = file_get_contents('php://input');
                $orders = json_decode($input, true);
                
                // Validate JSON
                if (json_last_error() !== JSON_ERROR_NONE) {
                    jsonResponse(['success' => false, 'message' => 'Invalid JSON data'], 400);
                }
                
                if (!is_array($orders)) {
                    jsonResponse(['success' => false, 'message' => 'Invalid data format'], 400);
                }
                
                $stmt = $pdo->prepare("UPDATE rooms SET display_order = ? WHERE id = ?");
                
                foreach ($orders as $order) {
                    if (!isset($order['order']) || !isset($order['id'])) {
                        continue;
                    }
                    $orderNum = intval($order['order']);
                    $orderId = intval($order['id']);
                    if ($orderId > 0) {
                        $stmt->execute([$orderNum, $orderId]);
                    }
                }
                
                jsonResponse(['success' => true, 'message' => 'Order updated successfully']);
                break;
            }
            
            // Create new room
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            
            // Validate JSON
            if (json_last_error() !== JSON_ERROR_NONE) {
                jsonResponse(['success' => false, 'message' => 'Invalid JSON data'], 400);
            }
            
            $title = sanitize($data['title'] ?? '');
            $slug = generateSlug($data['slug'] ?? $title);
            $price = floatval($data['price'] ?? 0);
            $roomType = sanitize($data['room_type'] ?? '');
            $maxGuests = intval($data['max_guests'] ?? 0);
            $description = sanitize($data['description'] ?? '');
            $shortDescription = sanitize($data['short_description'] ?? '');
            $mainImage = sanitize($data['main_image'] ?? '');
            $galleryImages = json_encode($data['gallery_images'] ?? []);
            $features = json_encode($data['features'] ?? []);
            $amenities = json_encode($data['amenities'] ?? []);
            $isFeatured = isset($data['is_featured']) ? intval($data['is_featured']) : 0;
            $isActive = isset($data['is_active']) ? intval($data['is_active']) : 1;
            $displayOrder = intval($data['display_order'] ?? 0);
            
            // New fields
            $rating = isset($data['rating']) ? intval($data['rating']) : 5;
            $ratingScore = isset($data['rating_score']) && $data['rating_score'] !== '' ? floatval($data['rating_score']) : null;
            $location = sanitize($data['location'] ?? '');
            $size = sanitize($data['size'] ?? '');
            $tags = json_encode($data['tags'] ?? []);
            $includedItems = json_encode($data['included_items'] ?? []);
            $goodToKnow = json_encode($data['good_to_know'] ?? []);
            $bookUrl = sanitize($data['book_url'] ?? '');
            $originalPrice = isset($data['original_price']) && $data['original_price'] !== '' ? floatval($data['original_price']) : null;
            $urgencyMessage = sanitize($data['urgency_message'] ?? '');
            
            // Check if slug exists
            $checkStmt = $pdo->prepare("SELECT id FROM rooms WHERE slug = ?");
            $checkStmt->execute([$slug]);
            if ($checkStmt->fetch()) {
                $slug .= '-' . time();
            }
            
            $stmt = $pdo->prepare("INSERT INTO rooms (title, slug, price, room_type, max_guests, description, short_description, main_image, gallery_images, features, amenities, is_featured, is_active, display_order, rating, rating_score, location, size, tags, included_items, good_to_know, book_url, original_price, urgency_message) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $title, $slug, $price, $roomType, $maxGuests, $description, $shortDescription,
                $mainImage, $galleryImages, $features, $amenities, $isFeatured, $isActive, $displayOrder,
                $rating, $ratingScore, $location, $size, $tags, $includedItems, $goodToKnow, $bookUrl, $originalPrice, $urgencyMessage
            ]);
            
            $roomId = $pdo->lastInsertId();
            
            jsonResponse([
                'success' => true,
                'message' => 'Room created successfully',
                'room_id' => $roomId
            ]);
            break;
            
        case 'PUT':
            // Verify CSRF token for PUT requests
            $headers = getAllHeaders();
            $csrfToken = $headers['X-CSRF-Token'] ?? ($_POST['csrf_token'] ?? '');
            if (!verifyCSRFToken($csrfToken)) {
                jsonResponse(['success' => false, 'message' => 'Invalid security token'], 403);
            }
            
            // Update room
            $id = intval($_GET['id'] ?? 0);
            if (!$id) {
                jsonResponse(['success' => false, 'message' => 'Invalid room ID'], 400);
            }
            
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            
            // Validate JSON
            if (json_last_error() !== JSON_ERROR_NONE) {
                jsonResponse(['success' => false, 'message' => 'Invalid JSON data'], 400);
            }

            $title = sanitize($data['title'] ?? '');
            $slug = generateSlug($data['slug'] ?? $title);
            $price = floatval($data['price'] ?? 0);
            $roomType = sanitize($data['room_type'] ?? '');
            $maxGuests = intval($data['max_guests'] ?? 0);
            $description = sanitize($data['description'] ?? '');
            $shortDescription = sanitize($data['short_description'] ?? '');
            $mainImage = sanitize($data['main_image'] ?? '');
            $galleryImages = json_encode($data['gallery_images'] ?? []);
            $features = json_encode($data['features'] ?? []);
            $amenities = json_encode($data['amenities'] ?? []);
            $isFeatured = isset($data['is_featured']) ? intval($data['is_featured']) : 0;
            $isActive = isset($data['is_active']) ? intval($data['is_active']) : 1;
            $displayOrder = intval($data['display_order'] ?? 0);
            
            // New fields
            $rating = isset($data['rating']) ? intval($data['rating']) : 5;
            $ratingScore = isset($data['rating_score']) && $data['rating_score'] !== '' ? floatval($data['rating_score']) : null;
            $location = sanitize($data['location'] ?? '');
            $size = sanitize($data['size'] ?? '');
            $tags = json_encode($data['tags'] ?? []);
            $includedItems = json_encode($data['included_items'] ?? []);
            $goodToKnow = json_encode($data['good_to_know'] ?? []);
            $bookUrl = sanitize($data['book_url'] ?? '');
            $originalPrice = isset($data['original_price']) && $data['original_price'] !== '' ? floatval($data['original_price']) : null;
            $urgencyMessage = sanitize($data['urgency_message'] ?? '');
            
            // Check if slug exists for different room
            $checkStmt = $pdo->prepare("SELECT id FROM rooms WHERE slug = ? AND id != ?");
            $checkStmt->execute([$slug, $id]);
            if ($checkStmt->fetch()) {
                $slug .= '-' . time();
            }
            
            $stmt = $pdo->prepare("UPDATE rooms SET title = ?, slug = ?, price = ?, room_type = ?, max_guests = ?, description = ?, short_description = ?, main_image = ?, gallery_images = ?, features = ?, amenities = ?, is_featured = ?, is_active = ?, display_order = ?, rating = ?, rating_score = ?, location = ?, size = ?, tags = ?, included_items = ?, good_to_know = ?, book_url = ?, original_price = ?, urgency_message = ? WHERE id = ?");
            $stmt->execute([
                $title, $slug, $price, $roomType, $maxGuests, $description, $shortDescription,
                $mainImage, $galleryImages, $features, $amenities, $isFeatured, $isActive, $displayOrder,
                $rating, $ratingScore, $location, $size, $tags, $includedItems, $goodToKnow, $bookUrl, $originalPrice, $urgencyMessage, $id
            ]);

            jsonResponse(['success' => true, 'message' => 'Room updated successfully']);
            break;
            
        case 'DELETE':
            // Verify CSRF token for DELETE requests
            $headers = getAllHeaders();
            $csrfToken = $headers['X-CSRF-Token'] ?? ($_GET['csrf_token'] ?? '');
            if (!verifyCSRFToken($csrfToken)) {
                jsonResponse(['success' => false, 'message' => 'Invalid security token'], 403);
            }
            
            // Delete room (hard delete - removes from database)
            $id = intval($_GET['id'] ?? 0);
            if (!$id) {
                jsonResponse(['success' => false, 'message' => 'Invalid room ID'], 400);
            }
            
            $stmt = $pdo->prepare("DELETE FROM rooms WHERE id = ?");
            $stmt->execute([$id]);
            
            jsonResponse(['success' => true, 'message' => 'Room deleted successfully']);
            break;
            
        default:
            jsonResponse(['success' => false, 'message' => 'Method not allowed'], 405);
    }
} catch(PDOException $e) {
    error_log("Rooms API error: " . $e->getMessage());
    jsonResponse(['success' => false, 'message' => 'Database error occurred'], 500);
} catch(Exception $e) {
    error_log("Rooms API error: " . $e->getMessage());
    jsonResponse(['success' => false, 'message' => 'An error occurred'], 500);
}

