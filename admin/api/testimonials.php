<?php
/**
 * Testimonials API Endpoint
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

requireLogin();

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($method) {
        case 'GET':
            // List testimonials
            $page = max(1, intval($_GET['page'] ?? 1));
            $perPage = 20;
            $offset = ($page - 1) * $perPage;
            
            $where = [];
            $params = [];
            
            if (isset($_GET['status']) && $_GET['status'] !== '') {
                $where[] = "is_active = ?";
                $params[] = intval($_GET['status']);
            }
            
            $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
            
            $countStmt = $pdo->prepare("SELECT COUNT(*) FROM testimonials {$whereClause}");
            $countStmt->execute($params);
            $total = $countStmt->fetchColumn();
            
            $stmt = $pdo->prepare("SELECT * FROM testimonials {$whereClause} ORDER BY display_order ASC, created_at DESC LIMIT ? OFFSET ?");
            $params[] = $perPage;
            $params[] = $offset;
            $stmt->execute($params);
            $testimonials = $stmt->fetchAll();
            
            jsonResponse([
                'success' => true,
                'testimonials' => $testimonials,
                'pagination' => [
                    'page' => $page,
                    'per_page' => $perPage,
                    'total' => $total,
                    'pages' => ceil($total / $perPage)
                ]
            ]);
            break;
            
        case 'POST':
            // Verify CSRF token
            $headers = getAllHeaders();
            $csrfToken = $headers['X-CSRF-Token'] ?? ($_POST['csrf_token'] ?? '');
            if (!verifyCSRFToken($csrfToken)) {
                jsonResponse(['success' => false, 'message' => 'Invalid security token'], 403);
            }
            
            // Create testimonial
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            
            // Validate JSON
            if (json_last_error() !== JSON_ERROR_NONE) {
                jsonResponse(['success' => false, 'message' => 'Invalid JSON data'], 400);
            }
            
            $authorName = sanitize($data['author_name'] ?? '');
            $quote = sanitize($data['quote'] ?? '');
            $rating = max(1, min(5, intval($data['rating'] ?? 5)));
            $isActive = isset($data['is_active']) ? intval($data['is_active']) : 1;
            $displayOrder = intval($data['display_order'] ?? 0);
            
            if (empty($authorName) || empty($quote)) {
                jsonResponse(['success' => false, 'message' => 'Author name and quote are required'], 400);
            }
            
            $stmt = $pdo->prepare("INSERT INTO testimonials (author_name, quote, rating, is_active, display_order) 
                                   VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$authorName, $quote, $rating, $isActive, $displayOrder]);
            
            $testimonialId = $pdo->lastInsertId();
            
            jsonResponse([
                'success' => true,
                'message' => 'Testimonial created successfully',
                'testimonial_id' => $testimonialId
            ]);
            break;
            
        case 'PUT':
            // Verify CSRF token
            $headers = getAllHeaders();
            $csrfToken = $headers['X-CSRF-Token'] ?? ($_POST['csrf_token'] ?? '');
            if (!verifyCSRFToken($csrfToken)) {
                jsonResponse(['success' => false, 'message' => 'Invalid security token'], 403);
            }
            
            // Update testimonial
            $id = intval($_GET['id'] ?? 0);
            if (!$id) {
                jsonResponse(['success' => false, 'message' => 'Invalid testimonial ID'], 400);
            }
            
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);
            
            // Validate JSON
            if (json_last_error() !== JSON_ERROR_NONE) {
                jsonResponse(['success' => false, 'message' => 'Invalid JSON data'], 400);
            }
            
            $authorName = sanitize($data['author_name'] ?? '');
            $quote = sanitize($data['quote'] ?? '');
            $rating = max(1, min(5, intval($data['rating'] ?? 5)));
            $isActive = isset($data['is_active']) ? intval($data['is_active']) : 1;
            $displayOrder = intval($data['display_order'] ?? 0);
            
            $stmt = $pdo->prepare("UPDATE testimonials SET author_name = ?, quote = ?, rating = ?, is_active = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$authorName, $quote, $rating, $isActive, $displayOrder, $id]);
            
            jsonResponse(['success' => true, 'message' => 'Testimonial updated successfully']);
            break;
            
        case 'DELETE':
            // Verify CSRF token
            $csrfToken = $_GET['csrf_token'] ?? '';
            if (!verifyCSRFToken($csrfToken)) {
                jsonResponse(['success' => false, 'message' => 'Invalid security token'], 403);
            }
            
            // Delete testimonial
            $id = intval($_GET['id'] ?? 0);
            if (!$id) {
                jsonResponse(['success' => false, 'message' => 'Invalid testimonial ID'], 400);
            }
            
            $stmt = $pdo->prepare("DELETE FROM testimonials WHERE id = ?");
            $stmt->execute([$id]);
            
            jsonResponse(['success' => true, 'message' => 'Testimonial deleted successfully']);
            break;
            
        default:
            jsonResponse(['success' => false, 'message' => 'Method not allowed'], 405);
    }
} catch(PDOException $e) {
    error_log("Testimonials API error: " . $e->getMessage());
    jsonResponse(['success' => false, 'message' => 'Database error occurred'], 500);
}

