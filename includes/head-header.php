<?php
/**
 * Header Head Section
 * Include this in the <head> section of each page to load Tailwind CSS and fonts
 * This should be included before the closing </head> tag
 */

// Track if head styles have been loaded (prevent duplicate loading)
static $headStylesLoaded = false;
if (!$headStylesLoaded) {
    $headStylesLoaded = true;
?>
<!-- Header Fonts and Tailwind CSS -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<!-- Match the primary site font stack used by assets/css/style.css -->
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;500;600;700&family=Meddon&family=Noto+Serif:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "primary": "#262161",
                    "background-light": "#f8f8f6",
                    "background-dark": "#221d10",
                    "surface-light": "#ffffff",
                    "surface-dark": "#2c2615",
                    "border-light": "#e7e1cf",
                    "border-dark": "#4a4025",
                    "text-main": "#1b180d",
                    "text-muted": "#9a864c",
                },
                fontFamily: {
                    "display": ["Playfair Display", "serif"],
                    "sans": ["Poppins", "sans-serif"],
                    "ternary": ["Meddon", "cursive"]
                },
                borderRadius: {"DEFAULT": "0.5rem", "lg": "1rem", "xl": "1.5rem", "full": "9999px"},
                boxShadow: {
                    'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                    'card': '0 10px 40px -10px rgba(0, 0, 0, 0.08)',
                }
            },
        },
    }
</script>
<style>
    /* Ensure Tailwind typography utilities match the site's main font stack */
    body {
        font-family: "Poppins", sans-serif;
    }
    .font-sans {
        font-family: "Poppins", sans-serif !important;
    }
    .font-display {
        font-family: "Playfair Display", serif !important;
    }
    /* Browser-preview change: ensure hero H1s use Playfair Display */
    h1.text-white {
        font-family: "Playfair Display" !important;
    }
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
    /* Hero font: Force Noto Serif for Tailwind-based heroes */
    .hero-font-serif {
        font-family: "Noto Serif", serif !important;
    }
    .hero-font-serif .material-symbols-outlined {
        font-family: "Material Symbols Outlined" !important;
    }
    textarea::-webkit-scrollbar {
        width: 8px;
    }
    textarea::-webkit-scrollbar-track {
        background: transparent;
    }
    textarea::-webkit-scrollbar-thumb {
        background-color: #e7e1cf;
        border-radius: 4px;
    }
    /* Hide any debug overlay elements */
    #agent-font-debug-overlay {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
    }
</style>
<?php
// Output custom header scripts from admin settings
if (function_exists('getSiteSetting')) {
    $headerScripts = getSiteSetting('header_scripts', '');
    if (!empty($headerScripts)) {
        echo "\n<!-- Custom Header Scripts -->\n";
        echo $headerScripts . "\n";
    }
}
}
?>

