<?php 
$this->load->view('admin/header', ['title' => 'Manage Subscribers']); 

// Helper for subscriber sorting
function get_sub_sort_url($current_order) {
    $CI =& get_instance();
    $params = $CI->input->get();
    if ($current_order === 'normal') {
        $params['sort_order'] = 'desc';
    } elseif ($current_order === 'desc') {
        $params['sort_order'] = 'asc';
    } else {
        $params['sort_order'] = 'normal';
    }
    return current_url() . '?' . http_build_query($params);
}

function get_sub_sort_icon($current_order) {
    if ($current_order === 'normal') {
        return '<i class="fa-solid fa-sort text-ink-300 ml-1.5 text-[10px]"></i>';
    }
    return $current_order === 'asc' 
        ? '<i class="fa-solid fa-sort-up text-accent-500 ml-1.5 text-[11px] -mb-1"></i>' 
        : '<i class="fa-solid fa-sort-down text-accent-500 ml-1.5 text-[11px] -mt-1"></i>';
}
?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left panel: list of subscribers (2/3 width) -->
    <div class="lg:col-span-2 bg-white border border-ink-150 rounded-lg p-5">
        <h2 class="text-sm font-bold font-jakarta text-ink-900 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-list-ul text-ink-500"></i> Subscribers Database
        </h2>

        <!-- Search Form -->
        <form action="<?= base_url('subscribers') ?>" method="GET" class="flex gap-2 mb-4">
            <input type="text" name="search" class="flex-1 h-9 px-3 text-xs bg-white border border-ink-300 rounded-lg text-ink-900 focus:outline-none focus:border-accent-500 focus:ring-1 focus:ring-accent-100" placeholder="Search by name or email..." value="<?= htmlspecialchars($search) ?>">
            <?php if ($sort_order !== 'normal'): ?>
                <input type="hidden" name="sort_order" value="<?= htmlspecialchars($sort_order) ?>">
            <?php endif; ?>
            <button type="submit" class="px-3.5 py-2 bg-accent-500 hover:bg-accent-600 text-white font-bold rounded-[6px] text-xs shadow-sm transition-all flex items-center gap-1.5">
                <i class="fa-solid fa-magnifying-glass text-[10px]"></i> Search
            </button>
            <?php if (!empty($search) || $sort_order !== 'normal'): ?>
                <a href="<?= base_url('subscribers') ?>" class="px-3.5 py-2 bg-white hover:bg-ink-50 text-ink-900 border border-ink-300 font-bold rounded-[6px] text-xs transition-all flex items-center">Clear</a>
            <?php endif; ?>
        </form>

        <div class="overflow-x-auto border border-ink-150 rounded-lg">
            <table class="w-full border-collapse text-left text-xs">
                <thead>
                    <tr class="bg-ink-50 border-b border-ink-150 text-ink-700 font-bold uppercase tracking-wider">
                        <th class="p-3 text-[11px]">Name</th>
                        <th class="p-3 text-[11px]">Email</th>
                        <th class="p-3 text-[11px]">
                            <a href="<?= get_sub_sort_url($sort_order) ?>" class="flex items-center hover:text-accent-500 transition-all">
                                Join Date <?= get_sub_sort_icon($sort_order) ?>
                            </a>
                        </th>
                        <th class="p-3 text-[11px]">Status</th>
                        <th class="p-3 text-right pr-4 text-[11px]">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-150">
                    <?php if (empty($subscribers)): ?>
                        <tr>
                            <td colspan="5" class="p-8 text-center text-ink-505">No subscribers found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($subscribers as $sub): ?>
                            <tr class="hover:bg-accent-50/50 transition-all">
                                <td class="p-3 font-semibold text-ink-900"><?= htmlspecialchars($sub['name']) ?></td>
                                <td class="p-3 text-ink-700"><?= htmlspecialchars($sub['email']) ?></td>
                                <td class="p-3">
                                    <div class="font-medium text-ink-900" style="font-variant-numeric: tabular-nums;"><?= date('d M Y, H:i', strtotime($sub['created_at'])) ?></div>
                                    <div class="text-[10px] text-ink-500 mt-0.5">
                                        <?php 
                                            $join_time = strtotime($sub['created_at']);
                                            $diff = time() - $join_time;
                                            if ($diff < 60) {
                                                echo 'Baru saja bergabung';
                                            } elseif ($diff < 3600) {
                                                echo round($diff / 60) . ' menit yang lalu';
                                            } elseif ($diff < 86400) {
                                                echo round($diff / 3600) . ' jam yang lalu';
                                            } elseif ($diff < 2592000) {
                                                echo round($diff / 86400) . ' hari yang lalu';
                                            } elseif ($diff < 31536000) {
                                                echo round($diff / 2592000) . ' bulan yang lalu';
                                            } else {
                                                $years = floor($diff / 31536000);
                                                $months = round(($diff % 31536000) / 2592000);
                                                echo $years . ' tahun' . ($months > 0 ? ', ' . $months . ' bulan' : '') . ' yang lalu';
                                            }
                                        ?>
                                    </div>
                                </td>
                                <td class="p-3">
                                    <?php if ($sub['status'] === 'active'): ?>
                                        <span class="inline-flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#2E7D5B]"></span>
                                            <span class="text-ink-900 font-medium">Active</span>
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#C4432E]"></span>
                                            <span class="text-ink-900 font-medium">Inactive</span>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-3 text-right pr-4">
                                    <?php if ($sub['status'] === 'active'): ?>
                                        <a href="<?= base_url('subscribers/toggle/' . $sub['id']) ?>" class="text-[#C4432E] hover:underline font-semibold text-xs inline-flex items-center justify-end gap-1" title="Unsubscribe">
                                            <i class="fa-solid fa-user-slash"></i> Unsubscribe
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('subscribers/toggle/' . $sub['id']) ?>" class="text-accent-500 hover:underline font-semibold text-xs inline-flex items-center justify-end gap-1" title="Resubscribe">
                                            <i class="fa-solid fa-user-check"></i> Resubscribe
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if (!empty($pagination_links)): ?>
            <div class="mt-4 flex items-center justify-between font-sans">
                <span class="text-xs text-ink-500 font-medium"><?= $showing_counter ?></span>
                <?= $pagination_links ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Right panel: CSV Import (1/3 width) -->
    <div class="bg-white border border-ink-150 rounded-lg p-5">
        <h2 class="text-sm font-bold font-jakarta text-ink-900 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-file-import text-ink-500"></i> Import CSV
        </h2>

        <?= form_open_multipart('subscribers/import', ['class' => 'space-y-4']) ?>
            <div>
                <label class="block text-xs font-bold text-ink-700 mb-1.5" for="csv_file">Choose CSV File</label>
                <div class="flex items-center justify-center w-full">
                    <label class="flex flex-col items-center justify-center w-full h-28 border border-ink-300 border-dashed rounded-lg cursor-pointer bg-ink-50 hover:bg-accent-50/30 transition-all">
                        <div class="flex flex-col items-center justify-center pt-4 pb-4">
                            <i class="fa-solid fa-cloud-arrow-up text-xl text-ink-500 mb-1"></i>
                            <p class="text-[11px] text-ink-700 font-semibold">Click to upload CSV</p>
                        </div>
                        <input type="file" name="csv_file" id="csv_file" class="hidden" required accept=".csv">
                    </label>
                </div>
                <div id="file-name" class="mt-2 text-[10px] text-ink-500 text-center font-medium"></div>
            </div>

            <button type="submit" class="w-full py-2 px-4 bg-accent-500 hover:bg-accent-600 text-white font-bold rounded-[6px] text-xs shadow-sm transition-all flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-cloud-arrow-up text-[10px]"></i> Upload and Import
            </button>
        </form>

        <div class="mt-5 border-t border-ink-150 pt-5 text-xs text-ink-500 space-y-2">
            <p class="font-bold text-ink-700">CSV Structure Guide:</p>
            <p>File must contain a header row. Column headers should be: <code>name</code> and <code>email</code>.</p>
            <pre class="bg-ink-50 p-2.5 rounded-lg font-mono text-[10px] overflow-x-auto text-ink-700 border border-ink-300">name,email
John Doe,johndoe@example.com
Jane Smith,janesmith@example.com</pre>
        </div>
    </div>
</div>

<script>
    document.getElementById('csv_file').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : '';
        document.getElementById('file-name').textContent = fileName ? 'Selected file: ' + fileName : '';
    });
</script>

<?php $this->load->view('admin/footer'); ?>
