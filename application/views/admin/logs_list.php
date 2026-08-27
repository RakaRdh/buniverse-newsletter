<?php 
$this->load->view('admin/header', ['title' => $title]); 

// Sorting Helper Functions
function get_sort_url($col, $current_col, $current_order) {
    $CI =& get_instance();
    $params = $CI->input->get();
    $params['sort_col'] = $col;
    $params['sort_order'] = ($col === $current_col && $current_order === 'asc') ? 'desc' : 'asc';
    return current_url() . '?' . http_build_query($params);
}

function get_sort_icon($col, $current_col, $current_order) {
    if ($col !== $current_col) {
        return '<i class="fa-solid fa-sort text-ink-300 ml-1.5 text-[10px]"></i>';
    }
    return $current_order === 'asc' 
        ? '<i class="fa-solid fa-sort-up text-accent-500 ml-1.5 text-[11px] -mb-1"></i>' 
        : '<i class="fa-solid fa-sort-down text-accent-500 ml-1.5 text-[11px] -mt-1"></i>';
}
?>

<div class="bg-white border border-ink-150 rounded-lg p-5">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-lg font-bold font-jakarta text-ink-900"><?= htmlspecialchars($title) ?></h1>
            <p class="text-xs text-ink-500 mt-0.5">Audit log of all sent newsletter editions for <?= ucfirst($portal) ?></p>
        </div>
        <?php if ($portal === 'beritasatu'): ?>
            <span class="px-2.5 py-0.5 bg-[#FBE6E2] text-[#C4432E] border border-transparent rounded-[6px] text-xs font-bold uppercase tracking-wider">BeritaSatu</span>
        <?php elseif ($portal === 'investor'): ?>
            <span class="px-2.5 py-0.5 bg-[#E7EFF7] text-[#3A6FA8] border border-transparent rounded-[6px] text-xs font-bold uppercase tracking-wider">Investor.id</span>
        <?php elseif ($portal === 'jakartaglobe'): ?>
            <span class="px-2.5 py-0.5 bg-[#FBEFDD] text-[#B8791A] border border-transparent rounded-[6px] text-xs font-bold uppercase tracking-wider">Jakarta Globe</span>
        <?php else: ?>
            <span class="px-2.5 py-0.5 bg-ink-50 text-ink-700 border border-ink-300 rounded-[6px] text-xs font-bold uppercase tracking-wider">All Portals</span>
        <?php endif; ?>
    </div>

    <!-- Filter Bar -->
    <form action="" method="GET" class="bg-ink-50 border border-ink-150 rounded-lg p-4 mb-6 flex flex-wrap items-end gap-3">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-[11px] font-bold text-ink-500 uppercase mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="<?= htmlspecialchars($start_date ?? '') ?>" class="w-full h-9 px-3 py-2 text-xs bg-white border border-ink-300 rounded-lg text-ink-900 focus:outline-none focus:border-accent-500 focus:ring-1 focus:ring-accent-100">
        </div>
        <div class="flex-1 min-w-[200px]">
            <label class="block text-[11px] font-bold text-ink-500 uppercase mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="<?= htmlspecialchars($end_date ?? '') ?>" class="w-full h-9 px-3 py-2 text-xs bg-white border border-ink-300 rounded-lg text-ink-900 focus:outline-none focus:border-accent-500 focus:ring-1 focus:ring-accent-100">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-3.5 py-2 bg-accent-500 hover:bg-accent-600 text-white font-bold rounded-[6px] text-xs transition-all flex items-center gap-1.5 h-9 shadow-sm">
                <i class="fa-solid fa-filter text-[10px]"></i> Filter
            </button>
            <?php if (!empty($start_date) || !empty($end_date) || $sort_col !== 'sent_at' || $sort_order !== 'desc'): ?>
                <a href="<?= current_url() ?>" class="px-3.5 py-2 bg-white hover:bg-ink-50 text-ink-900 border border-ink-300 font-bold rounded-[6px] text-xs transition-all flex items-center justify-center gap-1.5 h-9">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            <?php endif; ?>
        </div>
    </form>

    <div class="overflow-x-auto border border-ink-150 rounded-lg">
        <table class="w-full border-collapse text-left text-xs">
            <thead>
                <tr class="bg-ink-50 border-b border-ink-150 text-ink-700 font-bold uppercase tracking-wider">
                    <th class="p-3 text-[11px]">
                        <a href="<?= get_sort_url('sent_at', $sort_col, $sort_order) ?>" class="flex items-center hover:text-accent-500 transition-all">
                            Sent At <?= get_sort_icon('sent_at', $sort_col, $sort_order) ?>
                        </a>
                    </th>
                    <?php if ($portal === 'all'): ?>
                        <th class="p-3 text-[11px]">Portal</th>
                    <?php endif; ?>
                    <th class="p-3 text-[11px]">Edition (Vol)</th>
                    <th class="p-3 text-[11px]">Subject</th>
                    <th class="p-3 text-[11px]">
                        <a href="<?= get_sort_url('recipients', $sort_col, $sort_order) ?>" class="flex items-center hover:text-accent-500 transition-all">
                            Recipients <?= get_sort_icon('recipients', $sort_col, $sort_order) ?>
                        </a>
                    </th>
                    <th class="p-3 text-right pr-4 text-[11px]">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-ink-150">
                <?php if (empty($logs)): ?>
                    <tr>
                        <td colspan="<?= $portal === 'all' ? 6 : 5 ?>" class="p-8 text-center text-ink-500">No sending history found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                        <tr class="hover:bg-accent-50/50 transition-all">
                            <td class="p-3 text-ink-700" style="font-variant-numeric: tabular-nums;"><?= date('d M Y, H:i', strtotime($log['sent_at'])) ?></td>
                            <?php if ($portal === 'all'): ?>
                                <td class="p-3">
                                    <?php if ($log['portal'] === 'beritasatu'): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-[#FBE6E2] text-[#C4432E]">BeritaSatu</span>
                                    <?php elseif ($log['portal'] === 'investor'): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-[#E7EFF7] text-[#3A6FA8]">Investor.id</span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-[#FBEFDD] text-[#B8791A]">Jakarta Globe</span>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
                            <td class="p-3 text-ink-900 font-semibold" style="font-variant-numeric: tabular-nums;">Vol <?= htmlspecialchars($log['volume']) ?></td>
                            <td class="p-3 text-ink-900 font-semibold"><?= htmlspecialchars($log['subject']) ?></td>
                            <td class="p-3">
                                <span class="inline-flex items-center px-2 py-0.5 bg-[#E7EFF7] text-[#3A6FA8] rounded text-[10px] font-bold uppercase tracking-wider" style="font-variant-numeric: tabular-nums;">
                                    <?= htmlspecialchars($log['recipients_count']) ?> emails
                                </span>
                            </td>
                            <td class="p-3 text-right pr-4">
                                <a href="<?= base_url('newsletters/detail/' . $log['newsletter_id']) ?>" target="_blank" class="inline-flex items-center gap-1.5 py-1.5 px-2.5 bg-ink-50 hover:bg-ink-150 text-ink-900 border border-ink-300 rounded-[6px] text-xs transition-all">
                                    <i class="fa-solid fa-eye text-ink-500"></i> Lihat Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->load->view('admin/footer'); ?>
