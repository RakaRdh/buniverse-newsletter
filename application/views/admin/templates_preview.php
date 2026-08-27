<?php $this->load->view('admin/header', ['title' => 'Email Templates']); ?>

<div class="flex justify-between items-center mb-6 font-sans">
    <div>
        <h1 class="text-lg font-bold font-jakarta text-ink-900">Email Newsletter Templates</h1>
        <p class="text-xs text-ink-500 mt-0.5">Pre-configured design layouts for each portal category</p>
    </div>
</div>

<div class="bg-white border border-ink-150 rounded-lg overflow-hidden font-sans">
    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-left text-xs">
            <thead>
                <tr class="bg-ink-50 border-b border-ink-150 text-ink-700 font-bold uppercase tracking-wider">
                    <th class="p-3 pl-4 text-[11px]">Template Name</th>
                    <th class="p-3 text-[11px]">Portal Category</th>
                    <th class="p-3 text-[11px]">Description</th>
                    <th class="p-3 text-right pr-4 text-[11px]">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-ink-150">
                <tr class="hover:bg-accent-50/50 transition-all">
                    <td class="p-3 pl-4">
                        <div class="font-bold text-xs text-ink-900">Daily Digest</div>
                    </td>
                    <td class="p-3">
                        <span class="px-2 py-0.5 bg-[#FBE6E2] text-[#C4432E] rounded text-[10px] font-bold uppercase tracking-wider">BeritaSatu</span>
                    </td>
                    <td class="p-3 text-ink-700 max-w-sm leading-relaxed">
                        1 featured main article, floating greeting box, and a 2x2 grid of secondary news.
                    </td>
                    <td class="p-3 text-right pr-4">
                        <a href="<?= base_url('newsletters/detail/1') ?>" class="inline-flex items-center justify-center gap-1.5 py-1.5 px-3 bg-white hover:bg-ink-50 text-ink-900 border border-ink-300 rounded-[6px] text-xs font-semibold transition-all shadow-sm" target="_blank">
                            <i class="fa-solid fa-eye text-ink-500 text-[11px]"></i> Preview
                        </a>
                    </td>
                </tr>
                <tr class="hover:bg-accent-50/50 transition-all">
                    <td class="p-3 pl-4">
                        <div class="font-bold text-xs text-ink-900">Morning Briefing</div>
                    </td>
                    <td class="p-3">
                        <span class="px-2 py-0.5 bg-[#E7EFF7] text-[#3A6FA8] rounded text-[10px] font-bold uppercase tracking-wider">Investor.id</span>
                    </td>
                    <td class="p-3 text-ink-700 max-w-sm leading-relaxed">
                        Stock market tickers stats, market morning insight paragraph, and list of news.
                    </td>
                    <td class="p-3 text-right pr-4">
                        <a href="<?= base_url('newsletters/detail/2') ?>" class="inline-flex items-center justify-center gap-1.5 py-1.5 px-3 bg-white hover:bg-ink-50 text-ink-900 border border-ink-300 rounded-[6px] text-xs font-semibold transition-all shadow-sm" target="_blank">
                            <i class="fa-solid fa-eye text-ink-500 text-[11px]"></i> Preview
                        </a>
                    </td>
                </tr>
                <tr class="hover:bg-accent-50/50 transition-all">
                    <td class="p-3 pl-4">
                        <div class="font-bold text-xs text-ink-900">Curated Digest</div>
                    </td>
                    <td class="p-3">
                        <span class="px-2 py-0.5 bg-[#FBEFDD] text-[#B8791A] rounded text-[10px] font-bold uppercase tracking-wider">JakartaGlobe</span>
                    </td>
                    <td class="p-3 text-ink-700 max-w-sm leading-relaxed">
                        Overlay banner, sidebar related links column, and alternating feed topics.
                    </td>
                    <td class="p-3 text-right pr-4">
                        <a href="<?= base_url('newsletters/detail/3') ?>" class="inline-flex items-center justify-center gap-1.5 py-1.5 px-3 bg-white hover:bg-ink-50 text-ink-900 border border-ink-300 rounded-[6px] text-xs font-semibold transition-all shadow-sm" target="_blank">
                            <i class="fa-solid fa-eye text-ink-500 text-[11px]"></i> Preview
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php $this->load->view('admin/footer'); ?>
