<?php
/**
 * Header Head Section
 * Include this in the <head> section of each page to load Tailwind CSS and fonts
 * This should be included before the closing </head> tag
 * Blue Orange design - preserving original styling
 */

// Track if head styles have been loaded (prevent duplicate loading)
static $headStylesLoaded = false;
if (!$headStylesLoaded) {
    $headStylesLoaded = true;
?>
<!-- Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet"/>
<!-- Material Symbols -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Tailwind Config -->
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1773cf",
                        "primary-hover": "#135ca6",
                        "background-light": "#FFFFFF",
                        "background-off": "#f6f7f8",
                        "background-dark": "#111921",
                        "text-main": "#111418",
                        "text-secondary": "#637588",
                        "accent-sand": "#f9f7f2",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "2xl": "1rem",
                        "full": "9999px"
                    },
                    boxShadow: {
                        'soft': '0 4px 24px 0 rgba(0, 0, 0, 0.04)',
                        'card': '0 2px 12px 0 rgba(0, 0, 0, 0.08)',
                    }
                },
            },
        }
    </script>
<style>
        /* Custom scrollbar for better aesthetics */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8; 
        }

        /* Booking widget (StayEazi) - override injected default box styles to match site design */
        #booking-blueorange #booking-widget {
            margin: 0 !important;
            padding: 0 !important;
            border: 0 !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            background: transparent !important;
            max-width: none !important;
        }
        #booking-blueorange #booking-form {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 8px !important;
            align-items: flex-end !important;
            justify-content: space-between !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        #booking-blueorange #booking-form > div {
            width: auto !important; /* override inline width: xx% */
            min-width: 160px !important;
            flex: 1 1 160px !important;
            margin: 0 !important;
        }
        #booking-blueorange #booking-form label {
            font-size: 11px !important;
            font-weight: 800 !important;
            letter-spacing: 0.08em !important;
            text-transform: uppercase !important;
            margin-bottom: 6px !important;
            color: #111418 !important;
        }
        #booking-blueorange #booking-form input {
            width: 100% !important;
            height: 44px !important;
            padding: 10px 12px !important;
            border: 1px solid #dce0e5 !important;
            border-radius: 10px !important;
            background: #fff !important;
            color: #111418 !important;
        }
        #booking-blueorange #booking-form button {
            width: 100% !important;
            height: 44px !important;
            margin-top: 0 !important; /* override injected margin-top */
            border: 0 !important;
            border-radius: 10px !important;
            background: #1773cf !important;
            color: #fff !important;
            font-weight: 800 !important;
            cursor: pointer !important;
        }
        #booking-blueorange #booking-form button:hover {
            background: #135ca6 !important;
        }

        /* Booking widget - stacked layout for mobile + tablet (match Emilton behavior) */
        @media (max-width: 1024px) {
            #booking-blueorange #booking-form {
                flex-direction: column !important;
                align-items: stretch !important;
            }
            #booking-blueorange #booking-form > div {
                min-width: 100% !important;
                flex: 1 1 100% !important;
            }
        }

        /* Global CTA styles (so header buttons look consistent across ALL pages, not just homepage) */
        .cta-gold {
            background: #B38B3F;
            color: #fff;
            transition: background-color 150ms ease, transform 150ms ease, box-shadow 150ms ease;
        }
        .cta-gold:hover { background: #8E6D31; }
        .cta-blue {
            background: #1773cf;
            color: #fff;
            transition: background-color 150ms ease, transform 150ms ease, box-shadow 150ms ease;
        }
        .cta-blue:hover { background: #135ca6; }
    </style>
<?php
}
// Output custom header scripts from admin settings
if (function_exists('getSiteSetting')) {
    $headerScripts = getSiteSetting('header_scripts', '');
    if (!empty($headerScripts)) {
        echo "\n<!-- Custom Header Scripts -->\n";
        echo $headerScripts . "\n";
    }
}
?>

