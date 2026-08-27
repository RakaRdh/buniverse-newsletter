<?php $this->load->view('admin/header', ['title' => 'Dashboard']); ?>

<!-- 1. Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Newsletters Card -->
    <div class="bg-white border border-ink-150 rounded-lg p-5 flex items-center justify-between">
        <div>
            <p class="text-[11px] font-bold text-ink-500 uppercase tracking-wider mb-1">Total Newsletters</p>
            <h3 class="text-2xl font-bold font-jakarta text-ink-900 tracking-tight" style="font-variant-numeric: tabular-nums;"><?= number_format($total_newsletters) ?></h3>
        </div>
    </div>

    <!-- Total Subscribers Card -->
    <div class="bg-white border border-ink-150 rounded-lg p-5 flex items-center justify-between">
        <div>
            <p class="text-[11px] font-bold text-ink-500 uppercase tracking-wider mb-1">Total Subscribers</p>
            <h3 class="text-2xl font-bold font-jakarta text-ink-900 tracking-tight" style="font-variant-numeric: tabular-nums;"><?= number_format($total_subscribers) ?></h3>
        </div>
    </div>

    <!-- Total Logs Card -->
    <div class="bg-white border border-ink-150 rounded-lg p-5 flex items-center justify-between">
        <div>
            <p class="text-[11px] font-bold text-ink-500 uppercase tracking-wider mb-1">Total Sent Emails</p>
            <h3 class="text-2xl font-bold font-jakarta text-ink-900 tracking-tight" style="font-variant-numeric: tabular-nums;"><?= number_format($total_logs) ?></h3>
        </div>
    </div>
</div>

<!-- 2. Two-Column Split Layout -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Left Column: History Logs -->
    <div class="bg-white border border-ink-150 rounded-lg p-5 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold font-jakarta text-ink-900 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-ink-500"></i> Recent Send Logs
                </h2>
                <a href="<?= base_url('logs') ?>" class="text-[11px] font-bold text-accent-500 hover:text-accent-600 transition-all flex items-center gap-1">
                    Lihat Selengkapnya <i class="fa-solid fa-arrow-right text-[9px]"></i>
                </a>
            </div>

            <div class="overflow-x-auto border border-ink-150 rounded-lg mb-4">
                <table class="w-full border-collapse text-left text-xs">
                    <thead>
                        <tr class="bg-ink-50 border-b border-ink-150 text-ink-700 font-bold uppercase tracking-wider">
                            <th class="p-3 text-[11px]">Sent At</th>
                            <th class="p-3 text-[11px]">Portal</th>
                            <th class="p-3 text-[11px]">Subject</th>
                            <th class="p-3 text-right text-[11px]">Recipients</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink-150">
                        <?php if (empty($recent_logs)): ?>
                            <tr>
                                <td colspan="4" class="p-6 text-center text-ink-500">No send logs recorded yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recent_logs as $log): ?>
                                <tr class="hover:bg-accent-50/50 transition-all">
                                    <td class="p-3 text-ink-700 whitespace-nowrap">
                                        <?= date('d M Y, H:i', strtotime($log['sent_at'])) ?>
                                    </td>
                                    <td class="p-3">
                                        <?php if ($log['portal'] === 'beritasatu'): ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-[#FBE6E2] text-[#C4432E]">BeritaSatu</span>
                                        <?php elseif ($log['portal'] === 'investor'): ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-[#E7EFF7] text-[#3A6FA8]">Investor.id</span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-[#FBEFDD] text-[#B8791A]">JakartaGlobe</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-3 font-semibold text-ink-900 truncate max-w-[120px]" title="<?= htmlspecialchars($log['subject']) ?>">
                                        <?= htmlspecialchars($log['subject']) ?>
                                    </td>
                                    <td class="p-3 text-right font-medium text-ink-700 whitespace-nowrap" style="font-variant-numeric: tabular-nums;">
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
    <div class="bg-white border border-ink-150 rounded-lg p-5 flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold font-jakarta text-ink-900 flex items-center gap-2">
                    <i class="fa-solid fa-users text-ink-500"></i> Recent Subscribers
                </h2>
                <a href="<?= base_url('subscribers') ?>" class="text-[11px] font-bold text-accent-500 hover:text-accent-600 transition-all flex items-center gap-1">
                    Lihat Selengkapnya <i class="fa-solid fa-arrow-right text-[9px]"></i>
                </a>
            </div>

            <div class="overflow-x-auto border border-ink-150 rounded-lg mb-4">
                <table class="w-full border-collapse text-left text-xs">
                    <thead>
                        <tr class="bg-ink-50 border-b border-ink-150 text-ink-700 font-bold uppercase tracking-wider">
                            <th class="p-3 text-[11px]">Name</th>
                            <th class="p-3 text-[11px]">Email</th>
                            <th class="p-3 text-right text-[11px]">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-ink-150">
                        <?php if (empty($recent_subscribers)): ?>
                            <tr>
                                <td colspan="3" class="p-6 text-center text-ink-500">No subscribers added yet.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recent_subscribers as $sub): ?>
                                <tr class="hover:bg-accent-50/50 transition-all">
                                    <td class="p-3 font-semibold text-ink-900 truncate max-w-[100px]" title="<?= htmlspecialchars($sub['name']) ?>">
                                        <?= htmlspecialchars($sub['name']) ?>
                                    </td>
                                    <td class="p-3 text-ink-700 truncate max-w-[120px]" title="<?= htmlspecialchars($sub['email']) ?>">
                                        <?= htmlspecialchars($sub['email']) ?>
                                    </td>
                                    <td class="p-3 text-right">
                                        <?php if ($sub['status'] === 'active'): ?>
                                            <span class="inline-flex items-center gap-1.5 justify-end">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#2E7D5B]"></span>
                                                <span class="text-ink-900 font-medium">Active</span>
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1.5 justify-end">
                                                <span class="w-1.5 h-1.5 rounded-full bg-[#C4432E]"></span>
                                                <span class="text-ink-900 font-medium">Inactive</span>
                                            </span>
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
