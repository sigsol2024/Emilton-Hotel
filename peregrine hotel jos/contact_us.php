<?php
/**
 * Contact Us Page - Dynamic Content
 * Peregrine Hotel Rayfield
 */

require_once __DIR__ . '/includes/content-loader.php';

// Load site settings
$siteName = getSiteSetting('site_name', 'Peregrine Hotel Rayfield');
$footerAddress = getSiteSetting('footer_address', '12 Rayfield Avenue,<br/>Jos, Plateau State,<br/>Nigeria');
$footerPhone = getSiteSetting('footer_phone', '+234 800 123 4567');
$footerEmail = getSiteSetting('footer_email', 'reservations@peregrinehotel.com');
$socialMediaJson = getSiteSetting('social_media_json', '[]');
$socialMediaList = json_decode($socialMediaJson, true) ?: [];
$googleMapsApiKey = getSiteSetting('google_maps_api_key', '');

// Load page sections
$pageTitle = getPageSection('contact', 'page_header_title', getPageSection('contact', 'page_title', 'Get in Touch'));
$pageSubtitle = getPageSection('contact', 'page_header_description', getPageSection('contact', 'page_subtitle', 'Experience luxury in the heart of Jos. Reach out for reservations, events, or general inquiries.'));
$contactAddress = getPageSection('contact', 'contact_address', $footerAddress);
$reservationsPhone = getPageSection('contact', 'reservations_phone', $footerPhone);
$eventsEmail = getPageSection('contact', 'events_email', $footerEmail);

// Load FAQ section
$faqsJson = getPageSection('contact', 'faqs_json', '[]');
$faqs = json_decode($faqsJson, true) ?: [];

// Load form subject options
$subjectOptionsJson = getPageSection('contact', 'subject_options_json', '["General Inquiry","Room Reservation","Dining & Restaurant","Event Planning","Other"]');
$subjectOptions = json_decode($subjectOptionsJson, true) ?: ['General Inquiry', 'Room Reservation', 'Dining & Restaurant', 'Event Planning', 'Other'];
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Contact Us - <?= e($siteName) ?></title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "primary": "#1754cf",
              "background-light": "#ffffff",
              "background-dark": "#111621",
              "neutral-subtle": "#f9fafb",
            },
            fontFamily: {
              "display": ["Plus Jakarta Sans", "sans-serif"]
            },
            borderRadius: {
                "DEFAULT": "0.375rem", 
                "lg": "0.5rem", 
                "xl": "0.75rem", 
                "full": "9999px"
            },
          },
        },
      }
    </script>
