<?php
/**
 * Pages List
 * List all pages and allow editing
 */

$pageTitle = 'Pages';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

// Define available pages with their editors
$availablePages = [
    'index' => [
        'name' => 'Homepage',
        'editor' => 'homepage.php',
        'icon' => 'fa-home'
    ],
    'about' => [
        'name' => 'About Page',
        'editor' => 'about-page.php',
        'icon' => 'fa-info-circle'
    ],
    'gallery' => [
        'name' => 'Gallery',
        'editor' => 'gallery.php',
        'icon' => 'fa-images'
    ],
    'rooms' => [
        'name' => 'Rooms',
        'editor' => 'rooms-page.php',
        'icon' => 'fa-bed'
    ],
    'contact' => [
        'name' => 'Contact Page',
        'editor' => 'contact-page.php',
        'icon' => 'fa-envelope'
    ],
    'amenities' => [
        'name' => 'Amenities',
        'editor' => 'amenities-page.php',
        'icon' => 'fa-spa'
    ],
    'restaurant' => [
        'name' => 'Restaurant',
        'editor' => 'restaurant-page.php',
        'icon' => 'fa-utensils'
    ],
    'bar' => [
        'name' => 'Bar',
        'editor' => 'bar-page.php',
        'icon' => 'fa-cocktail'
    ],
    'swimming-pool' => [
        'name' => 'Swimming Pool',
        'editor' => 'swimming-pool-page.php',
        'icon' => 'fa-swimming-pool'
    ],
    'hotel-policy' => [
        'name' => 'Hotel Policy',
        'editor' => 'hotel-policy-page.php',
        'icon' => 'fa-file-contract'
    ],
    'terms-of-use' => [
        'name' => 'Terms of Use',
        'editor' => 'terms-of-use-page.php',
        'icon' => 'fa-file-alt'
    ],
    'policies' => [
        'name' => 'Policies & Terms',
        'editor' => 'policies-page.php',
        'icon' => 'fa-file-contract'
    ]
];

// Get list of pages that have content in the database
try {
    $stmt = $pdo->prepare("SELECT DISTINCT page FROM page_sections ORDER BY page");
    $stmt->execute();
    $pagesInDb = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch(PDOException $e) {
    error_log("Pages list error: " . $e->getMessage());
    $pagesInDb = [];
}

// Combine available pages with database pages
$allPages = [];
foreach ($availablePages as $pageKey => $pageInfo) {
    $allPages[$pageKey] = $pageInfo;
    // Mark if page has content
    $allPages[$pageKey]['has_content'] = in_array($pageKey, $pagesInDb);
}
?>

<div class="card">
    <div class="card-header">
        <h2>Pages</h2>
    </div>
    
    <div style="padding: 20px;">
        <?php if (empty($allPages)): ?>
            <div style="padding: 40px; text-align: center; color: var(--text-muted);">
                <i class="fas fa-file" style="font-size: 48px; margin-bottom: 15px; display: block;"></i>
                <p>No pages available.</p>
            </div>
        <?php else: ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                <?php foreach ($allPages as $pageKey => $pageInfo): ?>
                    <div class="page-item" style="border: 1px solid var(--border-color); border-radius: 4px; padding: 20px; background: white;">
                        <div style="display: flex; align-items: center; margin-bottom: 15px;">
                            <i class="fas <?= $pageInfo['icon'] ?>" style="font-size: 32px; color: var(--primary-color); margin-right: 15px;"></i>
                            <div>
                                <h3 style="margin: 0; font-size: 18px; font-weight: 600;"><?= sanitize($pageInfo['name']) ?></h3>
                                <?php if ($pageInfo['has_content']): ?>
                                    <small style="color: var(--success-color);">
                                        <i class="fas fa-check-circle"></i> Has content
                                    </small>
                                <?php else: ?>
                                    <small style="color: var(--text-muted);">
                                        <i class="fas fa-circle"></i> No content yet
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div>
                            <a href="<?= ADMIN_URL ?>pages/<?= $pageInfo['editor'] ?>" class="btn btn-primary" style="width: 100%;">
                                <i class="fas fa-edit"></i> Edit Page
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>

