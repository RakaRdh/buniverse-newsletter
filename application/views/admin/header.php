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

                    <!-- Jakarta Globe Dropdown -->
                    <div>
                        <button onclick="toggleDropdown('dropdown-jakartaglobe')" class="w-full flex items-center justify-between py-2 px-3 text-xs font-medium rounded-md text-ink-700 hover:bg-ink-50 hover:text-ink-900 transition-all">
                            <span class="flex items-center gap-3">
                                <span class="w-2 h-2 rounded-full bg-orange-500"></span> Jakarta Globe
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

            <!-- Global Group -->
            <div>
                <div class="px-3 mb-2 text-[11px] font-bold text-ink-500 uppercase tracking-wider">System</div>
                <div class="space-y-1">
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
                const dropdown = document.getElementById(id);
                if (dropdown) {
                    dropdown.classList.toggle('hidden');
                }
            }
        </script>

        <div class="p-4 border-t border-ink-150">
            <a href="<?= base_url('admin/logout') ?>" class="w-full flex items-center justify-center gap-2 py-2 px-3 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-md text-xs transition-all">
                <i class="fa-solid fa-right-from-bracket"></i> Sign Out
            </a>
        </div>
    </aside>

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
            <?php if ($this->session->flashdata('success')): ?>
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg flex items-center gap-3 text-xs">
                    <i class="fa-solid fa-circle-check text-base text-emerald-600"></i>
                    <span><?= $this->session->flashdata('success') ?></span>
                </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-lg flex items-center gap-3 text-xs">
                    <i class="fa-solid fa-circle-xmark text-base text-rose-600"></i>
                    <span><?= $this->session->flashdata('error') ?></span>
                </div>
            <?php endif; ?>
