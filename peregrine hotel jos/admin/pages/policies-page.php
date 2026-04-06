<?php
/**
 * Policies & Terms Page Editor
 */

$pageTitle = 'Policies & Terms Page Editor';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

// Get all policies page sections
try {
    $stmt = $pdo->prepare("SELECT * FROM page_sections WHERE page = 'policies' ORDER BY section_key");
    $stmt->execute();
    $sections = $stmt->fetchAll();
    
    $sectionsArray = [];
    foreach ($sections as $section) {
        $sectionsArray[$section['section_key']] = $section['content'];
    }
} catch(PDOException $e) {
    error_log("Policies page editor error: " . $e->getMessage());
    $sectionsArray = [];
}

$csrfToken = generateCSRFToken();
?>

<form id="policiesPageForm">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
    
    <!-- Page Header -->
    <div class="card">
        <div class="card-header">
            <h2>Page Header</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="page_title">Page Title</label>
                <input type="text" id="page_title" name="page_title" value="<?= sanitize($sectionsArray['page_title'] ?? 'Policies & Terms') ?>">
                <p class="form-help">Title displayed at the top of the page</p>
            </div>
            
            <div class="form-group">
                <label for="last_updated">Last Updated Date</label>
                <input type="text" id="last_updated" name="last_updated" value="<?= sanitize($sectionsArray['last_updated'] ?? date('F j, Y')) ?>">
                <p class="form-help">Date displayed below the page title (e.g., "January 15, 2024")</p>
            </div>
            
            <div class="form-group">
                <label for="intro_text">Introduction Text</label>
                <textarea id="intro_text" name="intro_text" rows="3"><?= sanitize($sectionsArray['intro_text'] ?? 'Welcome to Peregrine Hotel Rayfield. Our policies are designed to ensure a seamless, luxurious, and safe experience for all our guests. Please review the following terms carefully before confirming your reservation.') ?></textarea>
                <p class="form-help">Introductory paragraph displayed at the top of the content</p>
            </div>
        </div>
    </div>
    
    <!-- Reservation & Cancellation Section -->
    <div class="card">
        <div class="card-header">
            <h2>Reservation & Cancellation</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="check_in_time">Check-in Time</label>
                <input type="text" id="check_in_time" name="check_in_time" value="<?= sanitize($sectionsArray['check_in_time'] ?? '3:00 PM') ?>">
                <p class="form-help">Check-in time (e.g., "3:00 PM")</p>
            </div>
            
            <div class="form-group">
                <label for="check_out_time">Check-out Time</label>
                <input type="text" id="check_out_time" name="check_out_time" value="<?= sanitize($sectionsArray['check_out_time'] ?? '11:00 AM') ?>">
                <p class="form-help">Check-out time (e.g., "11:00 AM")</p>
            </div>
            
            <div class="form-group">
                <label for="cancellation_policy">Cancellation Policy</label>
                <textarea id="cancellation_policy" name="cancellation_policy" rows="3"><?= sanitize($sectionsArray['cancellation_policy'] ?? 'Cancellations must be made at least 24 hours prior to arrival to avoid a penalty of one night\'s room and tax.') ?></textarea>
                <p class="form-help">Cancellation policy text</p>
            </div>
            
            <div class="form-group">
                <label for="deposit_policy">Deposit Policy</label>
                <textarea id="deposit_policy" name="deposit_policy" rows="3"><?= sanitize($sectionsArray['deposit_policy'] ?? 'A valid credit card is required at the time of booking to guarantee your reservation. A hold may be placed upon check-in for incidentals.') ?></textarea>
                <p class="form-help">Deposit and payment policy text</p>
            </div>
        </div>
    </div>
    
    <!-- Guest Conduct Section -->
    <div class="card">
        <div class="card-header">
            <h2>Guest Conduct & Safety</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="guest_conduct">Guest Conduct Policy</label>
                <textarea id="guest_conduct" name="guest_conduct" rows="4"><?= sanitize($sectionsArray['guest_conduct'] ?? 'Peregrine Hotel Rayfield is committed to providing a smoke-free environment. Smoking is strictly prohibited in all guest rooms and public areas.') ?></textarea>
                <p class="form-help">Guest conduct and safety policy text</p>
            </div>
        </div>
    </div>
    
    <!-- Privacy Policy Section -->
    <div class="card">
        <div class="card-header">
            <h2>Privacy Policy</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="privacy_policy">Privacy Policy Content</label>
                <textarea id="privacy_policy" name="privacy_policy" rows="5"><?= sanitize($sectionsArray['privacy_policy'] ?? 'We value your privacy. Personal information collected during the reservation process is used solely for the purpose of your stay and internal records. We do not sell or share your data with third parties, except as required by law or to facilitate your transaction.') ?></textarea>
                <p class="form-help">Privacy policy text</p>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <button type="submit" class="btn btn-primary">Save Policies & Terms Page</button>
        <a href="<?= ADMIN_URL ?>pages/pages-list.php" class="btn btn-outline">Cancel</a>
    </div>
</form>

<script>
// Form submission
document.getElementById('policiesPageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const sections = {};
    
    // Collect all form fields
    const fields = [
        'page_title', 
        'last_updated', 
        'intro_text', 
        'check_in_time', 
        'check_out_time', 
        'cancellation_policy', 
        'deposit_policy', 
        'guest_conduct', 
        'privacy_policy'
    ];
    
    fields.forEach(field => {
        if (formData.has(field)) {
            sections[field] = formData.get(field);
        }
    });
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    submitBtn.disabled = true;
    submitBtn.textContent = 'Saving...';
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const promises = Object.keys(sections).map(key => {
        return fetch('<?= ADMIN_URL ?>api/pages.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrfToken
            },
            body: JSON.stringify({
                page: 'policies',
                section_key: key,
                content_type: 'text',
                content: sections[key]
            })
        }).then(response => {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }
            return response.text().then(text => {
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Invalid JSON response:', text);
                    throw new Error('Invalid response');
                }
            });
        });
    });
    
    Promise.all(promises).then(results => {
        const allSuccess = results.every(r => r.success);
        if (allSuccess) {
            if (typeof showToast === 'function') {
                showToast('Policies & Terms page content saved successfully', 'success');
            }
        } else {
            if (typeof showToast === 'function') {
                showToast('Some sections failed to save', 'warning');
            }
        }
    })
    .catch(error => {
        console.error('Save error:', error);
        if (typeof showToast === 'function') {
            showToast('An error occurred: ' + error.message, 'error');
        }
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
    });
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
