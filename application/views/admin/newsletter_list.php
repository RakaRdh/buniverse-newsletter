<?php $this->load->view('admin/header', ['title' => 'Manage Newsletters']); ?>

<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-2xl font-bold text-[#20254D]">Newsletters</h1>
        <p class="text-sm text-slate-500 mt-1">Create, edit, and send brand newsletters</p>
    </div>
    <a href="<?= base_url('newsletters/create') ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-[#EC1C24] hover:bg-[#c9121a] text-white font-semibold rounded-lg text-sm shadow-md transition-all">
        <i class="fa-solid fa-plus"></i> Create Newsletter
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php if (empty($newsletters)): ?>
        <div class="col-span-full bg-white border border-slate-200 rounded-xl p-12 text-center">
            <i class="fa-regular fa-folder-open text-4xl text-slate-400 mb-4 block"></i>
            <h3 class="font-semibold text-slate-800 text-lg">No newsletters found</h3>
            <p class="text-sm text-slate-500 mt-1">Click the button in the top right to create your first newsletter draft.</p>
        </div>
    <?php else: ?>
        <?php foreach ($newsletters as $nl): ?>
            <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-all flex flex-col justify-between min-h-[220px]">
                <div>
                    <div class="flex justify-between items-center mb-4">
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

                        <?php if ($nl['status'] === 'draft'): ?>
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-xs font-semibold uppercase">
                                Draft
                            </span>
                        <?php else: ?>
                            <span class="px-2 py-0.5 bg-green-50 text-green-700 border border-green-200 rounded text-xs font-semibold uppercase">
                                Sent
                            </span>
                        <?php endif; ?>
                    </div>

                    <h3 class="text-lg font-bold text-[#20254D] line-clamp-2 mb-2"><?= htmlspecialchars($nl['subject']) ?></h3>
                    
                    <div class="flex items-center gap-2 text-xs text-slate-500 mb-4 font-medium">
                        <i class="fa-regular fa-calendar"></i>
                        <span>Vol <?= htmlspecialchars($nl['volume']) ?></span> &bull; 
                        <span>Created: <?= date('d M Y', strtotime($nl['created_at'])) ?></span>
                    </div>
                </div>

                <div class="flex gap-2 border-t border-slate-100 pt-4 mt-auto">
                    <a href="<?= base_url('newsletters/preview/' . $nl['id']) ?>" class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-3 bg-slate-100 hover:bg-slate-200 text-[#20254D] font-bold rounded-lg text-xs transition-all" target="_blank">
                        <i class="fa-solid fa-eye"></i> Preview
                    </a>
                    
                    <?php if ($nl['status'] === 'draft'): ?>
                        <a href="<?= base_url('newsletters/edit/' . $nl['id']) ?>" class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-3 bg-[#20254D]/10 hover:bg-[#20254D] hover:text-white text-[#20254D] font-bold rounded-lg text-xs transition-all">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                        <a href="<?= base_url('send/newsletter/' . $nl['id']) ?>" class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-3 bg-[#EC1C24]/10 hover:bg-[#EC1C24] hover:text-white text-[#EC1C24] font-bold rounded-lg text-xs transition-all" onclick="return confirm('Apakah Anda yakin ingin mengirim newsletter ini?')">
                            <i class="fa-solid fa-paper-plane"></i> Send
                        </a>
                    <?php else: ?>
                        <div class="flex-1 flex flex-col gap-1">
                            <span class="inline-flex items-center justify-center py-1.5 px-2 bg-slate-50 text-slate-400 border border-slate-200 border-dashed rounded-lg text-[10px] font-medium leading-none">
                                Sent <?= date('d M Y', strtotime($nl['sent_at'])) ?>
                            </span>
                            <a href="<?= base_url('newsletters/reset_status/' . $nl['id']) ?>" class="inline-flex items-center justify-center gap-1 py-1.5 px-2 bg-yellow-50 hover:bg-yellow-100 text-yellow-700 font-bold rounded-lg text-[10px] transition-all" onclick="return confirm('Apakah Anda yakin ingin mereset status newsletter ini kembali ke draft?')">
                                <i class="fa-solid fa-arrow-rotate-left"></i> Reset Status
                            </a>
                        </div>
                    <?php endif; ?>

                    <a href="<?= base_url('newsletters/delete/' . $nl['id']) ?>" class="p-2 bg-red-50 hover:bg-[#EC1C24] text-[#EC1C24] hover:text-white rounded-lg transition-all" onclick="return confirm('Apakah Anda yakin ingin menghapus newsletter ini?')" title="Delete">
                        <i class="fa-solid fa-trash-can text-sm"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php $this->load->view('admin/footer'); ?>
