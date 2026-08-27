<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'CMS' ?> - B-Universe CMS</title>
    <link rel="shortcut icon" href="<?= base_url('assets/favicon.ico') ?>" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        accent: {
                            50: '#FFF6F1',
                            100: '#FDE6DB',
                            500: '#F2622C',
                            600: '#E6531F',
                        },
                        ink: {
                            50: '#F7F5F2',
                            150: '#EDE9E4',
                            300: '#D8D2CC',
                            500: '#8A817B',
                            700: '#524B47',
                            900: '#231F1D',
                        },
                        semantic: {
                            success: '#2E7D5B',
                            'success-bg': '#E4F3EC',
                            warning: '#B8791A',
                            'warning-bg': '#FBEFDD',
                            danger: '#C4432E',
                            'danger-bg': '#FBE6E2',
                            info: '#3A6FA8',
                            'info-bg': '#E7EFF7',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        jakarta: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-ink-50 min-h-screen flex text-ink-900 font-sans">

    <!-- Fixed Left Sidebar -->
    <aside class="w-[240px] bg-white border-r border-ink-150 flex flex-col fixed inset-y-0 left-0 z-50">
        <div class="h-16 flex items-center px-6 border-b border-ink-150">
            <a href="<?= base_url() ?>" class="font-jakarta font-bold text-lg text-ink-900 flex items-center gap-2">
                <span class="w-7 h-7 bg-ink-900 rounded-md flex items-center justify-center text-white text-xs font-jakarta">B</span>
                B-Universe CMS
            </a>
        </div>

        <?php 
        $current_portal = $this->input->get('portal');
        if (!$current_portal) {
            if (strpos(uri_string(), 'beritasatu') !== false) $current_portal = 'beritasatu';
            elseif (strpos(uri_string(), 'investor') !== false) $current_portal = 'investor';
            elseif (strpos(uri_string(), 'jakartaglobe') !== false) $current_portal = 'jakartaglobe';
        }
        ?>

        <nav class="flex-1 py-6 px-3 space-y-6 overflow-y-auto">
            <!-- Main Menu Group -->
            <div>
                <div class="px-3 mb-2 text-[11px] font-bold text-ink-500 uppercase tracking-wider">Main Menu</div>
                <div class="space-y-1">
                    <?php 
                    $is_dash = (uri_string() === 'dashboard' || uri_string() === ''); 
                    ?>
                    <a href="<?= base_url('dashboard') ?>" class="flex items-center gap-3 py-2 px-3 text-xs font-medium rounded-md transition-all <?= $is_dash ? 'border-l-[3px] border-accent-500 bg-accent-50/50 text-ink-900 font-bold pl-[9px]' : 'text-ink-700 hover:bg-ink-50 hover:text-ink-900' ?>">
                        <i class="fa-solid fa-chart-line w-4 text-[14px] <?= $is_dash ? 'text-accent-600' : 'text-ink-500' ?>"></i> Dashboard
                    </a>
                    <?php 
                    $is_all_news = (uri_string() === 'newsletters' && $current_portal === null);
                    ?>
                    <a href="<?= base_url('newsletters') ?>" class="flex items-center gap-3 py-2 px-3 text-xs font-medium rounded-md transition-all <?= $is_all_news ? 'border-l-[3px] border-accent-500 bg-accent-50/50 text-ink-900 font-bold pl-[9px]' : 'text-ink-700 hover:bg-ink-50 hover:text-ink-900' ?>">
                        <i class="fa-solid fa-newspaper w-4 text-[14px] <?= $is_all_news ? 'text-accent-600' : 'text-ink-500' ?>"></i> All Newsletters
                    </a>
                </div>
            </div>

            <!-- Contents Group with Dropdowns -->
            <div>
                <div class="px-3 mb-2 text-[11px] font-bold text-ink-500 uppercase tracking-wider">Portals</div>
                <div class="space-y-1">
                    <!-- BeritaSatu Dropdown -->
                    <div>
                        <button onclick="toggleDropdown('dropdown-beritasatu')" class="w-full flex items-center justify-between py-2 px-3 text-xs font-medium rounded-md text-ink-700 hover:bg-ink-50 hover:text-ink-900 transition-all">
                            <span class="flex items-center gap-3">
                                <span class="w-2 h-2 rounded-full bg-[#EC1C24]"></span> BeritaSatu
                            </span>
                            <i class="fa-solid fa-chevron-down text-[9px] text-ink-500"></i>
                        </button>
                        <div id="dropdown-beritasatu" class="<?= $current_portal === 'beritasatu' ? '' : 'hidden' ?> pl-5 mt-1 space-y-1">
                            <?php $is_bs_nl = (uri_string() === 'newsletters' && $current_portal === 'beritasatu'); ?>
                            <a href="<?= base_url('newsletters?portal=beritasatu') ?>" class="block py-1 px-3 text-[11px] font-medium rounded-md <?= $is_bs_nl ? 'text-accent-600 font-bold bg-accent-50/50' : 'text-ink-700 hover:text-ink-900 hover:bg-ink-50' ?>">Newsletter</a>
                            <?php $is_bs_log = (uri_string() === 'logs/beritasatu'); ?>
                            <a href="<?= base_url('logs/beritasatu') ?>" class="block py-1 px-3 text-[11px] font-medium rounded-md <?= $is_bs_log ? 'text-accent-600 font-bold bg-accent-50/50' : 'text-ink-700 hover:text-ink-900 hover:bg-ink-50' ?>">History Logs</a>
                        </div>
                    </div>

                    <!-- Investor Dropdown -->
                    <div>
                        <button onclick="toggleDropdown('dropdown-investor')" class="w-full flex items-center justify-between py-2 px-3 text-xs font-medium rounded-md text-ink-700 hover:bg-ink-50 hover:text-ink-900 transition-all">
                            <span class="flex items-center gap-3">
                                <span class="w-2 h-2 rounded-full bg-blue-600"></span> Investor.id
                            </span>
                            <i class="fa-solid fa-chevron-down text-[9px] text-ink-500"></i>
                        </button>
                        <div id="dropdown-investor" class="<?= $current_portal === 'investor' ? '' : 'hidden' ?> pl-5 mt-1 space-y-1">
                            <?php $is_inv_nl = (uri_string() === 'newsletters' && $current_portal === 'investor'); ?>
                            <a href="<?= base_url('newsletters?portal=investor') ?>" class="block py-1 px-3 text-[11px] font-medium rounded-md <?= $is_inv_nl ? 'text-accent-600 font-bold bg-accent-50/50' : 'text-ink-700 hover:text-ink-900 hover:bg-ink-50' ?>">Newsletter</a>
                            <?php $is_inv_log = (uri_string() === 'logs/investor'); ?>
                            <a href="<?= base_url('logs/investor') ?>" class="block py-1 px-3 text-[11px] font-medium rounded-md <?= $is_inv_log ? 'text-accent-600 font-bold bg-accent-50/50' : 'text-ink-700 hover:text-ink-900 hover:bg-ink-50' ?>">History Logs</a>
                        </div>
                    </div>

                    <!-- JakartaGlobe Dropdown -->
                    <div>
                        <button onclick="toggleDropdown('dropdown-jakartaglobe')" class="w-full flex items-center justify-between py-2 px-3 text-xs font-medium rounded-md text-ink-700 hover:bg-ink-50 hover:text-ink-900 transition-all">
                            <span class="flex items-center gap-3">
                                <span class="w-2 h-2 rounded-full bg-orange-500"></span> JakartaGlobe
                            </span>
                            <i class="fa-solid fa-chevron-down text-[9px] text-ink-500"></i>
                        </button>
                        <div id="dropdown-jakartaglobe" class="<?= $current_portal === 'jakartaglobe' ? '' : 'hidden' ?> pl-5 mt-1 space-y-1">
                            <?php $is_jg_nl = (uri_string() === 'newsletters' && $current_portal === 'jakartaglobe'); ?>
                            <a href="<?= base_url('newsletters?portal=jakartaglobe') ?>" class="block py-1 px-3 text-[11px] font-medium rounded-md <?= $is_jg_nl ? 'text-accent-600 font-bold bg-accent-50/50' : 'text-ink-700 hover:text-ink-900 hover:bg-ink-50' ?>">Newsletter</a>
                            <?php $is_jg_log = (uri_string() === 'logs/jakartaglobe'); ?>
                            <a href="<?= base_url('logs/jakartaglobe') ?>" class="block py-1 px-3 text-[11px] font-medium rounded-md <?= $is_jg_log ? 'text-accent-600 font-bold bg-accent-50/50' : 'text-ink-700 hover:text-ink-900 hover:bg-ink-50' ?>">History Logs</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Group -->
            <div>
                <div class="px-3 mb-2 text-[11px] font-bold text-ink-500 uppercase tracking-wider">System</div>
                <div class="space-y-1">
                    <?php $is_templates = (strpos(uri_string(), 'newsletters/templates') !== false); ?>
                    <a href="<?= base_url('newsletters/templates') ?>" class="flex items-center gap-3 py-2 px-3 text-xs font-medium rounded-md transition-all <?= $is_templates ? 'border-l-[3px] border-accent-500 bg-accent-50/50 text-ink-900 font-bold pl-[9px]' : 'text-ink-700 hover:bg-ink-50 hover:text-ink-900' ?>">
                        <i class="fa-solid fa-envelope-open-text w-4 text-[14px] <?= $is_templates ? 'text-accent-600' : 'text-ink-500' ?>"></i> Templates
                    </a>
                    <?php $is_logs = (uri_string() === 'logs'); ?>
                    <a href="<?= base_url('logs') ?>" class="flex items-center gap-3 py-2 px-3 text-xs font-medium rounded-md transition-all <?= $is_logs ? 'border-l-[3px] border-accent-500 bg-accent-50/50 text-ink-900 font-bold pl-[9px]' : 'text-ink-700 hover:bg-ink-50 hover:text-ink-900' ?>">
                        <i class="fa-solid fa-clock-rotate-left w-4 text-[14px] <?= $is_logs ? 'text-accent-600' : 'text-ink-500' ?>"></i> History Logs
                    </a>
                    <?php $is_subs = (uri_string() === 'subscribers'); ?>
                    <a href="<?= base_url('subscribers') ?>" class="flex items-center gap-3 py-2 px-3 text-xs font-medium rounded-md transition-all <?= $is_subs ? 'border-l-[3px] border-accent-500 bg-accent-50/50 text-ink-900 font-bold pl-[9px]' : 'text-ink-700 hover:bg-ink-50 hover:text-ink-900' ?>">
                        <i class="fa-solid fa-users w-4 text-[14px] <?= $is_subs ? 'text-accent-600' : 'text-ink-500' ?>"></i> Subscribers
                    </a>
                </div>
            </div>
        </nav>

        <script>
            function toggleDropdown(id) {
                const dropdowns = ['dropdown-beritasatu', 'dropdown-investor', 'dropdown-jakartaglobe'];
                dropdowns.forEach(dId => {
                    const el = document.getElementById(dId);
                    if (el) {
                        if (dId === id) {
                            el.classList.toggle('hidden');
                        } else {
                            el.classList.add('hidden');
                        }
                    }
                });
            }
        </script>

        <div class="p-4 border-t border-ink-150">
            <a href="<?= base_url('admin/logout') ?>" class="w-full flex items-center justify-center gap-2 py-2 px-3 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-md text-xs transition-all">
                <i class="fa-solid fa-right-from-bracket"></i> Sign Out
            </a>
        </div>
    </aside>

    <!-- Beautiful Toast Container in Top-Right Corner -->
    <div id="toast-container" class="fixed top-6 right-6 z-[9999] flex flex-col gap-3 pointer-events-none">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="toast-item bg-white border border-ink-150 rounded-lg p-3.5 shadow-lg flex items-start gap-3 w-80 pointer-events-auto transform translate-y-2 opacity-0 transition-all duration-300">
                <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-base"></i>
                <div class="flex-1 font-sans">
                    <h5 class="text-xs font-bold font-jakarta text-ink-900">Success</h5>
                    <p class="text-[11px] text-ink-500 mt-0.5"><?= htmlspecialchars($this->session->flashdata('success')) ?></p>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="toast-item bg-white border border-ink-150 rounded-lg p-3.5 shadow-lg flex items-start gap-3 w-80 pointer-events-auto transform translate-y-2 opacity-0 transition-all duration-300">
                <i class="fa-solid fa-circle-xmark text-rose-600 mt-0.5 text-base"></i>
                <div class="flex-1 font-sans">
                    <h5 class="text-xs font-bold font-jakarta text-ink-900">Error</h5>
                    <p class="text-[11px] text-ink-500 mt-0.5"><?= htmlspecialchars($this->session->flashdata('error')) ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Custom Beautiful Confirmation Modal -->
    <div id="confirm-modal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center bg-ink-900/40 backdrop-blur-sm p-4 transition-all duration-300 opacity-0">
        <div class="bg-white rounded-lg border border-ink-150 p-6 max-w-sm w-full transform scale-95 transition-all duration-300 flex flex-col gap-4 font-sans">
            <div class="flex items-start gap-3.5">
                <div class="w-9 h-9 rounded-md bg-accent-50 flex items-center justify-center text-accent-500 shrink-0 border border-accent-100">
                    <i class="fa-solid fa-circle-question text-base"></i>
                </div>
                <div class="flex-1">
                    <h4 id="confirm-modal-title" class="text-xs font-bold font-jakarta text-ink-900 uppercase tracking-wider">Confirm Action</h4>
                    <p id="confirm-modal-message" class="text-xs text-ink-700 mt-2 leading-relaxed">Apakah Anda yakin ingin melakukan aksi ini?</p>
                </div>
            </div>
            <div class="flex justify-end gap-2.5 mt-2">
                <button onclick="closeConfirmModal()" class="px-3 py-2 border border-ink-300 rounded-[6px] text-xs font-semibold text-ink-700 hover:bg-ink-50 transition-all">Cancel</button>
                <a id="confirm-modal-btn" href="#" class="px-3 py-2 bg-accent-500 hover:bg-accent-600 text-white rounded-[6px] text-xs font-semibold shadow-sm transition-all">Confirm</a>
            </div>
        </div>
    </div>

    <!-- Custom Beautiful Exit Warning Modal -->
    <div id="exit-warn-modal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center bg-ink-900/40 backdrop-blur-sm p-4 transition-all duration-300 opacity-0">
        <div class="bg-white rounded-lg border border-ink-150 p-6 max-w-sm w-full transform scale-95 transition-all duration-300 flex flex-col gap-4 font-sans">
            <div class="flex items-start gap-3.5">
                <div class="w-9 h-9 rounded-md bg-amber-50 flex items-center justify-center text-amber-500 shrink-0 border border-amber-100">
                    <i class="fa-solid fa-triangle-exclamation text-base"></i>
                </div>
                <div class="flex-1">
                    <h4 class="text-xs font-bold font-jakarta text-ink-900 uppercase tracking-wider">Unsaved Changes</h4>
                    <p class="text-xs text-ink-700 mt-2 leading-relaxed">You have unsaved changes. Are you sure you want to leave this page?</p>
                </div>
            </div>
            <div class="flex justify-end gap-2.5 mt-2">
                <button onclick="closeExitWarnModal()" class="px-3 py-2 border border-ink-300 rounded-[6px] text-xs font-semibold text-ink-700 hover:bg-ink-50 transition-all">Stay on Page</button>
                <a id="exit-warn-confirm-btn" href="#" class="px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-[6px] text-xs font-semibold shadow-sm transition-all">Leave Page</a>
            </div>
        </div>
    </div>

    <!-- Custom Beautiful Saving/Uploading Loading Modal -->
    <div id="saving-modal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center bg-ink-900/40 backdrop-blur-sm p-4 transition-all duration-300 opacity-0">
        <div class="bg-white rounded-lg border border-ink-150 p-6 max-w-sm w-full transform scale-95 transition-all duration-300 flex flex-col gap-4 font-sans items-center text-center">
            <div class="w-12 h-12 rounded-full bg-accent-50 flex items-center justify-center text-accent-500 shrink-0 border border-accent-100 animate-spin">
                <i class="fa-solid fa-spinner text-xl"></i>
            </div>
            <div>
                <h4 id="saving-modal-title" class="text-xs font-bold font-jakarta text-ink-900 uppercase tracking-wider">Uploading Images</h4>
                <p id="saving-modal-message" class="text-xs text-ink-700 mt-2 leading-relaxed">Please wait while we optimize and upload your images to Supabase...</p>
            </div>
        </div>
    </div>

    <script>
        // Form dirtiness tracking
        let formModified = false;
        
        function setFormModified(val) {
            formModified = val;
        }

        // Deferred Uploads maps field ID to Selected File Info
        const pendingUploads = {};

        function handleImageSelect(input, hiddenInputId, previewId, statusId) {
            const file = input.files[0];
            if (!file) return;

            // Store in pendingUploads
            pendingUploads[hiddenInputId] = {
                file: file,
                statusId: statusId,
                previewId: previewId
            };

            // Local preview
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewEl = document.getElementById(previewId);
                if (previewEl) {
                    previewEl.innerHTML = `<img src="${e.target.result}" alt="Preview" class="h-full w-full object-contain">`;
                }
            };
            reader.readAsDataURL(file);

            const statusEl = document.getElementById(statusId);
            if (statusEl) {
                statusEl.textContent = "Gambar dipilih (belum disimpan)";
                statusEl.className = "text-[10px] text-amber-600 font-bold mt-1 block";
                statusEl.classList.remove("hidden");
            }
        }

        // Global async form handler for Save Content button
        async function handleFormSubmit(event, uploadUrl) {
            event.preventDefault();
            const form = event.target;
            const keys = Object.keys(pendingUploads);
            
            if (keys.length > 0) {
                showSavingModal("Uploading Images", "Please wait while we optimize and upload your images to Supabase...");
                
                for (const key of keys) {
                    const item = pendingUploads[key];
                    const statusEl = document.getElementById(item.statusId);
                    if (statusEl) {
                        statusEl.textContent = "Mengunggah ke Supabase...";
                        statusEl.className = "text-[10px] text-blue-600 font-bold mt-1 block";
                    }

                    const formData = new FormData();
                    formData.append("image", item.file);

                    try {
                        const response = await fetch(uploadUrl, {
                            method: "POST",
                            body: formData
                        });
                        const data = await response.json();
                        if (data.success) {
                            const hiddenInput = document.getElementById(key);
                            if (hiddenInput) {
                                hiddenInput.value = data.url;
                            }
                            if (statusEl) {
                                statusEl.textContent = "Berhasil diunggah!";
                                statusEl.className = "text-[10px] text-green-600 font-bold mt-1 block";
                            }
                            // Clean from pending
                            delete pendingUploads[key];
                        } else {
                            alert("Gagal mengunggah: " + data.message);
                            hideSavingModal();
                            return false;
                        }
                    } catch (err) {
                        alert("Gagal menghubungi server untuk mengunggah gambar.");
                        hideSavingModal();
                        return false;
                    }
                }
                hideSavingModal();
            }
            
            // Bypass warning
            formModified = false;
            form.submit();
        }

        // Custom warning modal helper functions
        function showExitWarnModal(targetUrl) {
            const modal = document.getElementById('exit-warn-modal');
            const confirmBtn = document.getElementById('exit-warn-confirm-btn');
            confirmBtn.href = targetUrl;
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.firstElementChild.classList.remove('scale-95');
            }, 50);
        }

        function closeExitWarnModal() {
            const modal = document.getElementById('exit-warn-modal');
            modal.classList.add('opacity-0');
            modal.firstElementChild.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Saving loading modal helper functions
        function showSavingModal(title, message) {
            const modal = document.getElementById('saving-modal');
            const modalTitle = document.getElementById('saving-modal-title');
            const modalMessage = document.getElementById('saving-modal-message');
            if (title) modalTitle.textContent = title;
            if (message) modalMessage.textContent = message;
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.firstElementChild.classList.remove('scale-95');
            }, 50);
        }

        function hideSavingModal() {
            const modal = document.getElementById('saving-modal');
            modal.classList.add('opacity-0');
            modal.firstElementChild.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Insert subscriber tag helper
        function insertTag(tag, fieldId) {
            const input = document.getElementById(fieldId);
            if (input) {
                const startPos = input.selectionStart;
                const endPos = input.selectionEnd;
                const text = input.value;
                input.value = text.substring(0, startPos) + tag + text.substring(endPos, text.length);
                input.focus();
                input.selectionStart = startPos + tag.length;
                input.selectionEnd = startPos + tag.length;
            }
        }

        // Custom Confirmation Modal Helper
        function showConfirmModal(title, message, confirmUrl) {
            const modal = document.getElementById('confirm-modal');
            const modalTitle = document.getElementById('confirm-modal-title');
            const modalMessage = document.getElementById('confirm-modal-message');
            const modalBtn = document.getElementById('confirm-modal-btn');
            
            if (title) modalTitle.textContent = title;
            if (message) modalMessage.textContent = message;
            modalBtn.href = confirmUrl;
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.firstElementChild.classList.remove('scale-95');
            }, 50);
        }

        function closeConfirmModal() {
            const modal = document.getElementById('confirm-modal');
            modal.classList.add('opacity-0');
            modal.firstElementChild.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Auto-dismiss Flash Toasts
        document.addEventListener('DOMContentLoaded', () => {
            const toasts = document.querySelectorAll('.toast-item');
            toasts.forEach((toast, idx) => {
                // Fade in
                setTimeout(() => {
                    toast.classList.remove('opacity-0', 'translate-y-2');
                    toast.classList.add('opacity-100', 'translate-y-0');
                }, 100 * (idx + 1));
                
                // Fade out and remove
                setTimeout(() => {
                    toast.classList.remove('opacity-100', 'translate-y-0');
                    toast.classList.add('opacity-0', 'translate-y-2');
                    setTimeout(() => toast.remove(), 300);
                }, 3500 + (100 * idx));
            });

            // Track form dirty state
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('input', () => {
                    formModified = true;
                });
                form.addEventListener('change', () => {
                    formModified = true;
                });
                form.addEventListener('submit', () => {
                    formModified = false;
                });
            });

            // Browser unload warning for exit/reload
            window.addEventListener('beforeunload', (e) => {
                if (formModified) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });

            // Hijack native clicks
            document.body.addEventListener('click', (e) => {
                let target = e.target;
                while (target && target !== document.body) {
                    // Hijack native confirm clicks to show our custom confirmation modal!
                    if (target.tagName === 'A' && target.hasAttribute('onclick')) {
                        const onclickAttr = target.getAttribute('onclick');
                        if (onclickAttr && onclickAttr.includes('confirm(')) {
                            e.preventDefault();
                            e.stopPropagation();
                            
                            let msg = "Apakah Anda yakin ingin melakukan aksi ini?";
                            const match = onclickAttr.match(/confirm\(['"](.*?)['"]\)/);
                            if (match && match[1]) {
                                msg = match[1];
                            }
                            
                            const title = target.getAttribute('title') || "Confirm Action";
                            const confirmUrl = target.getAttribute('href');
                            showConfirmModal(title, msg, confirmUrl);
                            return;
                        }
                    }

                    // Hijack internal links to show custom warning modal on leave
                    if (target.tagName === 'A' && target.getAttribute('href')) {
                        const href = target.getAttribute('href');
                        if (target.id === 'exit-warn-confirm-btn') {
                            formModified = false;
                            return;
                        }
                        if (href && !href.startsWith('#') && !href.startsWith('javascript:') && !target.hasAttribute('download')) {
                            if (formModified) {
                                e.preventDefault();
                                e.stopPropagation();
                                showExitWarnModal(href);
                                return;
                            }
                        }
                    }
                    target = target.parentNode;
                }
            }, true);

            // Intercept browser back button arrow to show custom warning modal
            history.pushState(null, document.title, location.href);
            window.addEventListener('popstate', function (event) {
                if (formModified) {
                    history.pushState(null, document.title, location.href);
                    showExitWarnModal(document.referrer || '<?= base_url("newsletters") ?>');
                } else {
                    history.back();
                }
            });
        });
    </script>

    <!-- Main Workspace Area -->
    <div class="flex-1 pl-[240px] flex flex-col min-h-screen">
        <!-- Minimalist Topbar -->
        <header class="h-16 bg-white border-b border-ink-150 flex items-center justify-between px-8 sticky top-0 z-40">
            <div class="flex items-center gap-2 text-xs text-ink-500 font-medium font-sans">
                <span>CMS Admin</span>
                <i class="fa-solid fa-chevron-right text-[10px] text-ink-300"></i>
                <span class="text-ink-900 font-semibold font-jakarta"><?= isset($title) ? htmlspecialchars($title) : 'Dashboard' ?></span>
            </div>
            
            <div class="flex items-center gap-4">
                <button class="text-ink-500 hover:text-ink-900 relative">
                    <i class="fa-regular fa-bell text-base"></i>
                    <span class="absolute top-0 right-0 w-1.5 h-1.5 bg-accent-500 rounded-full"></span>
                </button>
                <div class="h-5 w-px bg-ink-150"></div>
                <div class="flex items-center gap-2 font-sans">
                    <span class="text-xs font-semibold text-ink-900"><?= isset($admin->username) ? $admin->username : 'Administrator' ?></span>
                    <span class="px-2 py-0.5 bg-ink-50 text-ink-500 rounded-md text-[10px] font-bold uppercase tracking-wider">Role: Admin</span>
                </div>
            </div>
        </header>

        <!-- Main Content spacious p-8 container -->
        <main class="flex-1 p-6">
