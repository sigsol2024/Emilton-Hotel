<?php
/**
 * Contact Page Editor
 */

$pageTitle = 'Contact Page Editor';
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/header.php';

// Get all contact page sections
try {
    $stmt = $pdo->prepare("SELECT * FROM page_sections WHERE page = 'contact' ORDER BY section_key");
    $stmt->execute();
    $sections = $stmt->fetchAll();
    
    $sectionsArray = [];
    foreach ($sections as $section) {
        $sectionsArray[$section['section_key']] = $section['content'];
    }
} catch(PDOException $e) {
    error_log("Contact page editor error: " . $e->getMessage());
    $sectionsArray = [];
}

$csrfToken = generateCSRFToken();
?>

<form id="contactPageForm">
    <input type="hidden" name="csrf_token" value="<?= $csrfToken ?>">
    
    <!-- Page Header -->
    <div class="card">
        <div class="card-header">
            <h2>Page Header</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="page_header_title">Page Title</label>
                <input type="text" id="page_header_title" name="page_header_title" value="<?= sanitize($sectionsArray['page_header_title'] ?? 'Contact Us & Location') ?>">
            </div>
            
            <div class="form-group">
                <label for="page_header_description">Page Description</label>
                <textarea id="page_header_description" name="page_header_description" rows="2"><?= sanitize($sectionsArray['page_header_description'] ?? 'Reach out to our concierge team for reservations, special requests, or find your way to our doorstep.') ?></textarea>
                <p class="form-help">Description text displayed below the page title</p>
            </div>
        </div>
    </div>
    
    <!-- Contact Information Section -->
    <div class="card">
        <div class="card-header">
            <h2>Contact Information</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="contact_address">Contact Address</label>
                <textarea id="contact_address" name="contact_address" rows="3"><?= sanitize($sectionsArray['contact_address'] ?? '') ?></textarea>
                <p class="form-help">The address displayed in the "Visit Us" section. If left empty, it will use the address from Site Settings.</p>
            </div>
            
            <div class="form-group">
                <label for="reservations_phone">Reservations Phone</label>
                <input type="text" id="reservations_phone" name="reservations_phone" value="<?= sanitize($sectionsArray['reservations_phone'] ?? '') ?>">
                <p class="form-help">Phone number for reservations. If left empty, it will use the phone from Site Settings.</p>
            </div>
            
            <div class="form-group">
                <label for="events_email">Events & Sales Email</label>
                <input type="email" id="events_email" name="events_email" value="<?= sanitize($sectionsArray['events_email'] ?? '') ?>">
                <p class="form-help">Email address for events and sales inquiries. If left empty, it will use the email from Site Settings.</p>
            </div>
        </div>
    </div>
    
    <!-- Map Section -->
    <div class="card">
        <div class="card-header">
            <h2>Map Settings</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label for="map_address">Map Address</label>
                <input type="text" id="map_address" name="map_address" value="<?= sanitize($sectionsArray['map_address'] ?? '') ?>">
                <p class="form-help">Used to generate the Google Map via API. Example: "The Azure Estate, 123 Luxury Blvd, Malibu, CA 90265"</p>
                <p class="form-help" style="color: #d97706; font-weight: 500; margin-top: 5px;">
                    <strong>Note:</strong> To enable interactive Google Maps, you must configure your Google Maps API key in <a href="<?= ADMIN_URL ?>pages/settings.php" target="_blank">Settings</a>. Without an API key, the contact page will display a static placeholder image.
                </p>
            </div>

            <div class="form-group">
                <label for="map_embed_url">Custom Map Embed URL (optional)</label>
                <input type="text" id="map_embed_url" name="map_embed_url" value="<?= sanitize($sectionsArray['map_embed_url'] ?? '') ?>">
                <p class="form-help">Optional: paste a full embed URL. If provided, it overrides the generated map from the address. This is useful if you want to use a custom map view or have specific map settings.</p>
            </div>
        </div>
    </div>
    
    <!-- FAQ Section -->
    <div class="card">
        <div class="card-header">
            <h2>FAQ Section</h2>
        </div>
        <div style="padding: 20px;">
            <div id="faqList">
                <!-- FAQ items will be rendered here -->
            </div>
            <button type="button" class="btn btn-outline" onclick="addFAQ()" style="margin-top: 15px;">
                <i class="fas fa-plus"></i> Add FAQ
            </button>
            <input type="hidden" id="faqs_json" name="faqs_json" value="<?= htmlspecialchars($sectionsArray['faqs_json'] ?? '[]', ENT_QUOTES, 'UTF-8') ?>">
        </div>
    </div>
    
    <!-- Contact Form Settings -->
    <div class="card">
        <div class="card-header">
            <h2>Contact Form Settings</h2>
        </div>
        <div style="padding: 20px;">
            <div class="form-group">
                <label>Subject Options</label>
                <div id="subjectOptionsList">
                    <!-- Subject options will be rendered here -->
                </div>
                <button type="button" class="btn btn-outline" onclick="addSubjectOption()" style="margin-top: 10px;">
                    <i class="fas fa-plus"></i> Add Subject Option
                </button>
                <input type="hidden" id="subject_options_json" name="subject_options_json" value="<?= htmlspecialchars($sectionsArray['subject_options_json'] ?? '["General Inquiry","Reservation Modification","Event Hosting","Concierge Request","Lost & Found"]', ENT_QUOTES, 'UTF-8') ?>">
                <p class="form-help">These options will appear in the contact form's subject dropdown</p>
            </div>
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <button type="submit" class="btn btn-primary">Save Contact Page</button>
        <a href="<?= ADMIN_URL ?>pages/pages-list.php" class="btn btn-outline">Cancel</a>
    </div>
