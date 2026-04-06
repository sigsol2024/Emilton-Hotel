            </div> <!-- End content-area -->
        </div> <!-- End main-content -->
    </div> <!-- End admin-wrapper -->

    <!-- Toast Notification Container -->
    <div id="toastContainer" class="toast-container"></div>

    <!-- Media Library Modal -->
    <?php require_once __DIR__ . '/media-modal.php'; ?>

    <!-- Scripts -->
    <script>
        // Define ADMIN_URL for JavaScript
        const ADMIN_URL = <?= json_encode(ADMIN_URL) ?>;
        window.ADMIN_URL = ADMIN_URL;
    </script>
    <script src="<?= ADMIN_URL ?>assets/js/admin.js"></script>
    <script src="<?= ADMIN_URL ?>assets/js/media-library.js"></script>
    <?php if (isset($additionalScripts)): ?>
        <?php foreach ($additionalScripts as $script): ?>
            <script src="<?= ADMIN_URL . $script ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    <script>
        // Verify media library loaded
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof openMediaModal === 'undefined') {
                console.error('Media library failed to load! Check media-library.js at <?= ADMIN_URL ?>assets/js/media-library.js');
            }
        });
    </script>
</body>
</html>

