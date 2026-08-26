<?php $this->load->view('admin/header', ['title' => 'Add Content']); ?>

<div class="max-w-4xl mx-auto bg-white border border-slate-200 rounded-xl p-8 shadow-sm">
    <div class="flex justify-between items-center mb-8 pb-4 border-b border-slate-100">
        <div>
            <h1 class="text-2xl font-bold text-[#20254D] flex items-center gap-2">
                <i class="fa-solid fa-file-circle-plus text-[#EC1C24]"></i>
                Add New Content Entry
            </h1>
            <p class="text-sm text-slate-500 mt-1">Create a new newsletter edition and fill all layout content at once</p>
        </div>
    </div>

    <?= form_open('newsletters/save', ['class' => 'space-y-8']) ?>
        <!-- Portal Selector Dropdown -->
        <div>
            <label class="block text-sm font-bold text-[#20254D] mb-1.5" for="portal_selector">Select Brand Portal / Template</label>
            <select name="portal" id="portal_selector" class="w-full px-4 py-2.5 text-sm bg-slate-50 border-2 border-[#20254D]/20 rounded-lg text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#20254D]/20 focus:border-[#20254D] font-semibold transition-all">
                <option value="beritasatu">BeritaSatu (Daily Digest Layout)</option>
                <option value="investor">Investor.id (Morning Briefing Layout)</option>
                <option value="jakartaglobe">Jakarta Globe (Curated Digest Layout)</option>
            </select>
        </div>

        <!-- Section 1: General & Greetings -->
        <div class="space-y-5">
            <h3 class="text-sm font-bold text-[#20254D] uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-100">
                <span class="w-1.5 h-4 bg-[#20254D] rounded-sm"></span> 1. General & Greeting Settings
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5" for="volume">Volume / Edition</label>
                    <input type="number" name="volume" id="volume" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#20254D]/20 focus:border-[#20254D] transition-all" required value="1">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5" for="subject">Email Subject</label>
                    <input type="text" name="subject" id="subject" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#20254D]/20 focus:border-[#20254D] transition-all" required placeholder="Daily digest - Edisi 01">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5" for="greeting_title">Greeting Title</label>
                    <input type="text" name="greeting_title" id="greeting_title" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#20254D]/20 focus:border-[#20254D] transition-all" value="Sahabat Beritasatu,">
                    <span class="text-xs text-slate-400 mt-1 block">Tip: Use <code>[Nama Subscriber]</code> to display the subscriber's name dynamically.</span>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5" for="greeting_body">Greeting Body Paragraph</label>
                    <textarea name="greeting_body" id="greeting_body" rows="3" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#20254D]/20 focus:border-[#20254D] transition-all" placeholder="Tulis kalimat pembuka di sini..."></textarea>
                </div>
            </div>
        </div>

        <!-- Section 2: Brand Layouts (Toggled via JS) -->
        
        <!-- A. BeritaSatu Fields -->
        <div id="section-beritasatu" class="brand-section space-y-6">
            <h3 class="text-sm font-bold text-[#20254D] uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-100">
                <span class="w-1.5 h-4 bg-[#EC1C24] rounded-sm"></span> 2. BeritaSatu Content (1 Featured + 4 Grid Articles)
            </h3>

            <!-- Featured -->
            <div class="bg-red-50/10 border border-red-150 rounded-xl p-5 space-y-4">
                <h4 class="text-xs font-bold text-[#EC1C24] uppercase tracking-wider">Featured Main Article</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-650 mb-1">Title</label>
                            <input type="text" name="articles[0][title]" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none" required placeholder="Main headline title">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-655 mb-1">Excerpt / Description</label>
                            <textarea name="articles[0][excerpt]" rows="3" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none" placeholder="Headline summary paragraph"></textarea>
                        </div>
                        <input type="hidden" name="articles[0][category]" value="1 Fokus Topik">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-655">Image File</label>
                        <input type="hidden" name="articles[0][image_url]" id="bs_img_0">
                        <label class="block w-full py-3 text-center text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 border border-dashed border-slate-300 rounded-lg cursor-pointer transition-all">
                            Select Image File
                            <input type="file" onchange="uploadImage(this, 'bs_img_0', 'bs_preview_0', 'bs_status_0')" class="hidden" accept="image/*">
                        </label>
                        <div class="text-[9px] text-amber-600 font-bold hidden" id="bs_status_0">Uploading...</div>
                        <div class="h-20 border border-slate-200 rounded-lg overflow-hidden flex items-center justify-center bg-white" id="bs_preview_0">
                            <span class="text-[9px] text-slate-400">No image loaded</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grids -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-3">
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Grid Article #<?= $i ?></h4>
                        <div>
                            <label class="block text-xs font-bold text-slate-650 mb-1">Title</label>
                            <input type="text" name="articles[<?= $i ?>][title]" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none" required placeholder="Grid title #<?= $i ?>">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-650 mb-1">Category</label>
                                <input type="text" name="articles[<?= $i ?>][category]" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none" required value="Nasional">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-650 mb-1">Image</label>
                                <input type="hidden" name="articles[<?= $i ?>][image_url]" id="bs_img_<?= $i ?>">
                                <label class="block w-full py-2 text-center text-[10px] font-bold bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg cursor-pointer transition-all">
                                    Upload
                                    <input type="file" onchange="uploadImage(this, 'bs_img_<?= $i ?>', 'bs_preview_<?= $i ?>', 'bs_status_<?= $i ?>')" class="hidden" accept="image/*">
                                </label>
                                <div class="text-[8px] text-amber-600 font-bold hidden" id="bs_status_<?= $i ?>">Uploading...</div>
                            </div>
                        </div>
                        <div class="h-16 border border-slate-200 rounded-lg overflow-hidden flex items-center justify-center bg-white" id="bs_preview_<?= $i ?>">
                            <span class="text-[9px] text-slate-400">No image loaded</span>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- B. Investor.id Fields -->
        <div id="section-investor" class="brand-section space-y-6 hidden">
            <h3 class="text-sm font-bold text-[#20254D] uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-100">
                <span class="w-1.5 h-4 bg-sky-500 rounded-sm"></span> 2. Investor.id Tickers & Content (1 Featured + 4 List Articles)
            </h3>

            <!-- Stock Tickers -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 bg-slate-50 border border-slate-200 rounded-xl p-4">
                <?php foreach (['IHSG', 'USD/IDR', 'EMAS', 'BTC'] as $key): ?>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-[#20254D]"><?= $key ?></label>
                        <input type="text" name="stats[<?= $key ?>][value]" class="w-full px-3 py-1.5 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none" placeholder="e.g. +0.5%" value="0.0%">
                        <select name="stats[<?= $key ?>][direction]" class="w-full px-2 py-1 text-[10px] bg-white border border-slate-200 rounded text-slate-650">
                            <option value="up">Naik (Green)</option>
                            <option value="down">Turun (Red)</option>
                        </select>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Featured -->
            <div class="bg-sky-50/10 border border-sky-150 rounded-xl p-5 space-y-4">
                <h4 class="text-xs font-bold text-sky-600 uppercase tracking-wider">Featured Main Article</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-650 mb-1">Title</label>
                            <input type="text" name="articles[0][title]" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none" required placeholder="Featured title">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-655 mb-1">Excerpt / Description</label>
                            <textarea name="articles[0][excerpt]" rows="3" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none" placeholder="Featured summary"></textarea>
                        </div>
                        <input type="hidden" name="articles[0][category]" value="Analisis Pasar">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-655">Image File</label>
                        <input type="hidden" name="articles[0][image_url]" id="inv_img_0">
                        <label class="block w-full py-3 text-center text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 border border-dashed border-slate-300 rounded-lg cursor-pointer transition-all">
                            Select Image File
                            <input type="file" onchange="uploadImage(this, 'inv_img_0', 'inv_preview_0', 'inv_status_0')" class="hidden" accept="image/*">
                        </label>
                        <div class="text-[9px] text-amber-600 font-bold hidden" id="inv_status_0">Uploading...</div>
                        <div class="h-20 border border-slate-200 rounded-lg overflow-hidden flex items-center justify-center bg-white" id="inv_preview_0">
                            <span class="text-[9px] text-slate-400">No image loaded</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lists -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-3">
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider">List Article #<?= $i ?></h4>
                        <div>
                            <label class="block text-xs font-bold text-slate-650 mb-1">Title</label>
                            <input type="text" name="articles[<?= $i ?>][title]" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none" required placeholder="List news title #<?= $i ?>">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-650 mb-1">Category</label>
                                <input type="text" name="articles[<?= $i ?>][category]" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none" required value="Market Update">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-650 mb-1">Image</label>
                                <input type="hidden" name="articles[<?= $i ?>][image_url]" id="inv_img_<?= $i ?>">
                                <label class="block w-full py-2 text-center text-[10px] font-bold bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg cursor-pointer transition-all">
                                    Upload
                                    <input type="file" onchange="uploadImage(this, 'inv_img_<?= $i ?>', 'inv_preview_<?= $i ?>', 'inv_status_<?= $i ?>')" class="hidden" accept="image/*">
                                </label>
                                <div class="text-[8px] text-amber-600 font-bold hidden" id="inv_status_<?= $i ?>">Uploading...</div>
                            </div>
                        </div>
                        <div class="h-16 border border-slate-200 rounded-lg overflow-hidden flex items-center justify-center bg-white" id="inv_preview_<?= $i ?>">
                            <span class="text-[9px] text-slate-400">No image loaded</span>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- C. Jakarta Globe Fields -->
        <div id="section-jakartaglobe" class="brand-section space-y-6 hidden">
            <h3 class="text-sm font-bold text-[#20254D] uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-100">
                <span class="w-1.5 h-4 bg-orange-500 rounded-sm"></span> 2. Jakarta Globe Content (1 Featured + 3 Sidebar + 4 Alternating Topics)
            </h3>

            <!-- Featured -->
            <div class="bg-orange-50/10 border border-orange-150 rounded-xl p-5 space-y-4">
                <h4 class="text-xs font-bold text-orange-600 uppercase tracking-wider">Featured Main Topic</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-650 mb-1">Title</label>
                            <input type="text" name="articles[0][title]" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none" required placeholder="Main topic title">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-655 mb-1">Excerpt / Description</label>
                            <textarea name="articles[0][excerpt]" rows="3" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none" placeholder="Summary paragraph"></textarea>
                        </div>
                        <input type="hidden" name="articles[0][category]" value="National">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-655">Image File</label>
                        <input type="hidden" name="articles[0][image_url]" id="jg_img_0">
                        <label class="block w-full py-3 text-center text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 border border-dashed border-slate-300 rounded-lg cursor-pointer transition-all">
                            Select Image File
                            <input type="file" onchange="uploadImage(this, 'jg_img_0', 'jg_preview_0', 'jg_status_0')" class="hidden" accept="image/*">
                        </label>
                        <div class="text-[9px] text-amber-600 font-bold hidden" id="jg_status_0">Uploading...</div>
                        <div class="h-20 border border-slate-200 rounded-lg overflow-hidden flex items-center justify-center bg-white" id="jg_preview_0">
                            <span class="text-[9px] text-slate-400">No image loaded</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebars (1-3) -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider pb-1 border-b border-slate-100">Sidebar Topic Links</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php for ($i = 1; $i <= 3; $i++): ?>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-3">
                            <h5 class="text-[10px] font-bold text-slate-400 uppercase">Sidebar Link #<?= $i ?></h5>
                            <div>
                                <label class="block text-xs font-bold text-slate-650 mb-1">Title</label>
                                <input type="text" name="articles[<?= $i ?>][title]" class="w-full px-2.5 py-1.5 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none" required placeholder="Sidebar title #<?= $i ?>">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-bold text-slate-650 mb-1">Category</label>
                                    <input type="text" name="articles[<?= $i ?>][category]" class="w-full px-2.5 py-1.5 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none" required value="Finance">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-650 mb-1">Image</label>
                                    <input type="hidden" name="articles[<?= $i ?>][image_url]" id="jg_img_<?= $i ?>">
                                    <label class="block w-full py-1.5 text-center text-[9px] font-bold bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg cursor-pointer transition-all">
                                        Upload
                                        <input type="file" onchange="uploadImage(this, 'jg_img_<?= $i ?>', 'jg_preview_<?= $i ?>', 'jg_status_<?= $i ?>')" class="hidden" accept="image/*">
                                    </label>
                                </div>
                            </div>
                            <div class="h-12 border border-slate-200 rounded-lg overflow-hidden flex items-center justify-center bg-white" id="jg_preview_<?= $i ?>">
                                <span class="text-[9px] text-slate-400">No image</span>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Alternatings (4-7) -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider pb-1 border-b border-slate-100">Alternating Feed Topics</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php for ($i = 4; $i <= 7; $i++): ?>
                        <?php $item_idx = $i - 3; ?>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-3">
                            <h5 class="text-[10px] font-bold text-slate-400 uppercase">Feed Topic #<?= $item_idx ?></h5>
                            <div>
                                <label class="block text-xs font-bold text-slate-650 mb-1">Title</label>
                                <input type="text" name="articles[<?= $i ?>][title]" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none" required placeholder="Feed topic title #<?= $item_idx ?>">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-655 mb-1">Excerpt / Summary</label>
                                <textarea name="articles[<?= $i ?>][excerpt]" rows="2" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none" required placeholder="Feed summary paragraph"></textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-655 mb-1">Category</label>
                                    <input type="text" name="articles[<?= $i ?>][category]" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none" required value="World">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-655 mb-1">Image</label>
                                    <input type="hidden" name="articles[<?= $i ?>][image_url]" id="jg_img_<?= $i ?>">
                                    <label class="block w-full py-2 text-center text-[10px] font-bold bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg cursor-pointer transition-all">
                                        Upload
                                        <input type="file" onchange="uploadImage(this, 'jg_img_<?= $i ?>', 'jg_preview_<?= $i ?>', 'jg_status_<?= $i ?>')" class="hidden" accept="image/*">
                                    </label>
                                </div>
                            </div>
                            <div class="h-16 border border-slate-200 rounded-lg overflow-hidden flex items-center justify-center bg-white" id="jg_preview_<?= $i ?>">
                                <span class="text-[9px] text-slate-400">No image loaded</span>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

        <div class="flex gap-4 pt-6 border-t border-slate-100">
            <button type="submit" class="px-6 py-3 bg-[#20254D] hover:bg-[#161a38] text-white font-bold rounded-lg text-sm shadow-md transition-all">
                <i class="fa-solid fa-floppy-disk"></i> Save Content
            </button>
            <a href="<?= base_url('newsletters') ?>" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg text-sm transition-all">Cancel</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const portalSelector = document.getElementById("portal_selector");
        const greetingTitle = document.getElementById("greeting_title");

        const greetingsMap = {
            'beritasatu': 'Sahabat Beritasatu,',
            'investor': 'Morning insight,',
            'jakartaglobe': 'Dear Reader,'
        };

        function switchPortal() {
            const selectedPortal = portalSelector.value;

            // Update greeting title default if empty or matches old default
            const oldVal = greetingTitle.value;
            if (oldVal === 'Sahabat Beritasatu,' || oldVal === 'Morning insight,' || oldVal === 'Dear Reader,' || !oldVal) {
                greetingTitle.value = greetingsMap[selectedPortal];
            }

            // Hide all brand sections
            document.querySelectorAll(".brand-section").forEach(sec => {
                sec.classList.add("hidden");
                // Disable all inputs inside hidden sections so they don't submit empty values
                sec.querySelectorAll("input, textarea, select").forEach(input => {
                    input.disabled = true;
                });
            });

            // Show active brand section
            const activeSec = document.getElementById("section-" + selectedPortal);
            if (activeSec) {
                activeSec.classList.remove("hidden");
                // Enable inputs inside active section
                activeSec.querySelectorAll("input, textarea, select").forEach(input => {
                    input.disabled = false;
                });
            }
        }

        portalSelector.addEventListener("change", switchPortal);
        switchPortal(); // Run on load
    });

    function uploadImage(fileInput, hiddenInputId, previewId, statusId) {
        const file = fileInput.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append("image", file);

        const statusEl = document.getElementById(statusId);
        const previewEl = document.getElementById(previewId);
        const hiddenEl = document.getElementById(hiddenInputId);

        statusEl.classList.remove("hidden");
        statusEl.textContent = "Uploading...";
        previewEl.innerHTML = '<span class="text-[9px] text-slate-400">Processing...</span>';

        fetch("<?= base_url('media/upload_image') ?>", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                hiddenEl.value = data.url;
                previewEl.innerHTML = `<img src="${data.url}" alt="Preview" class="h-full object-contain">`;
                statusEl.textContent = "Upload successful!";
                statusEl.className = "text-[9px] text-green-600 font-bold mt-1";
            } else {
                previewEl.innerHTML = '<span class="text-[9px] text-red-500">Failed</span>';
                statusEl.textContent = "Upload failed: " + data.message;
                statusEl.className = "text-[9px] text-red-500 font-bold mt-1";
            }
        })
        .catch(err => {
            previewEl.innerHTML = '<span class="text-[9px] text-red-500">Error</span>';
            statusEl.textContent = "Request error occurred.";
            statusEl.className = "text-[9px] text-red-500 font-bold mt-1";
        });
    }
</script>

<?php $this->load->view('admin/footer'); ?>