</form>

<script>
// Handle media modal selection (if needed in future)
window.insertSelectedMediaOverride = function() {
    const selected = mediaModalState.selectedMedia;
    if (!selected) return false;
    
    // No image fields in contact page currently
    return false;
};

// FAQ Management
let faqList = [];
let subjectOptionsList = [];

// Load FAQs from hidden input
function loadFAQs() {
    const jsonInput = document.getElementById('faqs_json');
    try {
        faqList = JSON.parse(jsonInput.value || '[]');
    } catch (e) {
        console.error('Error parsing FAQs JSON:', e);
        faqList = [];
    }
    renderFAQs();
}

// Render FAQ list
function renderFAQs() {
    const container = document.getElementById('faqList');
    container.innerHTML = '';
    
    if (faqList.length === 0) {
        container.innerHTML = '<p class="form-help" style="margin-bottom: 15px;">No FAQs added yet. Click "Add FAQ" to add one.</p>';
    } else {
        faqList.forEach((item, index) => {
            const div = document.createElement('div');
            div.className = 'form-group';
            div.style.border = '1px solid #ddd';
            div.style.padding = '15px';
            div.style.marginBottom = '15px';
            div.style.borderRadius = '4px';
            div.style.backgroundColor = '#f9f9f9';
            // Escape HTML to prevent XSS
            const question = String(item.question || '').replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/'/g, '&#39;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            const answer = String(item.answer || '').replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/'/g, '&#39;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            
            div.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <strong>FAQ #${index + 1}</strong>
                    <button type="button" class="btn btn-outline" onclick="removeFAQ(${index})" style="padding: 5px 10px; font-size: 12px;">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
                <div class="form-group" style="margin-bottom: 10px;">
                    <label>Question</label>
                    <input type="text" class="form-control" value="${question}" 
                           onchange="updateFAQ(${index}, 'question', this.value)" 
                           placeholder="e.g., What are the check-in and check-out times?">
                </div>
                <div class="form-group" style="margin-bottom: 10px;">
                    <label>Answer</label>
                    <textarea class="form-control" rows="3" 
                           onchange="updateFAQ(${index}, 'answer', this.value)" 
                           placeholder="Enter the answer...">${answer}</textarea>
                </div>
            `;
            container.appendChild(div);
        });
    }
    
    // Update hidden input
    document.getElementById('faqs_json').value = JSON.stringify(faqList);
}

// Add new FAQ
function addFAQ() {
    faqList.push({
        question: '',
        answer: ''
    });
    renderFAQs();
}

// Remove FAQ
function removeFAQ(index) {
    if (confirm('Are you sure you want to remove this FAQ?')) {
        faqList.splice(index, 1);
        renderFAQs();
    }
}

// Update FAQ item
function updateFAQ(index, field, value) {
    if (faqList[index]) {
        faqList[index][field] = value;
        document.getElementById('faqs_json').value = JSON.stringify(faqList);
    }
}

// Subject Options Management
function loadSubjectOptions() {
    const jsonInput = document.getElementById('subject_options_json');
    try {
        subjectOptionsList = JSON.parse(jsonInput.value || '[]');
    } catch (e) {
        console.error('Error parsing subject options JSON:', e);
        subjectOptionsList = ['General Inquiry', 'Reservation Modification', 'Event Hosting', 'Concierge Request', 'Lost & Found'];
    }
    renderSubjectOptions();
}

function renderSubjectOptions() {
    const container = document.getElementById('subjectOptionsList');
    container.innerHTML = '';
    
        subjectOptionsList.forEach((option, index) => {
        const div = document.createElement('div');
        div.className = 'form-group';
        div.style.display = 'flex';
        div.style.gap = '10px';
        div.style.marginBottom = '10px';
        // Escape HTML to prevent XSS
        const escapedOption = String(option || '').replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/'/g, '&#39;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        div.innerHTML = `
            <input type="text" class="form-control" value="${escapedOption}" 
                   onchange="updateSubjectOption(${index}, this.value)" 
                   placeholder="Subject option">
            <button type="button" class="btn btn-outline" onclick="removeSubjectOption(${index})" style="padding: 5px 10px;">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(div);
    });
    
    document.getElementById('subject_options_json').value = JSON.stringify(subjectOptionsList);
}

function addSubjectOption() {
    subjectOptionsList.push('');
    renderSubjectOptions();
}

function removeSubjectOption(index) {
    subjectOptionsList.splice(index, 1);
    renderSubjectOptions();
}

function updateSubjectOption(index, value) {
    subjectOptionsList[index] = value;
    document.getElementById('subject_options_json').value = JSON.stringify(subjectOptionsList);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    loadFAQs();
    loadSubjectOptions();
});

// Form submission
document.getElementById('contactPageForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Ensure JSON inputs are up to date
    document.getElementById('faqs_json').value = JSON.stringify(faqList);
    document.getElementById('subject_options_json').value = JSON.stringify(subjectOptionsList);
    
    const formData = new FormData(this);
    const sections = {};
    
    // Collect all form fields
    const fields = [
        'page_header_title', 'page_header_description',
        'contact_address', 'reservations_phone', 'events_email',
        'map_address', 'map_embed_url',
        'faqs_json', 'subject_options_json'
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
                page: 'contact',
                section_key: key,
                content_type: key.includes('image') || key.includes('background') ? 'image' : 'text',
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
                showToast('Contact page content saved successfully', 'success');
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

