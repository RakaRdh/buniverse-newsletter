<?php $this->load->view('admin/header', ['title' => 'Preview Templates']); ?>

<div class="mb-8">
    <h1 class="text-2xl font-bold text-[#20254D]">Email Newsletter Templates</h1>
    <p class="text-sm text-slate-500 mt-1">Live design previews of the dynamic responsive email templates for each brand</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
    <!-- BeritaSatu -->
    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm flex flex-col justify-between">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <span class="px-2.5 py-0.5 bg-red-50 text-[#EC1C24] border border-red-200 rounded-full text-xs font-bold uppercase tracking-wider">BeritaSatu</span>
            </div>
            <h3 class="text-lg font-bold text-[#20254D] mb-2">Daily Digest</h3>
            <p class="text-xs text-slate-500 leading-relaxed mb-4">Includes 1 featured main article with a card layout, floating greeting box, and a 2x2 side-by-side grid of secondary news.</p>
            <div class="flex gap-2 mb-2">
                <span class="w-4 h-4 rounded-full bg-[#e30613]" title="Primary Accent Red"></span>
                <span class="w-4 h-4 rounded-full bg-[#1a1a1a]" title="Dark theme elements"></span>
                <span class="w-4 h-4 rounded-full bg-[#ffffff] border border-slate-200" title="Canvas Clean bg"></span>
            </div>
        </div>
        <div class="p-6 bg-slate-50 border-t border-slate-100">
            <a href="<?= base_url('newsletters/render_html/1') ?>" target="_blank" class="w-full inline-flex items-center justify-center gap-2 py-2 px-4 bg-[#20254D] hover:bg-[#161a38] text-white font-semibold rounded-lg text-sm shadow transition-all">
                <i class="fa-solid fa-eye"></i> View Live Demo
            </a>
        </div>
    </div>

    <!-- Investor.id -->
    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm flex flex-col justify-between">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <span class="px-2.5 py-0.5 bg-sky-50 text-sky-600 border border-sky-200 rounded-full text-xs font-bold uppercase tracking-wider">Investor.id</span>
            </div>
            <h3 class="text-lg font-bold text-[#20254D] mb-2">Morning Briefing</h3>
            <p class="text-xs text-slate-500 leading-relaxed mb-4">Includes live stock tickers stats (IHSG, USD/IDR, EMAS, BTC), market morning insight paragraph, and dashed-line list of market news.</p>
            <div class="flex gap-2 mb-2">
                <span class="w-4 h-4 rounded-full bg-[#1e6ca1]" title="Primary Accent Blue"></span>
                <span class="w-4 h-4 rounded-full bg-[#1a8a3c]" title="Stock Up Green"></span>
                <span class="w-4 h-4 rounded-full bg-[#d32f2f]" title="Stock Down Red"></span>
            </div>
        </div>
        <div class="p-6 bg-slate-50 border-t border-slate-100">
            <a href="<?= base_url('newsletters/render_html/2') ?>" target="_blank" class="w-full inline-flex items-center justify-center gap-2 py-2 px-4 bg-[#20254D] hover:bg-[#161a38] text-white font-semibold rounded-lg text-sm shadow transition-all">
                <i class="fa-solid fa-eye"></i> View Live Demo
            </a>
        </div>
    </div>

    <!-- Jakarta Globe -->
    <div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm flex flex-col justify-between">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <span class="px-2.5 py-0.5 bg-orange-50 text-orange-600 border border-orange-200 rounded-full text-xs font-bold uppercase tracking-wider">Jakarta Globe</span>
            </div>
            <h3 class="text-lg font-bold text-[#20254D] mb-2">Curated Digest</h3>
            <p class="text-xs text-slate-500 leading-relaxed mb-4">Features a dynamic overlay banner with reader greeting, a side-by-side main story + related links column, and alternating image/text lists.</p>
            <div class="flex gap-2 mb-2">
                <span class="w-4 h-4 rounded-full bg-[#ff7a00]" title="Primary Accent Orange"></span>
                <span class="w-4 h-4 rounded-full bg-[#4a4a4a]" title="Dark gray themes"></span>
                <span class="w-4 h-4 rounded-full bg-[#ffffff] border border-slate-200" title="Pure Canvas"></span>
            </div>
        </div>
        <div class="p-6 bg-slate-50 border-t border-slate-100">
            <a href="<?= base_url('newsletters/render_html/3') ?>" target="_blank" class="w-full inline-flex items-center justify-center gap-2 py-2 px-4 bg-[#20254D] hover:bg-[#161a38] text-white font-semibold rounded-lg text-sm shadow transition-all">
                <i class="fa-solid fa-eye"></i> View Live Demo
            </a>
        </div>
    </div>
</div>

<?php $this->load->view('admin/footer'); ?>
