<?php $this->load->view('admin/header', ['title' => $action === 'create' ? 'Create BeritaSatu Content' : 'Edit BeritaSatu Content']); ?>

<div class="max-w-4xl mx-auto bg-white border border-slate-200 rounded-xl p-8 shadow-sm">
    <div class="flex justify-between items-center mb-8 pb-4 border-b border-slate-100">
        <div>
            <h1 class="text-2xl font-bold text-[#20254D] flex items-center gap-2">
                <i class="fa-solid fa-file-pen text-[#EC1C24]"></i>
                <?= $action === 'create' ? 'Create BeritaSatu Content' : 'Edit BeritaSatu Content' ?>
            </h1>
            <p class="text-sm text-slate-500 mt-1">Configure layout, greeting cards, and article content copy</p>
        </div>
        <span class="px-3 py-1 bg-red-50 text-[#EC1C24] border border-red-200 rounded-full text-xs font-bold uppercase tracking-wider">BeritaSatu Template</span>
    </div>

    <?= form_open('newsletters/save', ['class' => 'space-y-8']) ?>
        <input type="hidden" name="portal" value="beritasatu">
        <?php if (isset($newsletter['id'])): ?>
            <input type="hidden" name="id" value="<?= $newsletter['id'] ?>">
        <?php endif; ?>

        <!-- Section 1: Basic & Greeting Settings -->
        <div class="space-y-5">
            <h3 class="text-sm font-bold text-[#20254D] uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-100">
                <span class="w-1.5 h-4 bg-[#EC1C24] rounded-sm"></span> 1. General & Greeting Settings
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5" for="volume">Volume / Edition</label>
                    <input type="number" name="volume" id="volume" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#20254D]/20 focus:border-[#20254D] transition-all" required value="<?= isset($newsletter['volume']) ? $newsletter['volume'] : '1' ?>">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5" for="subject">Email Subject</label>
                    <input type="text" name="subject" id="subject" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#20254D]/20 focus:border-[#20254D] transition-all" required placeholder="Daily digest - Edisi 01" value="<?= isset($newsletter['subject']) ? htmlspecialchars($newsletter['subject']) : '' ?>">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5" for="greeting_title">Greeting Title</label>
                    <input type="text" name="greeting_title" id="greeting_title" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#20254D]/20 focus:border-[#20254D] transition-all" placeholder="Sahabat Beritasatu," value="<?= isset($newsletter['greeting_title']) ? htmlspecialchars($newsletter['greeting_title']) : 'Sahabat Beritasatu,' ?>">
                    <span class="text-xs text-slate-400 mt-1 block">Tip: Use <code>[Nama Subscriber]</code> to display the subscriber's name dynamically.</span>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5" for="greeting_body">Greeting Body Paragraph</label>
                    <textarea name="greeting_body" id="greeting_body" rows="3" class="w-full px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#20254D]/20 focus:border-[#20254D] transition-all" placeholder="Greeting body..."><?= isset($newsletter['greeting_body']) ? htmlspecialchars($newsletter['greeting_body']) : '' ?></textarea>
                </div>
            </div>
        </div>

        <?php if ($action === 'edit' && !empty($articles)): ?>
            <!-- Section 2: Main Featured Article -->
            <?php 
                $main_art = null;
                $grid_arts = [];
                foreach ($articles as $art) {
                    if ($art['article_type'] === 'main') {
                        $main_art = $art;
                    } elseif ($art['article_type'] === 'grid') {
                        $grid_arts[] = $art;
                    }
                }
            ?>

            <?php if ($main_art): ?>
                <div class="space-y-5 pt-4">
                    <h3 class="text-sm font-bold text-[#20254D] uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-100">
                        <span class="w-1.5 h-4 bg-[#EC1C24] rounded-sm"></span> 2. Featured Article (Main Content)
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
                                <label class="block text-xs font-bold text-slate-650 uppercase mb-1">Article URL / Link</label>
                                <input type="url" name="articles[0][url]" class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:border-[#20254D]" placeholder="https://example.com/article" value="<?= htmlspecialchars(isset($main_art['url']) ? $main_art['url'] : '') ?>">
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

            <!-- Section 3: Grid Articles (1-4) -->
            <div class="space-y-6 pt-4">
                <h3 class="text-sm font-bold text-[#20254D] uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-slate-100">
                    <span class="w-1.5 h-4 bg-[#EC1C24] rounded-sm"></span> 3. Secondary Grid Articles (1-4)
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php foreach ($grid_arts as $idx => $art): ?>
                        <?php $field_idx = $idx + 1; ?>
                        <div class="bg-slate-50/50 border border-slate-200 rounded-xl p-5 space-y-4">
                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Grid Item #<?= $field_idx ?></h4>
                            <input type="hidden" name="articles[<?= $field_idx ?>][id]" value="<?= $art['id'] ?>">
                            
                            <div>
                                <label class="block text-xs font-bold text-slate-650 mb-1">Title</label>
                                <input type="text" name="articles[<?= $field_idx ?>][title]" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:border-[#20254D]" required value="<?= htmlspecialchars($art['title']) ?>">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-650 mb-1">Category</label>
                                    <input type="text" name="articles[<?= $field_idx ?>][category]" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none" required value="<?= htmlspecialchars($art['category']) ?>">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-650 mb-1">Image URL</label>
                                    <input type="hidden" name="articles[<?= $field_idx ?>][image_url]" id="img_url_<?= $field_idx ?>" value="<?= htmlspecialchars($art['image_url']) ?>">
                                    <label class="block w-full py-2 px-3 text-center text-[10px] font-semibold bg-slate-200 hover:bg-slate-350 text-slate-700 rounded-lg cursor-pointer transition-all">
                                        Upload Image
                                        <input type="file" onchange="uploadImage(this, 'img_url_<?= $field_idx ?>', 'preview_<?= $field_idx ?>', 'status_<?= $field_idx ?>')" class="hidden" accept="image/*">
                                    </label>
                                    <div class="text-[9px] text-amber-600 font-bold hidden" id="status_<?= $field_idx ?>">Uploading...</div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-650 mb-1">Article URL / Link</label>
                                <input type="url" name="articles[<?= $field_idx ?>][url]" class="w-full px-3 py-2 text-xs bg-white border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:border-[#20254D]" placeholder="https://example.com/article" value="<?= htmlspecialchars(isset($art['url']) ? $art['url'] : '') ?>">
                            </div>

                            <div class="h-20 border border-slate-200 rounded-lg overflow-hidden flex items-center justify-center bg-white" id="preview_<?= $field_idx ?>">
                                <?php if (!empty($art['image_url'])): ?>
                                    <img src="<?= htmlspecialchars($art['image_url']) ?>" alt="Preview" class="h-full object-contain">
                                <?php else: ?>
                                    <span class="text-[10px] text-slate-400 font-medium">No image loaded</span>
                                <?php endif; ?>
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
