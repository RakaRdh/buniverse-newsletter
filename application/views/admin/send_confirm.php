<?php $this->load->view('admin/header', ['title' => 'Confirm & Send Newsletter']); ?>

<div class="max-w-3xl mx-auto bg-white border border-ink-150 rounded-lg p-6 shadow-sm font-sans">
    <div class="flex justify-between items-center mb-6 pb-4 border-b border-ink-150">
        <div>
            <h1 class="text-base font-bold font-jakarta text-ink-900 flex items-center gap-2 uppercase tracking-wider">
                <i class="fa-solid fa-paper-plane text-accent-500"></i>
                Confirm & Send Newsletter
            </h1>
            <p class="text-xs text-ink-500 mt-1">Review the newsletter details and select the target subscribers.</p>
        </div>
    </div>

    <!-- Newsletter Review Card -->
    <div class="bg-ink-50 border border-ink-150 rounded-lg p-5 mb-6 space-y-4">
        <h3 class="text-xs font-bold text-ink-900 uppercase tracking-wider pb-2 border-b border-ink-150">Newsletter Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-[11px] font-bold text-ink-500 uppercase">Portal</label>
                <div class="mt-1.5">
                    <?php if ($newsletter['portal'] === 'beritasatu'): ?>
                        <span class="px-2.5 py-0.5 bg-[#FBE6E2] text-[#C4432E] border border-transparent rounded-[6px] text-[10px] font-bold uppercase tracking-wider">BeritaSatu</span>
                    <?php elseif ($newsletter['portal'] === 'investor'): ?>
                        <span class="px-2.5 py-0.5 bg-[#E7EFF7] text-[#3A6FA8] border border-transparent rounded-[6px] text-[10px] font-bold uppercase tracking-wider">Investor.id</span>
                    <?php else: ?>
                        <span class="px-2.5 py-0.5 bg-[#FBEFDD] text-[#B8791A] border border-transparent rounded-[6px] text-[10px] font-bold uppercase tracking-wider">JakartaGlobe</span>
                    <?php endif; ?>
                </div>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-ink-500 uppercase">Volume (Edition)</label>
                <p class="mt-1.5 text-xs font-bold text-ink-900 font-jakarta">Vol <?= htmlspecialchars($newsletter['volume']) ?></p>
            </div>
            <div class="md:col-span-2">
                <label class="block text-[11px] font-bold text-ink-500 uppercase">Email Subject</label>
                <p class="mt-1.5 text-xs font-bold text-ink-900 font-jakarta"><?= htmlspecialchars($newsletter['subject']) ?></p>
            </div>
        </div>
    </div>

    <!-- Form for Send -->
    <form action="<?= base_url('send/newsletter/' . $newsletter['id']) ?>" method="POST" class="space-y-6">
        <!-- Subscriber Selection Box -->
        <div class="border border-ink-150 rounded-lg overflow-hidden">
            <!-- Header with Action Buttons -->
            <div class="bg-ink-50 border-b border-ink-150 px-4 py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <h4 class="font-bold text-ink-900 text-xs font-jakarta uppercase tracking-wider">Select Target Recipients</h4>
                    <p class="text-[11px] text-ink-500 mt-0.5">Choose which subscribers should receive this newsletter</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="selectAll(true)" class="px-2.5 py-1.5 bg-white border border-ink-300 hover:bg-ink-50 text-ink-700 font-bold rounded-[6px] text-[10px] transition-all shadow-sm">
                        Select All
                    </button>
                    <button type="button" onclick="selectAll(false)" class="px-2.5 py-1.5 bg-white border border-ink-300 hover:bg-ink-50 text-ink-700 font-bold rounded-[6px] text-[10px] transition-all shadow-sm">
                        Deselect All
                    </button>
                </div>
            </div>

            <!-- Checklist Container -->
            <div class="max-h-[300px] overflow-y-auto divide-y divide-ink-150 p-1">
                <?php if (empty($subscribers)): ?>
                    <div class="p-8 text-center text-ink-500 text-xs font-medium">No active subscribers found in database.</div>
                <?php else: ?>
                    <?php foreach ($subscribers as $sub): ?>
                        <label class="flex items-center px-4 py-3 hover:bg-accent-50/30 transition-all cursor-pointer rounded-md">
                            <input type="checkbox" name="subscribers[]" value="<?= $sub['id'] ?>" class="sub-checkbox w-4 h-4 rounded border-ink-300 text-accent-600 focus:ring-accent-500/20" checked>
                            <div class="ml-3">
                                <p class="text-xs font-bold text-ink-900 leading-tight"><?= htmlspecialchars($sub['name']) ?></p>
                                <p class="text-[11px] text-ink-500 mt-0.5"><?= htmlspecialchars($sub['email']) ?></p>
                            </div>
                            <div class="ml-auto">
                                <?php if ($sub['status'] === 'active'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Active</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-rose-50 text-rose-700 border border-rose-200">Inactive</span>
                                <?php endif; ?>
                            </div>
                        </label>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Action buttons -->
        <div class="flex items-center justify-between pt-4 border-t border-ink-150">
            <a href="<?= base_url('newsletters') ?>" class="px-4 py-2 bg-white hover:bg-ink-50 text-ink-900 border border-ink-300 rounded-[6px] text-xs font-bold transition-all">
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-accent-500 hover:bg-accent-600 text-white font-bold rounded-[6px] text-xs shadow-sm transition-all active:scale-[0.98]">
                <i class="fa-solid fa-paper-plane"></i> Send Newsletter Now
            </button>
        </div>
    </form>
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
