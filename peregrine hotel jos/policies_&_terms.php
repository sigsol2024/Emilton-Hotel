<?php
/**
 * Policies & Terms Page - Dynamic Content
 * Peregrine Hotel Rayfield
 */

require_once __DIR__ . '/includes/content-loader.php';

// Load site settings
$siteName = getSiteSetting('site_name', 'Peregrine Hotel Rayfield');

// Load page sections
$pageTitle = getPageSection('policies', 'page_title', 'Policies & Terms');
$lastUpdated = getPageSection('policies', 'last_updated', date('F j, Y'));
$introText = getPageSection('policies', 'intro_text', 'Welcome to Peregrine Hotel Rayfield. Our policies are designed to ensure a seamless, luxurious, and safe experience for all our guests. Please review the following terms carefully before confirming your reservation.');

$checkInTime = getPageSection('policies', 'check_in_time', '3:00 PM');
$checkOutTime = getPageSection('policies', 'check_out_time', '11:00 AM');
$cancellationPolicy = getPageSection('policies', 'cancellation_policy', 'Cancellations must be made at least 24 hours prior to arrival to avoid a penalty of one night\'s room and tax.');
$depositPolicy = getPageSection('policies', 'deposit_policy', 'A valid credit card is required at the time of booking to guarantee your reservation. A hold may be placed upon check-in for incidentals.');

$guestConduct = getPageSection('policies', 'guest_conduct', 'Peregrine Hotel Rayfield is committed to providing a smoke-free environment. Smoking is strictly prohibited in all guest rooms and public areas.');
$privacyPolicy = getPageSection('policies', 'privacy_policy', 'We value your privacy. Personal information collected during the reservation process is used solely for the purpose of your stay and internal records. We do not sell or share your data with third parties, except as required by law or to facilitate your transaction.');
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?= e($pageTitle) ?> - <?= e($siteName) ?></title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&amp;family=Noto+Sans:wght@400;500;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1754cf",
                        "background-light": "#f6f6f8",
                        "background-dark": "#111621",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"],
                        "body": ["Noto Sans", "sans-serif"],
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-[#0e121b] dark:text-white antialiased">
<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
<?php require_once __DIR__ . '/includes/header.php'; ?>

<main class="flex flex-1 flex-col items-center mt-20">
<div class="my-10 flex w-full max-w-4xl flex-col bg-white px-6 py-12 shadow-sm md:my-16 md:rounded-xl md:px-16 md:py-20 lg:px-24 dark:bg-[#1a202e] dark:shadow-none">
<!-- Page Heading -->
<div class="mb-12 border-b border-gray-100 pb-8 dark:border-gray-800">
<div class="flex flex-col gap-4">
<h1 class="font-display text-4xl font-extrabold leading-tight tracking-tight text-slate-900 md:text-5xl dark:text-white">
    <?= e($pageTitle) ?>
</h1>
<div class="flex items-center gap-2 text-slate-500 dark:text-slate-400">
<span class="material-symbols-outlined text-lg">history</span>
<p class="text-sm font-medium">Last Updated: <?= e($lastUpdated) ?></p>
</div>
</div>
</div>

<!-- Intro Text -->
<div class="mb-10">
<p class="font-body text-lg leading-relaxed text-slate-600 dark:text-slate-300">
    <?= e($introText) ?>
</p>
</div>

<!-- Section: Reservation & Cancellation -->
<section class="mb-12">
<div class="mb-6 flex items-center gap-3">
<span class="material-symbols-outlined text-primary">calendar_clock</span>
<h2 class="font-display text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
    Reservation &amp; Cancellation
</h2>
</div>
<div class="rounded-lg border border-gray-100 bg-gray-50/50 p-6 dark:border-gray-800 dark:bg-gray-800/30">
<div class="grid gap-y-6">
<div class="grid grid-cols-1 gap-2 sm:grid-cols-[180px_1fr] sm:gap-6">
<p class="text-sm font-medium text-slate-500 dark:text-slate-400">Check-in Time</p>
<p class="text-base font-medium text-slate-900 dark:text-white"><?= e($checkInTime) ?></p>
</div>
<div class="grid grid-cols-1 gap-2 border-t border-gray-200 pt-6 sm:grid-cols-[180px_1fr] sm:gap-6 dark:border-gray-700">
<p class="text-sm font-medium text-slate-500 dark:text-slate-400">Check-out Time</p>
<p class="text-base font-medium text-slate-900 dark:text-white"><?= e($checkOutTime) ?></p>
</div>
<div class="grid grid-cols-1 gap-2 border-t border-gray-200 pt-6 sm:grid-cols-[180px_1fr] sm:gap-6 dark:border-gray-700">
<p class="text-sm font-medium text-slate-500 dark:text-slate-400">Cancellation Window</p>
<p class="text-base font-medium text-slate-900 dark:text-white">
    <?= e($cancellationPolicy) ?>
</p>
</div>
<div class="grid grid-cols-1 gap-2 border-t border-gray-200 pt-6 sm:grid-cols-[180px_1fr] sm:gap-6 dark:border-gray-700">
<p class="text-sm font-medium text-slate-500 dark:text-slate-400">Deposit Policy</p>
<p class="text-base font-medium text-slate-900 dark:text-white">
    <?= e($depositPolicy) ?>
</p>
</div>
</div>
</div>
</section>

<!-- Section: Guest Conduct -->
<section class="mb-12">
<div class="mb-6 flex items-center gap-3">
<span class="material-symbols-outlined text-amber-700">gavel</span>
<h2 class="font-display text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
    Guest Conduct &amp; Safety
</h2>
</div>
<div class="prose prose-slate prose-lg max-w-none dark:prose-invert">
<p class="font-body text-base leading-relaxed text-slate-600 dark:text-slate-300">
    <?= e($guestConduct) ?>
</p>
</div>
</section>

<!-- Section: Privacy Policy -->
<section class="mb-12">
<div class="mb-6 flex items-center gap-3">
<span class="material-symbols-outlined text-amber-700">lock</span>
<h2 class="font-display text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
    Privacy Policy
</h2>
</div>
<p class="font-body text-base leading-relaxed text-slate-600 dark:text-slate-300">
    <?= e($privacyPolicy) ?>
</p>
</section>
</div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
</div>
</body></html>
