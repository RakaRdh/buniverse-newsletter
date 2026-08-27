<?php $this->load->view('admin/header', ['title' => 'Confirm & Send Newsletter']); ?>

<div class="max-w-3xl mx-auto">
    <div class="bg-white border border-slate-200 rounded-2xl p-8 shadow-sm mb-8">
        <h1 class="text-2xl font-bold text-[#20254D] mb-2">Confirm & Send</h1>
        <p class="text-sm text-slate-500 mb-6">Review the newsletter details and select the target subscribers.</p>

        <!-- Newsletter Review Card -->
        <div class="bg-slate-50 border border-slate-200/60 rounded-xl p-5 mb-8">
            <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Newsletter Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-500">Portal</label>
                    <div class="mt-1">
                        <?php if ($newsletter['portal'] === 'beritasatu'): ?>
                            <span class="px-2.5 py-0.5 bg-red-50 text-[#EC1C24] border border-red-200 rounded-full text-xs font-bold uppercase tracking-wider">BeritaSatu</span>
                        <?php elseif ($newsletter['portal'] === 'investor'): ?>
                            <span class="px-2.5 py-0.5 bg-blue-50 text-blue-600 border border-blue-200 rounded-full text-xs font-bold uppercase tracking-wider">Investor.id</span>
                        <?php else: ?>
                            <span class="px-2.5 py-0.5 bg-orange-50 text-orange-600 border border-orange-200 rounded-full text-xs font-bold uppercase tracking-wider">Jakarta Globe</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500">Volume (Edition)</label>
                    <p class="mt-1 text-sm font-semibold text-slate-800">Vol <?= htmlspecialchars($newsletter['volume']) ?></p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-slate-500">Email Subject</label>
                    <p class="mt-1 text-sm font-semibold text-[#20254D]"><?= htmlspecialchars($newsletter['subject']) ?></p>
                </div>
            </div>
        </div>

        <!-- Form for Send -->
        <form action="<?= base_url('send/newsletter/' . $newsletter['id']) ?>" method="POST">
            <!-- Subscriber Selection Box -->
            <div class="border border-slate-200 rounded-xl overflow-hidden mb-6">
                <!-- Header with Action Buttons -->
                <div class="bg-slate-50 border-b border-slate-200 px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Select Target Recipients</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Choose which subscribers should receive this newsletter</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="selectAll(true)" class="px-3 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold rounded-lg text-xs transition-all">
                            Select All
                        </button>
                        <button type="button" onclick="selectAll(false)" class="px-3 py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold rounded-lg text-xs transition-all">
                            Deselect All
                        </button>
                    </div>
                </div>

                <!-- Checklist Container -->
                <div class="max-h-[300px] overflow-y-auto divide-y divide-slate-100 p-2">
                    <?php if (empty($subscribers)): ?>
                        <div class="p-8 text-center text-slate-400 text-sm">No active subscribers found in database.</div>
                    <?php else: ?>
                        <?php foreach ($subscribers as $sub): ?>
                            <label class="flex items-center px-4 py-3 hover:bg-slate-50/60 transition-all cursor-pointer rounded-lg">
                                <input type="checkbox" name="subscribers[]" value="<?= $sub['id'] ?>" class="sub-checkbox w-4 h-4 rounded border-slate-300 text-[#20254D] focus:ring-[#20254D]/20" checked>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-slate-800 leading-tight"><?= htmlspecialchars($sub['name']) ?></p>
                                    <p class="text-xs text-slate-400 mt-0.5"><?= htmlspecialchars($sub['email']) ?></p>
                                </div>
                                <div class="ml-auto">
                                    <?php if ($sub['status'] === 'active'): ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-200">Active</span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-[#EC1C24] border border-red-200">Inactive</span>
                                    <?php endif; ?>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center justify-between border-t border-slate-100 pt-6">
                <a href="<?= base_url('newsletters') ?>" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl text-sm transition-all">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#EC1C24] hover:bg-[#c9121a] text-white font-bold rounded-xl text-sm shadow-lg shadow-[#EC1C24]/10 transition-all active:scale-[0.98]">
                    <i class="fa-solid fa-paper-plane"></i> Send Newsletter Now
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function selectAll(checked) {
        const checkboxes = document.querySelectorAll('.sub-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = checked;
        });
    }
</script>

<?php $this->load->view('admin/footer'); ?>
