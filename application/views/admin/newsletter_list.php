<?php $this->load->view('admin/header', ['title' => $title]); ?>

<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-lg font-bold font-jakarta text-ink-900"><?= htmlspecialchars($title) ?></h1>
        <p class="text-xs text-ink-500 mt-0.5">Create, edit, and send brand newsletters</p>
    </div>
    <a href="<?= base_url('newsletters/create' . ($portal ? '/' . $portal : '')) ?>" class="inline-flex items-center gap-2 px-3 py-2 bg-accent-500 hover:bg-accent-600 text-white font-semibold rounded-[6px] text-xs transition-all shadow-sm">
        <i class="fa-solid fa-plus text-[10px]"></i> Create Newsletter
    </a>
</div>

<div class="bg-white border border-ink-150 rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-left text-xs">
            <thead>
                <tr class="bg-ink-50 border-b border-ink-150 text-ink-700 font-bold uppercase tracking-wider">
                    <th class="p-3 pl-4 text-[11px]">Newsletter Details</th>
                    <th class="p-3 text-[11px]">Portal</th>
                    <th class="p-3 text-[11px]">Status</th>
                    <th class="p-3 text-right pr-4 text-[11px]">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-ink-150">
                <?php if (empty($newsletters)): ?>
                    <tr>
                        <td colspan="4" class="p-12 text-center text-ink-500">
                            <i class="fa-regular fa-folder-open text-3xl mb-3 block text-ink-300"></i>
                            <h3 class="font-bold text-ink-900 text-sm">No newsletters found</h3>
                            <p class="text-xs text-ink-500 mt-1">Click the button in the top right to create your first newsletter draft.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($newsletters as $nl): ?>
                        <tr class="hover:bg-accent-50/50 transition-all">
                            <td class="p-3 pl-4">
                                <div class="max-w-md">
                                    <h4 class="font-semibold text-xs text-ink-900 mb-0.5 line-clamp-1">
                                        <?= htmlspecialchars($nl['subject']) ?>
                                    </h4>
                                    <div class="flex items-center gap-2 text-[10px] text-ink-500 font-medium">
                                        <span>Vol <?= htmlspecialchars($nl['volume']) ?></span>
                                        <span>&bull;</span>
                                        <span style="font-variant-numeric: tabular-nums;">Created: <?= date('d M Y', strtotime($nl['created_at'])) ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-3">
                                <?php if ($nl['portal'] === 'beritasatu'): ?>
                                    <span class="px-2 py-0.5 bg-[#FBE6E2] text-[#C4432E] rounded text-[10px] font-bold uppercase tracking-wider">
                                        BeritaSatu
                                    </span>
                                <?php elseif ($nl['portal'] === 'investor'): ?>
                                    <span class="px-2 py-0.5 bg-[#E7EFF7] text-[#3A6FA8] rounded text-[10px] font-bold uppercase tracking-wider">
                                        Investor.id
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 py-0.5 bg-[#FBEFDD] text-[#B8791A] rounded text-[10px] font-bold uppercase tracking-wider">
                                        JakartaGlobe
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="p-3">
                                <?php if ($nl['status'] === 'draft'): ?>
                                    <span class="inline-flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-ink-500"></span>
                                        <span class="text-ink-900 font-medium">Draft</span>
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#2E7D5B]"></span>
                                        <span class="text-ink-900 font-medium">Sent</span>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="p-3 text-right pr-4">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="<?= base_url('newsletters/detail/' . $nl['id']) ?>" class="inline-flex items-center justify-center gap-1 py-1.5 px-2.5 bg-ink-50 hover:bg-ink-150 text-ink-900 border border-ink-300 rounded-[6px] text-xs transition-all" target="_blank" title="Detail">
                                        <i class="fa-solid fa-circle-info text-ink-500"></i> Detail
                                    </a>
                                    
                                    <?php if ($nl['status'] === 'draft'): ?>
                                        <a href="<?= base_url('newsletters/edit/' . $nl['id']) ?>" class="inline-flex items-center justify-center gap-1 py-1.5 px-2.5 bg-white hover:bg-ink-50 text-ink-900 border border-ink-300 rounded-[6px] text-xs transition-all" title="Edit">
                                            <i class="fa-solid fa-pen-to-square text-ink-500"></i> Edit
                                        </a>
                                        <a href="<?= base_url('send/newsletter/' . $nl['id']) ?>" class="inline-flex items-center justify-center gap-1 py-1.5 px-2.5 bg-accent-500 hover:bg-accent-600 text-white rounded-[6px] text-xs transition-all shadow-sm" title="Send">
                                            <i class="fa-solid fa-paper-plane text-[9px]"></i> Send
                                        </a>
                                    <?php else: ?>
                                        <div class="inline-flex items-center gap-1.5">
                                            <span class="inline-flex items-center py-1 px-2 bg-ink-50 text-ink-500 border border-ink-150 border-dashed rounded-[6px] text-[10px] font-medium whitespace-nowrap" style="font-variant-numeric: tabular-nums;">
                                                Sent <?= date('d M Y', strtotime($nl['sent_at'])) ?>
                                            </span>
                                            <a href="<?= base_url('newsletters/reset_status/' . $nl['id']) ?>" class="inline-flex items-center justify-center gap-1 p-1.5 bg-ink-50 hover:bg-ink-150 text-ink-700 border border-ink-300 rounded-[6px] text-xs transition-all" onclick="return confirm('Apakah Anda yakin ingin mereset status newsletter ini kembali ke draft?')" title="Reset to Draft">
                                                <i class="fa-solid fa-arrow-rotate-left"></i>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <a href="<?= base_url('newsletters/delete/' . $nl['id']) ?>" class="p-1.5 text-[#C4432E] hover:bg-[#FBE6E2] border border-ink-300 hover:border-transparent rounded-[6px] transition-all" onclick="return confirm('Apakah Anda yakin ingin menghapus newsletter ini?')" title="Delete">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </a>
                                </div>
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

<?php $this->load->view('admin/footer'); ?>
