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
        return '<i class="fa-solid fa-sort text-slate-300 ml-1.5 text-[10px]"></i>';
    }
    return $current_order === 'asc' 
        ? '<i class="fa-solid fa-sort-up text-[#EC1C24] ml-1.5 text-[11px] -mb-1"></i>' 
        : '<i class="fa-solid fa-sort-down text-[#EC1C24] ml-1.5 text-[11px] -mt-1"></i>';
}
?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Left panel: list of subscribers (2/3 width) -->
    <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
        <h2 class="text-xl font-bold text-[#20254D] mb-6 flex items-center gap-2">
            <i class="fa-solid fa-list-ul"></i> Subscribers Database
        </h2>

        <!-- Search Form -->
        <form action="<?= base_url('subscribers') ?>" method="GET" class="flex gap-2 mb-6">
            <input type="text" name="search" class="flex-1 px-4 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#20254D]/20 focus:border-[#20254D] transition-all" placeholder="Search by name or email..." value="<?= htmlspecialchars($search) ?>">
            <?php if ($sort_order !== 'normal'): ?>
                <input type="hidden" name="sort_order" value="<?= htmlspecialchars($sort_order) ?>">
            <?php endif; ?>
            <button type="submit" class="px-4 py-2 bg-[#20254D] hover:bg-[#161a38] text-white font-semibold rounded-lg text-sm shadow-md transition-all">
                <i class="fa-solid fa-magnifying-glass"></i> Search
            </button>
            <?php if (!empty($search) || $sort_order !== 'normal'): ?>
                <a href="<?= base_url('subscribers') ?>" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-705 font-semibold rounded-lg text-sm transition-all flex items-center">Clear</a>
            <?php endif; ?>
        </form>

        <div class="overflow-x-auto border border-slate-200 rounded-lg">
            <table class="w-full border-collapse text-left text-sm">
                <thead>
                    <tr class="bg-slate-100/80 border-b border-slate-200 text-[#20254D] font-bold">
                        <th class="p-4">Name</th>
                        <th class="p-4">Email</th>
                        <th class="p-4">
                            <a href="<?= get_sub_sort_url($sort_order) ?>" class="flex items-center hover:text-[#EC1C24] transition-all">
                                Join Date <?= get_sub_sort_icon($sort_order) ?>
                            </a>
                        </th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($subscribers)): ?>
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400">No subscribers found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($subscribers as $sub): ?>
                            <tr class="hover:bg-slate-50 transition-all">
                                <td class="p-4 font-semibold text-slate-800"><?= htmlspecialchars($sub['name']) ?></td>
                                <td class="p-4 text-slate-600"><?= htmlspecialchars($sub['email']) ?></td>
                                <td class="p-4">
                                    <div class="font-medium text-slate-800"><?= date('d M Y, H:i', strtotime($sub['created_at'])) ?></div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">
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
                                <td class="p-4">
                                    <?php if ($sub['status'] === 'active'): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-200">Active</span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-50 text-[#EC1C24] border border-red-200">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4 text-right">
                                    <?php if ($sub['status'] === 'active'): ?>
                                        <a href="<?= base_url('subscribers/toggle/' . $sub['id']) ?>" class="text-[#EC1C24] hover:underline font-semibold text-xs flex items-center justify-end gap-1.5" title="Unsubscribe">
                                            <i class="fa-solid fa-user-slash"></i> Unsubscribe
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('subscribers/toggle/' . $sub['id']) ?>" class="text-[#20254D] hover:underline font-semibold text-xs flex items-center justify-end gap-1.5" title="Resubscribe">
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
    </div>

    <!-- Right panel: CSV Import (1/3 width) -->
    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
        <h2 class="text-xl font-bold text-[#20254D] mb-6 flex items-center gap-2">
            <i class="fa-solid fa-file-import"></i> Import CSV
        </h2>

        <?= form_open_multipart('subscribers/import', ['class' => 'space-y-4']) ?>
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1.5" for="csv_file">Choose CSV File</label>
                <div class="flex items-center justify-center w-full">
                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-200 border-dashed rounded-lg cursor-pointer bg-slate-50 hover:bg-slate-100 transition-all">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i class="fa-solid fa-cloud-arrow-up text-2xl text-slate-400 mb-2"></i>
                            <p class="text-xs text-slate-500 font-semibold">Click to upload CSV</p>
                        </div>
                        <input type="file" name="csv_file" id="csv_file" class="hidden" required accept=".csv">
                    </label>
                </div>
                <div id="file-name" class="mt-2 text-xs text-slate-500 text-center font-medium"></div>
            </div>

            <button type="submit" class="w-full py-2.5 px-4 bg-[#20254D] hover:bg-[#161a38] text-white font-semibold rounded-lg text-sm shadow-md transition-all flex items-center justify-center gap-2">
                <i class="fa-solid fa-cloud-arrow-up"></i> Upload and Import
            </button>
        </form>

        <div class="mt-6 border-t border-slate-100 pt-6 text-xs text-slate-500 space-y-2">
            <p class="font-bold text-slate-700">CSV Structure Guide:</p>
            <p>File must contain a header row. Column headers should be: <code>name</code> and <code>email</code>.</p>
            <pre class="bg-slate-50 p-3 rounded-lg font-mono text-[10px] overflow-x-auto text-slate-700 border border-slate-200">name,email
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
