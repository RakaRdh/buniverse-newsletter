<?php $this->load->view('admin/header', ['title' => $action === 'create' ? 'Create Investor.id Content' : 'Edit Investor.id Content']); ?>

<div class="max-w-4xl mx-auto bg-white border border-slate-200 rounded-xl p-8 shadow-sm">
    <div class="flex justify-between items-center mb-8 pb-4 border-b border-slate-100">
        <div>
            <h1 class="text-2xl font-bold text-[#20254D] flex items-center gap-2">
                <i class="fa-solid fa-file-pen text-sky-600"></i>
                <?= $action === 'create' ? 'Create Investor.id Content' : 'Edit Investor.id Content' ?>
            </h1>
            <p class="text-sm text-slate-500 mt-1">Configure layout, greeting briefing, stock tickers, and article lists</p>
        </div>
        <span class="px-3 py-1 bg-sky-50 text-sky-600 border border-sky-200 rounded-full text-xs font-bold uppercase tracking-wider">Investor.id Template</span>
    </div>

    <?= form_open('newsletters/save', ['class' => 'space-y-8']) ?>
        <input type="hidden" name="portal" value="investor">
        <?php if (isset($newsletter['id'])): ?>
            <input type="hidden" name="id" value="<?= $newsletter['id'] ?>">
        <?php endif; ?>

        <!-- Section 1: General & Greetings -->
        <div class="space-y-5">
            <h3 class="text-sm font-bold text-[#20254D] uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-100">
                <span class="w-1.5 h-4 bg-sky-500 rounded-sm"></span> 1. General & Greeting Settings
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5" for="volume">Volume / Edition</label>
                    <input type="number" name="volume" id="volume" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#20254D]/20 focus:border-[#20254D] transition-all" required value="<?= isset($newsletter['volume']) ? $newsletter['volume'] : '1' ?>">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5" for="subject">Email Subject</label>
                    <input type="text" name="subject" id="subject" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#20254D]/20 focus:border-[#20254D] transition-all" required placeholder="Investor briefing Vol 1" value="<?= isset($newsletter['subject']) ? htmlspecialchars($newsletter['subject']) : '' ?>">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5" for="greeting_title">Greeting Title</label>
                    <input type="text" name="greeting_title" id="greeting_title" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#20254D]/20 focus:border-[#20254D] transition-all" placeholder="Morning insight," value="<?= isset($newsletter['greeting_title']) ? htmlspecialchars($newsletter['greeting_title']) : 'Morning insight,' ?>">
                    <span class="text-xs text-slate-400 mt-1 block">Tip: Use <code>[Nama Subscriber]</code> to display the subscriber's name dynamically.</span>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5" for="greeting_body">Greeting Body Paragraph</label>
                    <textarea name="greeting_body" id="greeting_body" rows="3" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#20254D]/20 focus:border-[#20254D] transition-all" placeholder="Tulis kalimat pembuka briefing di sini..."><?= isset($newsletter['greeting_body']) ? htmlspecialchars($newsletter['greeting_body']) : '' ?></textarea>
                </div>
            </div>
        </div>

        <!-- Section 2: Market Tickers -->
        <div class="space-y-5 pt-4">
            <h3 class="text-sm font-bold text-[#20254D] uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-100">
                <span class="w-1.5 h-4 bg-sky-500 rounded-sm"></span> 2. Market Tickers Stats
            </h3>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <?php 
                    $stat_keys = ['IHSG', 'USD/IDR', 'EMAS', 'BTC'];
                    foreach ($stat_keys as $key):
                        $val = isset($stats_map[$key]['value']) ? $stats_map[$key]['value'] : '0.0%';
                        $dir = isset($stats_map[$key]['direction']) ? $stats_map[$key]['direction'] : 'up';
                ?>
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
                        <label class="block text-xs font-bold text-slate-650"><?= $key ?></label>
                        <input type="text" name="stats[<?= $key ?>][value]" class="w-full px-3 py-1.5 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none" placeholder="e.g. +0.5%" value="<?= htmlspecialchars($val) ?>">
                        <select name="stats[<?= $key ?>][direction]" class="w-full px-2 py-1 text-[11px] bg-white border border-slate-200 rounded text-slate-650">
                            <option value="up" <?= $dir === 'up' ? 'selected' : '' ?>>Naik (Green)</option>
                            <option value="down" <?= $dir === 'down' ? 'selected' : '' ?>>Turun (Red)</option>
                        </select>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if ($action === 'edit' && !empty($articles)): ?>
            <!-- Section 3: Main Featured Article -->
            <?php 
                $main_art = null;
                $list_arts = [];
                foreach ($articles as $art) {
                    if ($art['article_type'] === 'main') {
                        $main_art = $art;
                    } elseif ($art['article_type'] === 'list') {
                        $list_arts[] = $art;
                    }
                }
            ?>

            <?php if ($main_art): ?>
                <div class="space-y-5 pt-4">
                    <h3 class="text-sm font-bold text-[#20254D] uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-100">
                        <span class="w-1.5 h-4 bg-sky-500 rounded-sm"></span> 3. Featured Article (Main Content)
                    </h3>
                    <input type="hidden" name="articles[0][id]" value="<?= $main_art['id'] ?>">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-650 uppercase mb-1">Title</label>
                                <input type="text" name="articles[0][title]" class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:border-[#20254D]" required value="<?= htmlspecialchars($main_art['title']) ?>">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-650 uppercase mb-1">Category Label</label>
                                <input type="text" name="articles[0][category]" class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:border-[#20254D]" required value="<?= htmlspecialchars($main_art['category']) ?>">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-650 uppercase mb-1">Excerpt / Description</label>
                                <textarea name="articles[0][excerpt]" rows="3" class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:border-[#20254D]"><?= htmlspecialchars($main_art['excerpt']) ?></textarea>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-650 uppercase">Article Image</label>
                            <input type="hidden" name="articles[0][image_url]" id="img_url_0" value="<?= htmlspecialchars($main_art['image_url']) ?>">
                            <div class="flex items-center justify-center w-full">
                                <label class="flex flex-col items-center justify-center w-full h-32 border border-slate-200 border-dashed rounded-lg cursor-pointer bg-slate-50 hover:bg-slate-100 transition-all">
                                    <div class="flex flex-col items-center justify-center pt-2">
                                        <i class="fa-solid fa-image text-lg text-slate-400 mb-1"></i>
                                        <p class="text-[10px] text-slate-500 font-semibold">Click to upload new image</p>
                                    </div>
                                    <input type="file" onchange="uploadImage(this, 'img_url_0', 'preview_0', 'status_0')" class="hidden" accept="image/*">
                                </label>
                            </div>
                            <div class="text-[10px] text-amber-600 font-bold hidden" id="status_0">Uploading...</div>
                            <div class="h-20 border border-slate-200 rounded-lg overflow-hidden flex items-center justify-center bg-slate-50" id="preview_0">
                                <?php if (!empty($main_art['image_url'])): ?>
                                    <img src="<?= htmlspecialchars($main_art['image_url']) ?>" alt="Preview" class="h-full object-contain">
                                <?php else: ?>
                                    <span class="text-[10px] text-slate-400 font-medium">No image loaded</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Section 4: List Articles (1-4) -->
            <div class="space-y-6 pt-4">
                <h3 class="text-sm font-bold text-[#20254D] uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-100">
                    <span class="w-1.5 h-4 bg-sky-500 rounded-sm"></span> 4. List Articles (1-4)
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php foreach ($list_arts as $idx => $art): ?>
                        <?php $field_idx = $idx + 1; ?>
                        <div class="bg-slate-50/50 border border-slate-200 rounded-xl p-5 space-y-4">
                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider">List Item #<?= $field_idx ?></h4>
                            <input type="hidden" name="articles[<?= $field_idx ?>][id]" value="<?= $art['id'] ?>">
                            
                            <div>
                                <label class="block text-xs font-bold text-slate-650 mb-1">Title</label>
                                <input type="text" name="articles[<?= $field_idx ?>][title]" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:border-[#20254D]" required value="<?= htmlspecialchars($art['title']) ?>">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-650 mb-1">Category</label>
                                <input type="text" name="articles[<?= $field_idx ?>][category]" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none" required value="<?= htmlspecialchars($art['category']) ?>">
                                <input type="hidden" name="articles[<?= $field_idx ?>][image_url]" value="">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="flex gap-4 pt-6 border-t border-slate-100">
            <button type="submit" class="px-6 py-3 bg-[#20254D] hover:bg-[#161a38] text-white font-bold rounded-lg text-sm shadow-md transition-all">
                <i class="fa-solid fa-floppy-disk"></i> Save Content
            </button>
            <a href="<?= base_url('newsletters') ?>" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg text-sm transition-all">Cancel</a>
        </div>
    </form>
</div>

<script>
    function uploadImage(fileInput, hiddenInputId, previewId, statusId) {
        const file = fileInput.files[0];
        if (!file) return;

        const formData = new FormData();
        formData.append("image", file);

        const statusEl = document.getElementById(statusId);
        const previewEl = document.getElementById(previewId);
        const hiddenEl = document.getElementById(hiddenInputId);

        statusEl.classList.remove("hidden");
        statusEl.textContent = "Uploading to Supabase Storage...";
        previewEl.innerHTML = '<span class="text-[10px] text-slate-400">Uploading...</span>';

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
                statusEl.className = "text-[10px] text-green-600 font-bold mt-1";
            } else {
                previewEl.innerHTML = '<span class="text-[10px] text-red-500">Failed</span>';
                statusEl.textContent = "Upload failed: " + data.message;
                statusEl.className = "text-[10px] text-red-500 font-bold mt-1";
            }
        })
        .catch(err => {
            previewEl.innerHTML = '<span class="text-[10px] text-red-500">Error</span>';
            statusEl.textContent = "Request error occurred.";
            statusEl.className = "text-[10px] text-red-500 font-bold mt-1";
        });
    }
</script>

<?php $this->load->view('admin/footer'); ?>
