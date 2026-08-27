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
        return '<i class="fa-solid fa-sort text-slate-300 ml-1.5 text-[10px]"></i>';
    }
    return $current_order === 'asc' 
        ? '<i class="fa-solid fa-sort-up text-[#EC1C24] ml-1.5 text-[11px] -mb-1"></i>' 
        : '<i class="fa-solid fa-sort-down text-[#EC1C24] ml-1.5 text-[11px] -mt-1"></i>';
}
?>

<div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-[#20254D]"><?= htmlspecialchars($title) ?></h1>
            <p class="text-sm text-slate-500 mt-1">Audit log of all sent newsletter editions for <?= ucfirst($portal) ?></p>
        </div>
        <?php if ($portal === 'beritasatu'): ?>
            <span class="px-2.5 py-0.5 bg-red-50 text-[#EC1C24] border border-red-200 rounded-full text-xs font-bold uppercase tracking-wider">BeritaSatu</span>
        <?php elseif ($portal === 'investor'): ?>
            <span class="px-2.5 py-0.5 bg-sky-50 text-sky-600 border border-sky-200 rounded-full text-xs font-bold uppercase tracking-wider">Investor.id</span>
        <?php elseif ($portal === 'jakartaglobe'): ?>
            <span class="px-2.5 py-0.5 bg-orange-50 text-orange-600 border border-orange-200 rounded-full text-xs font-bold uppercase tracking-wider">Jakarta Globe</span>
        <?php else: ?>
            <span class="px-2.5 py-0.5 bg-slate-100 text-slate-600 border border-slate-200 rounded-full text-xs font-bold uppercase tracking-wider">All Portals</span>
        <?php endif; ?>
    </div>

    <!-- Filter Bar -->
    <form action="" method="GET" class="bg-slate-50 border border-slate-200/80 rounded-xl p-4 mb-6 flex flex-wrap items-end gap-4">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="<?= htmlspecialchars($start_date ?? '') ?>" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:border-[#20254D]">
        </div>
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="<?= htmlspecialchars($end_date ?? '') ?>" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:border-[#20254D]">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-[#20254D] hover:bg-[#161a38] text-white font-bold rounded-lg text-xs transition-all flex items-center gap-1.5 h-[34px]">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
            <?php if (!empty($start_date) || !empty($end_date) || $sort_col !== 'sent_at' || $sort_order !== 'desc'): ?>
                <a href="<?= current_url() ?>" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-705 font-bold rounded-lg text-xs transition-all flex items-center justify-center gap-1.5 h-[34px]">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            <?php endif; ?>
        </div>
    </form>

    <div class="overflow-x-auto border border-slate-200 rounded-lg">
        <table class="w-full border-collapse text-left text-sm">
            <thead>
                <tr class="bg-slate-100/80 border-b border-slate-200 text-[#20254D] font-bold">
                    <th class="p-4">
                        <a href="<?= get_sort_url('sent_at', $sort_col, $sort_order) ?>" class="flex items-center hover:text-[#EC1C24] transition-all">
                            Sent At <?= get_sort_icon('sent_at', $sort_col, $sort_order) ?>
                        </a>
                    </th>
                    <?php if ($portal === 'all'): ?>
                        <th class="p-4">Portal</th>
                    <?php endif; ?>
                    <th class="p-4">Edition (Vol)</th>
                    <th class="p-4">Subject</th>
                    <th class="p-4">
                        <a href="<?= get_sort_url('recipients', $sort_col, $sort_order) ?>" class="flex items-center hover:text-[#EC1C24] transition-all">
                            Recipients <?= get_sort_icon('recipients', $sort_col, $sort_order) ?>
                        </a>
                    </th>
                    <th class="p-4">Preview</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($logs)): ?>
                    <tr>
                        <td colspan="<?= $portal === 'all' ? 6 : 5 ?>" class="p-8 text-center text-slate-400">No sending history found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                        <tr class="hover:bg-slate-50 transition-all">
                            <td class="p-4 text-slate-650 font-medium"><?= date('d M Y, H:i', strtotime($log['sent_at'])) ?></td>
                            <?php if ($portal === 'all'): ?>
                                <td class="p-4">
                                    <?php if ($log['portal'] === 'beritasatu'): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-red-50 text-[#EC1C24]">BeritaSatu</span>
                                    <?php elseif ($log['portal'] === 'investor'): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-600">Investor.id</span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-orange-50 text-orange-600">Jakarta Globe</span>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
                            <td class="p-4 text-slate-800 font-semibold">Vol <?= htmlspecialchars($log['volume']) ?></td>
                            <td class="p-4 text-slate-800 font-semibold"><?= htmlspecialchars($log['subject']) ?></td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                    <?= htmlspecialchars($log['recipients_count']) ?> emails
                                </span>
                            </td>
                            <td class="p-4">
                                <a href="<?= base_url('newsletters/detail/' . $log['newsletter_id']) ?>" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#20254D]/10 hover:bg-[#20254D] hover:text-white text-[#20254D] font-bold rounded-lg text-xs transition-all">
                                    <i class="fa-solid fa-eye"></i> Lihat Detail
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
