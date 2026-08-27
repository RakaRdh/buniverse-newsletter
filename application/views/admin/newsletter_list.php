<?php $this->load->view('admin/header', ['title' => $title]); ?>

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-[#20254D]"><?= htmlspecialchars($title) ?></h1>
        <p class="text-sm text-slate-500 mt-1">Create, edit, and send brand newsletters</p>
    </div>
    <a href="<?= base_url('newsletters/create' . ($portal ? '/' . $portal : '')) ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-[#EC1C24] hover:bg-[#c9121a] text-white font-semibold rounded-lg text-sm shadow-md transition-all">
        <i class="fa-solid fa-plus"></i> Create Newsletter
    </a>
</div>

<div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-left text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-[#20254D] font-bold">
                    <th class="p-4 pl-6">Newsletter Details</th>
                    <th class="p-4">Portal</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right pr-6">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($newsletters)): ?>
                    <tr>
                        <td colspan="4" class="p-12 text-center text-slate-400">
                            <i class="fa-regular fa-folder-open text-4xl mb-4 block"></i>
                            <h3 class="font-semibold text-slate-800 text-base">No newsletters found</h3>
                            <p class="text-xs text-slate-500 mt-1">Click the button in the top right to create your first newsletter draft.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($newsletters as $nl): ?>
                        <tr class="hover:bg-slate-50/50 transition-all">
                            <td class="p-4 pl-6">
                                <div class="max-w-md">
                                    <h4 class="font-bold text-sm text-[#20254D] mb-1 line-clamp-1">
                                        <?= htmlspecialchars($nl['subject']) ?>
                                    </h4>
                                    <div class="flex items-center gap-3 text-xs text-slate-400 font-medium">
                                        <span>Vol <?= htmlspecialchars($nl['volume']) ?></span>
                                        <span>&bull;</span>
                                        <span>Created: <?= date('d M Y', strtotime($nl['created_at'])) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <?php if ($nl['portal'] === 'beritasatu'): ?>
                                    <span class="px-2.5 py-0.5 bg-red-50 text-[#EC1C24] border border-red-200 rounded-full text-xs font-bold uppercase tracking-wider">
                                        BeritaSatu
                                    </span>
                                <?php elseif ($nl['portal'] === 'investor'): ?>
                                    <span class="px-2.5 py-0.5 bg-sky-50 text-sky-600 border border-sky-200 rounded-full text-xs font-bold uppercase tracking-wider">
                                        Investor.id
                                    </span>
                                <?php else: ?>
                                    <span class="px-2.5 py-0.5 bg-orange-50 text-orange-600 border border-orange-200 rounded-full text-xs font-bold uppercase tracking-wider">
                                        Jakarta Globe
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4">
                                <?php if ($nl['status'] === 'draft'): ?>
                                    <span class="px-2.5 py-0.5 bg-slate-100 text-slate-600 rounded-full text-xs font-semibold uppercase">
                                        Draft
                                    </span>
                                <?php else: ?>
                                    <span class="px-2.5 py-0.5 bg-green-50 text-green-700 border border-green-200 rounded-full text-xs font-semibold uppercase">
                                        Sent
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 text-right pr-6">
                                <div class="inline-flex items-center gap-2">
                                    <a href="<?= base_url('newsletters/detail/' . $nl['id']) ?>" class="inline-flex items-center justify-center gap-1.5 py-2 px-3 bg-slate-100 hover:bg-slate-200 text-[#20254D] font-bold rounded-lg text-xs transition-all" target="_blank" title="Detail">
                                        <i class="fa-solid fa-circle-info"></i> Detail
                                    </a>
                                    
                                    <?php if ($nl['status'] === 'draft'): ?>
                                        <a href="<?= base_url('newsletters/edit/' . $nl['id']) ?>" class="inline-flex items-center justify-center gap-1.5 py-2 px-3 bg-[#20254D]/10 hover:bg-[#20254D] hover:text-white text-[#20254D] font-bold rounded-lg text-xs transition-all" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                        <a href="<?= base_url('send/newsletter/' . $nl['id']) ?>" class="inline-flex items-center justify-center gap-1.5 py-2 px-3 bg-[#EC1C24]/10 hover:bg-[#EC1C24] hover:text-white text-[#EC1C24] font-bold rounded-lg text-xs transition-all" title="Send">
                                            <i class="fa-solid fa-paper-plane"></i> Send
                                        </a>
                                    <?php else: ?>
                                        <div class="inline-flex items-center gap-2">
                                            <span class="inline-flex items-center py-1.5 px-2 bg-slate-50 text-slate-400 border border-slate-200 border-dashed rounded-lg text-[10px] font-medium whitespace-nowrap">
                                                Sent <?= date('d M Y', strtotime($nl['sent_at'])) ?>
                                            </span>
                                            <a href="<?= base_url('newsletters/reset_status/' . $nl['id']) ?>" class="inline-flex items-center justify-center gap-1 py-2 px-2 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 font-bold rounded-lg text-xs transition-all" onclick="return confirm('Apakah Anda yakin ingin mereset status newsletter ini kembali ke draft?')" title="Reset to Draft">
                                                <i class="fa-solid fa-arrow-rotate-left"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <a href="<?= base_url('newsletters/delete/' . $nl['id']) ?>" class="p-2 bg-red-50 hover:bg-[#EC1C24] text-[#EC1C24] hover:text-white rounded-lg transition-all" onclick="return confirm('Apakah Anda yakin ingin menghapus newsletter ini?')" title="Delete">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->load->view('admin/footer'); ?>
