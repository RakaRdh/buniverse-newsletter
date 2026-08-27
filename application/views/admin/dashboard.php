<?php $this->load->view('admin/header', ['title' => 'Dashboard']); ?>

<!-- 1. Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Newsletters Card -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-1">Total Newsletters</p>
            <h3 class="text-3xl font-extrabold text-[#20254D]"><?= number_format($total_newsletters) ?></h3>
        </div>
        <div class="w-12 h-12 bg-indigo-50 text-[#20254D] rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-newspaper"></i>
        </div>
    </div>

    <!-- Total Subscribers Card -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-1">Total Subscribers</p>
            <h3 class="text-3xl font-extrabold text-[#20254D]"><?= number_format($total_subscribers) ?></h3>
        </div>
        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-users"></i>
        </div>
    </div>

    <!-- Total Logs Card -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-1">Total Sent Emails</p>
            <h3 class="text-3xl font-extrabold text-[#20254D]"><?= number_format($total_logs) ?></h3>
        </div>
        <div class="w-12 h-12 bg-red-50 text-[#EC1C24] rounded-xl flex items-center justify-center text-xl">
            <i class="fa-solid fa-paper-plane"></i>
        </div>
    </div>
</div>

<!-- 2. Two-Column Split Layout -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Left Column: History Logs -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-[#20254D] flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-slate-400"></i> Recent Send Logs
                </h2>
                <a href="<?= base_url('logs') ?>" class="text-xs font-semibold text-[#EC1C24] hover:underline flex items-center gap-1">
                    Lihat Selengkapnya <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="overflow-x-auto border border-slate-100 rounded-xl mb-4">
                <table class="w-full border-collapse text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200/80 text-slate-500 font-bold">
                            <th class="p-3">Sent At</th>
                            <th class="p-3">Portal</th>
                            <th class="p-3">Subject</th>
                            <th class="p-3 text-right">Recipients</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (empty($recent_logs)): ?>
                            <tr>
                                <td colspan="4" class="p-6 text-center text-slate-400">No send logs recorded yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recent_logs as $log): ?>
                                <tr class="hover:bg-slate-50/50 transition-all">
                                    <td class="p-3 text-slate-500 font-medium whitespace-nowrap">
                                        <?= date('d M Y, H:i', strtotime($log['sent_at'])) ?>
                                    </td>
                                    <td class="p-3">
                                        <?php if ($log['portal'] === 'beritasatu'): ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-red-50 text-[#EC1C24]">BeritaSatu</span>
                                        <?php elseif ($log['portal'] === 'investor'): ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-600">Investor.id</span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-orange-50 text-orange-600">Jakarta Globe</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-3 font-semibold text-slate-800 truncate max-w-[120px]" title="<?= htmlspecialchars($log['subject']) ?>">
                                        <?= htmlspecialchars($log['subject']) ?>
                                    </td>
                                    <td class="p-3 text-right font-medium text-slate-700 whitespace-nowrap">
                                        <?= htmlspecialchars($log['recipients_count']) ?> emails
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: List Subscribers -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-[#20254D] flex items-center gap-2">
                    <i class="fa-solid fa-users text-slate-400"></i> Recent Subscribers
                </h2>
                <a href="<?= base_url('subscribers') ?>" class="text-xs font-semibold text-[#EC1C24] hover:underline flex items-center gap-1">
                    Lihat Selengkapnya <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

            <div class="overflow-x-auto border border-slate-100 rounded-xl mb-4">
                <table class="w-full border-collapse text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200/80 text-slate-500 font-bold">
                            <th class="p-3">Name</th>
                            <th class="p-3">Email</th>
                            <th class="p-3 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (empty($recent_subscribers)): ?>
                            <tr>
                                <td colspan="3" class="p-6 text-center text-slate-400">No subscribers added yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recent_subscribers as $sub): ?>
                                <tr class="hover:bg-slate-50/50 transition-all">
                                    <td class="p-3 font-semibold text-slate-800 truncate max-w-[100px]" title="<?= htmlspecialchars($sub['name']) ?>">
                                        <?= htmlspecialchars($sub['name']) ?>
                                    </td>
                                    <td class="p-3 text-slate-500 truncate max-w-[120px]" title="<?= htmlspecialchars($sub['email']) ?>">
                                        <?= htmlspecialchars($sub['email']) ?>
                                    </td>
                                    <td class="p-3 text-right">
                                        <?php if ($sub['status'] === 'active'): ?>
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-green-50 text-green-700">Active</span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-[#EC1C24]">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/footer'); ?>