<style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-[#1f2937] dark:text-[#f3f4f6]">
<?php require_once __DIR__ . '/includes/header.php'; ?>

<main class="flex-grow mt-20">
<!-- Page Header -->
<div class="relative bg-[#3f3f3f] py-16 sm:py-24">
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
<h1 class="text-4xl font-light tracking-tight text-white sm:text-5xl lg:text-6xl"><?= e($pageTitle) ?></h1>
<p class="mt-4 text-lg leading-8 text-white/80 max-w-2xl mx-auto">
    <?= e($pageSubtitle) ?>
</p>
<div class="mt-8 flex justify-center">
<nav aria-label="Breadcrumb" class="flex">
<ol class="flex items-center space-x-2 text-sm text-white/80" role="list">
<li><a class="hover:text-amber-500 transition-colors" href="index.php">Home</a></li>
<li><span class="material-symbols-outlined !text-[14px] pt-1 text-amber-500">chevron_right</span></li>
<li><span class="font-medium text-white">Contact</span></li>
</ol>
</nav>
</div>
</div>
</div>

<!-- Split Layout: Info & Form -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
<div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24">
<!-- Left Column: Contact Info & FAQ -->
<div class="flex flex-col min-h-[600px]">
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
<!-- Address -->
<div>
<div class="flex items-center gap-2 mb-3 text-amber-500">
<span class="material-symbols-outlined !text-[20px] text-amber-500">location_on</span>
<h3 class="text-lg font-light text-gray-900 dark:text-white">Visit Us</h3>
</div>
<p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400 mb-3">
    <?= strip_tags($contactAddress) ?>
</p>
<a class="inline-flex items-center text-xs font-semibold text-amber-500 hover:text-amber-400 transition-colors" href="https://www.google.com/maps/search/?api=1&query=<?= urlencode(strip_tags($contactAddress)) ?>" target="_blank">
    Get Directions <span class="material-symbols-outlined !text-[14px] ml-1">arrow_forward</span>
</a>
</div>
<!-- Contact Methods -->
<div>
<div class="flex items-center gap-2 mb-3 text-amber-500">
<span class="material-symbols-outlined !text-[20px] text-amber-500">call</span>
<h3 class="text-lg font-light text-gray-900 dark:text-white">Contact</h3>
</div>
<div class="space-y-2">
<div class="flex flex-col">
<span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">RESERVATIONS</span>
<a class="text-sm text-gray-900 dark:text-white hover:text-amber-500 transition-colors" href="tel:<?= e($reservationsPhone) ?>"><?= e($reservationsPhone) ?></a>
</div>
<div class="flex flex-col">
<span class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">EVENTS &amp; SALES</span>
<a class="text-sm text-gray-900 dark:text-white hover:text-amber-500 transition-colors" href="mailto:<?= e($eventsEmail) ?>"><?= e($eventsEmail) ?></a>
</div>
</div>
</div>
</div>

<!-- FAQ Section -->
<?php if (!empty($faqs)): ?>
<div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
<h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Frequently Asked Questions</h3>
<div class="space-y-2">
<?php foreach ($faqs as $index => $faq): 
    if (empty($faq['question']) || empty($faq['answer'])) continue;
?>
<div class="border border-gray-200 dark:border-gray-700 rounded-md overflow-hidden">
<button class="faq-question w-full px-4 py-2.5 text-left flex items-center justify-between bg-white dark:bg-[#1a202c] hover:bg-gray-50 dark:hover:bg-[#111621] transition-colors" onclick="toggleFAQ(this)">
<span class="font-medium text-sm text-gray-900 dark:text-white pr-3 flex-1 text-left"><?= e($faq['question']) ?></span>
<span class="material-symbols-outlined faq-icon text-amber-500 transition-transform flex-shrink-0" style="font-size: 18px;">expand_more</span>
</button>
<div class="faq-answer hidden px-4 py-3 bg-gray-50 dark:bg-[#111621] border-t border-gray-200 dark:border-gray-700">
<p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed"><?= nl2br(e($faq['answer'])) ?></p>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
<?php endif; ?>
</div>

<!-- Right Column: Form -->
<div class="bg-neutral-subtle dark:bg-[#1a202c] p-8 rounded-xl border border-gray-100 dark:border-gray-800 shadow-sm min-h-[600px] flex flex-col">
<h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Send us a message</h2>
<form id="contactForm" action="api/contact-form.php" method="POST" class="flex-1 flex flex-col">
<!-- Step 1: Personal Information -->
<div id="step1" class="form-step space-y-6 flex-1 flex flex-col">
<div class="flex items-center justify-between mb-4">
<h3 class="text-lg font-medium text-gray-900 dark:text-white">Step 1 of 3: Your Information</h3>
<span class="text-sm text-gray-500 dark:text-gray-400">1/3</span>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="group">
<label class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300 mb-2" for="first-name">First name</label>
<input autocomplete="given-name" class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6 dark:bg-[#111621] dark:ring-gray-700 dark:text-white transition-all bg-white" id="first-name" name="first_name" type="text" required/>
</div>
<div>
<label class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300 mb-2" for="last-name">Last name</label>
<input autocomplete="family-name" class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6 dark:bg-[#111621] dark:ring-gray-700 dark:text-white transition-all bg-white" id="last-name" name="last_name" type="text" required/>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div>
<label class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300 mb-2" for="email">Email address</label>
<input autocomplete="email" class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6 dark:bg-[#111621] dark:ring-gray-700 dark:text-white transition-all bg-white" id="email" name="email" type="email" required/>
</div>
<div>
<label class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300 mb-2" for="phone">Phone number</label>
<input autocomplete="tel" class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6 dark:bg-[#111621] dark:ring-gray-700 dark:text-white transition-all bg-white" id="phone" name="phone" type="tel"/>
</div>
</div>
<div class="mt-auto pt-6">
<button type="button" onclick="nextStep()" class="w-full rounded-lg bg-[#3f3f3f] px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#2a2a2a] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#3f3f3f] transition-all">
    Next: Reason for Inquiry
</button>
</div>
</div>

<!-- Step 2: Reason for Inquiry -->
<div id="step2" class="form-step space-y-6 flex-1 flex flex-col hidden">
<div class="flex items-center justify-between mb-4">
<h3 class="text-lg font-medium text-gray-900 dark:text-white">Step 2 of 3: Reason for Inquiry</h3>
<span class="text-sm text-gray-500 dark:text-gray-400">2/3</span>
</div>
<div>
<label class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300 mb-2" for="subject">Reason for inquiry</label>
<select class="block w-full appearance-none rounded-md border-0 py-2.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6 dark:bg-[#111621] dark:ring-gray-700 dark:text-white transition-all bg-white" id="subject" name="subject" required>
<option value="">Please select...</option>
<?php foreach ($subjectOptions as $option): ?>
<option><?= e($option) ?></option>
<?php endforeach; ?>
</select>
</div>
<div class="mt-auto pt-6 flex gap-4">
<button type="button" onclick="prevStep()" class="flex-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#111621] px-6 py-3 text-sm font-semibold text-gray-900 dark:text-white shadow-sm hover:bg-gray-50 dark:hover:bg-[#1a202c] transition-all">
    Back
</button>
<button type="button" onclick="nextStep()" class="flex-1 rounded-lg bg-[#3f3f3f] px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#2a2a2a] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#3f3f3f] transition-all">
    Next: Your Message
</button>
</div>
</div>

<!-- Step 3: Message -->
<div id="step3" class="form-step space-y-6 flex-1 flex flex-col hidden">
<div class="flex items-center justify-between mb-4">
<h3 class="text-lg font-medium text-gray-900 dark:text-white">Step 3 of 3: Your Message</h3>
<span class="text-sm text-gray-500 dark:text-gray-400">3/3</span>
</div>
<div>
<label class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300 mb-2" for="message">Message</label>
<textarea rows="6" class="block w-full rounded-md border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6 dark:bg-[#111621] dark:ring-gray-700 dark:text-white transition-all bg-white" id="message" name="message" required></textarea>
</div>
<div class="mt-auto pt-6 flex gap-4">
<button type="button" onclick="prevStep()" class="flex-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#111621] px-6 py-3 text-sm font-semibold text-gray-900 dark:text-white shadow-sm hover:bg-gray-50 dark:hover:bg-[#1a202c] transition-all">
    Back
</button>
<button type="submit" class="flex-1 rounded-lg bg-[#3f3f3f] px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-[#2a2a2a] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#3f3f3f] transition-all">
    Send Message
</button>
</div>
</div>
</form>
</div>

<script>
let currentStep = 1;
const totalSteps = 3;

function showStep(step) {
    // Hide all steps
    for (let i = 1; i <= totalSteps; i++) {
        const stepEl = document.getElementById(`step${i}`);
        if (stepEl) {
            stepEl.classList.add('hidden');
        }
    }
    // Show current step
    const currentStepEl = document.getElementById(`step${step}`);
    if (currentStepEl) {
        currentStepEl.classList.remove('hidden');
    }
}

function nextStep() {
    // Validate current step
    const currentStepEl = document.getElementById(`step${currentStep}`);
    if (currentStepEl) {
        const form = currentStepEl.closest('form');
        const inputs = currentStepEl.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;
        
        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('ring-red-500');
            } else {
                input.classList.remove('ring-red-500');
            }
        });
        
        if (!isValid) {
            return;
        }
    }
    
    if (currentStep < totalSteps) {
        currentStep++;
        showStep(currentStep);
    }
}

function prevStep() {
    if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
    }
}

// Initialize
showStep(1);

// FAQ Toggle Function (no index reliance; works even if some FAQs are empty/skipped)
function toggleFAQ(buttonEl) {
    const wrapper = buttonEl?.closest('.border');
    if (!wrapper) return;
    const answer = wrapper.querySelector('.faq-answer');
    const icon = buttonEl.querySelector('.faq-icon');
    if (!answer) return;

    const isHidden = answer.classList.contains('hidden');
    if (isHidden) {
        answer.classList.remove('hidden');
        if (icon) icon.style.transform = 'rotate(180deg)';
    } else {
        answer.classList.add('hidden');
        if (icon) icon.style.transform = 'rotate(0deg)';
    }
}
</script>
</div>
</div>

<!-- Map Section -->
<?php 
$mapAddressRaw = getPageSection('contact', 'map_address', '12 Rayfield Avenue, Jos, Plateau State, Nigeria');
$mapEmbedUrl = getPageSection('contact', 'map_embed_url', '');

// Clean the map address: remove newlines, normalize whitespace, trim
if (!empty($mapAddressRaw)) {
    $mapAddress = $mapAddressRaw;
    // Replace newlines and multiple spaces with single space
    $mapAddress = preg_replace('/\s+/', ' ', $mapAddress);
    // Replace common line break patterns with commas
    $mapAddress = str_replace(["\n", "\r", "\r\n"], ', ', $mapAddress);
    // Clean up multiple commas
    $mapAddress = preg_replace('/,\s*,+/', ', ', $mapAddress);
    $mapAddress = trim($mapAddress);
} else {
    $mapAddress = '12 Rayfield Avenue, Jos, Plateau State, Nigeria';
}
?>
<section class="relative w-full h-[500px] mt-12 bg-gray-100 dark:bg-gray-800">
<div class="absolute inset-0 w-full h-full map-container">
<?php if (!empty($mapEmbedUrl)): ?>
    <!-- Use custom embed URL if provided -->
    <iframe 
        id="contactGoogleMap"
        class="w-full h-full"
        frameborder="0"
        style="border:0"
        allowfullscreen
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        src="<?= e(trim($mapEmbedUrl)) ?>">
    </iframe>
<?php elseif (!empty($googleMapsApiKey) && !empty($mapAddress)): ?>
    <!-- Use Google Maps API with address (same as about_us page) -->
    <iframe 
        id="contactGoogleMap"
        class="w-full h-full"
        frameborder="0"
        style="border:0"
        allowfullscreen
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        src="https://www.google.com/maps/embed/v1/place?key=<?= e($googleMapsApiKey) ?>&q=<?= urlencode($mapAddress) ?>">
    </iframe>
<?php else: ?>
    <!-- No API key - show placeholder message -->
    <div class="w-full h-full flex items-center justify-center text-gray-500 dark:text-gray-400">
    <div class="text-center px-4">
    <span class="material-symbols-outlined text-4xl mb-4 text-amber-500">location_on</span>
    <p class="text-lg font-medium mb-2"><?= e($mapAddress) ?></p>
    <p class="text-sm">Map will appear here once Google Maps API key is configured in settings.</p>
    </div>
    </div>
<?php endif; ?>
</div>
<!-- Overlay card for smaller screens or just aesthetic -->
<div class="absolute bottom-6 left-1/2 -translate-x-1/2 bg-white dark:bg-[#1a202c] py-3 px-6 rounded-full shadow-lg border border-gray-200 dark:border-gray-700 flex items-center gap-2 max-w-[90%] w-max pointer-events-none">
<span class="material-symbols-outlined text-amber-500">near_me</span>
<p class="text-sm font-medium text-gray-900 dark:text-white truncate"><?= e($mapAddress) ?></p>
</div>
</section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
