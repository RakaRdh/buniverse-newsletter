<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'CMS' ?> - B-Universe CMS</title>
    <link rel="shortcut icon" href="<?= base_url('assets/favicon.ico') ?>" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex">

    <!-- Fixed Left Sidebar -->
    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col fixed inset-y-0 left-0 z-50">
        <div class="h-16 flex items-center px-6 border-b border-slate-200">
            <a href="<?= base_url() ?>" class="font-bold text-xl text-[#20254D] flex items-center gap-2">
                <span class="w-8 h-8 bg-[#20254D] rounded-lg flex items-center justify-center text-[#EC1C24] text-sm">B</span>
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

        <nav class="flex-1 py-6 px-4 space-y-6 overflow-y-auto">
            <!-- Main Menu Group -->
            <div>
                <div class="px-3 mb-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Main Menu</div>
                <div class="space-y-1">
                    <a href="<?= base_url('dashboard') ?>" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-all <?= (uri_string() === 'dashboard' || uri_string() === '') ? 'border-l-4 border-[#EC1C24] bg-[#20254D]/5 text-[#20254D] font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                        <i class="fa-solid fa-chart-line w-5"></i> Dashboard
                    </a>
                    <a href="<?= base_url('newsletters') ?>" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-all <?= (uri_string() === 'newsletters' && $current_portal === null) ? 'border-l-4 border-[#EC1C24] bg-[#20254D]/5 text-[#20254D] font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                        <i class="fa-solid fa-newspaper w-5"></i> All Newsletters
                    </a>
                </div>
            </div>

            <!-- Contents Group with Dropdowns -->
            <div>
                <div class="px-3 mb-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Portals</div>
                <div class="space-y-2">
                    <!-- BeritaSatu Dropdown -->
                    <div>
                        <button onclick="toggleDropdown('dropdown-beritasatu')" class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-lg text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all">
                            <span class="flex items-center gap-3">
                                <span class="w-2.5 h-2.5 rounded-full bg-[#EC1C24]"></span> BeritaSatu
                            </span>
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </button>
                        <div id="dropdown-beritasatu" class="<?= $current_portal === 'beritasatu' ? '' : 'hidden' ?> pl-6 mt-1 space-y-1">
                            <a href="<?= base_url('newsletters?portal=beritasatu') ?>" class="block py-1.5 px-3 text-xs font-medium rounded text-slate-500 hover:text-slate-900 hover:bg-slate-100/50 <?= (uri_string() === 'newsletters' && $current_portal === 'beritasatu') ? 'text-[#EC1C24] font-bold' : '' ?>">Newsletter</a>
                            <a href="<?= base_url('logs/beritasatu') ?>" class="block py-1.5 px-3 text-xs font-medium rounded text-slate-500 hover:text-slate-900 hover:bg-slate-100/50 <?= (uri_string() === 'logs/beritasatu') ? 'text-[#EC1C24] font-bold' : '' ?>">History Logs</a>
                        </div>
                    </div>

                    <!-- Investor Dropdown -->
                    <div>
                        <button onclick="toggleDropdown('dropdown-investor')" class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-lg text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all">
                            <span class="flex items-center gap-3">
                                <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span> Investor.id
                            </span>
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </button>
                        <div id="dropdown-investor" class="<?= $current_portal === 'investor' ? '' : 'hidden' ?> pl-6 mt-1 space-y-1">
                            <a href="<?= base_url('newsletters?portal=investor') ?>" class="block py-1.5 px-3 text-xs font-medium rounded text-slate-500 hover:text-slate-900 hover:bg-slate-100/50 <?= (uri_string() === 'newsletters' && $current_portal === 'investor') ? 'text-[#20254D] font-bold' : '' ?>">Newsletter</a>
                            <a href="<?= base_url('logs/investor') ?>" class="block py-1.5 px-3 text-xs font-medium rounded text-slate-500 hover:text-slate-900 hover:bg-slate-100/50 <?= (uri_string() === 'logs/investor') ? 'text-[#20254D] font-bold' : '' ?>">History Logs</a>
                        </div>
                    </div>

                    <!-- Jakarta Globe Dropdown -->
                    <div>
                        <button onclick="toggleDropdown('dropdown-jakartaglobe')" class="w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium rounded-lg text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all">
                            <span class="flex items-center gap-3">
                                <span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span> Jakarta Globe
                            </span>
                            <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </button>
                        <div id="dropdown-jakartaglobe" class="<?= $current_portal === 'jakartaglobe' ? '' : 'hidden' ?> pl-6 mt-1 space-y-1">
                            <a href="<?= base_url('newsletters?portal=jakartaglobe') ?>" class="block py-1.5 px-3 text-xs font-medium rounded text-slate-500 hover:text-slate-900 hover:bg-slate-100/50 <?= (uri_string() === 'newsletters' && $current_portal === 'jakartaglobe') ? 'text-orange-500 font-bold' : '' ?>">Newsletter</a>
                            <a href="<?= base_url('logs/jakartaglobe') ?>" class="block py-1.5 px-3 text-xs font-medium rounded text-slate-500 hover:text-slate-900 hover:bg-slate-100/50 <?= (uri_string() === 'logs/jakartaglobe') ? 'text-orange-500 font-bold' : '' ?>">History Logs</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Global Group -->
            <div>
                <div class="px-3 mb-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">System</div>
                <div class="space-y-1">
                    <a href="<?= base_url('logs') ?>" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-all <?= (uri_string() === 'logs') ? 'border-l-4 border-[#EC1C24] bg-[#20254D]/5 text-[#20254D] font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                        <i class="fa-solid fa-clock-rotate-left w-5"></i> History Logs
                    </a>
                    <a href="<?= base_url('subscribers') ?>" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-all <?= (uri_string() === 'subscribers') ? 'border-l-4 border-[#EC1C24] bg-[#20254D]/5 text-[#20254D] font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' ?>">
                        <i class="fa-solid fa-users w-5"></i> Subscribers
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

        <div class="p-4 border-t border-slate-200">
            <a href="<?= base_url('admin/logout') ?>" class="w-full flex items-center justify-center gap-2 py-2 px-4 bg-red-50 hover:bg-red-100 text-red-600 font-semibold rounded-lg text-sm transition-all">
                <i class="fa-solid fa-right-from-bracket"></i> Sign Out
            </a>
        </div>
    </aside>

    <!-- Main Workspace Area -->
    <div class="flex-1 pl-64 flex flex-col min-h-screen">
        <!-- Minimalist Topbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-40 shadow-sm">
            <div class="flex items-center gap-2 text-sm text-slate-500 font-medium">
                <span>CMS Admin</span>
                <i class="fa-solid fa-chevron-right text-xs"></i>
                <span class="text-slate-800 font-semibold"><?= isset($title) ? htmlspecialchars($title) : 'Dashboard' ?></span>
            </div>
            
            <div class="flex items-center gap-4">
                <button class="text-slate-400 hover:text-slate-600 relative">
                    <i class="fa-regular fa-bell text-lg"></i>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-[#EC1C24] rounded-full"></span>
                </button>
                <div class="h-6 w-px bg-slate-200"></div>
                <div class="flex items-center gap-2">
                    <span class="text-sm font-semibold text-[#20254D]"><?= isset($admin->username) ? $admin->username : 'Administrator' ?></span>
                    <span class="px-2 py-0.5 bg-slate-100 text-slate-500 rounded text-xs font-bold uppercase tracking-wider">Role: Admin</span>
                </div>
            </div>
        </header>

        <!-- Main Content spacious p-8 container -->
        <main class="flex-1 p-8">
            <?php if ($this->session->flashdata('success')): ?>
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    <span><?= $this->session->flashdata('success') ?></span>
                </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-center gap-3">
                    <i class="fa-solid fa-circle-xmark text-lg"></i>
                    <span><?= $this->session->flashdata('error') ?></span>
                </div>
            <?php endif; ?>
