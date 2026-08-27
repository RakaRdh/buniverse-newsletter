<?php $this->load->view('admin/header', ['title' => 'Edit JakartaGlobe Content']); ?>

<div class="max-w-4xl mx-auto bg-white border border-ink-150 rounded-lg p-6 shadow-sm font-sans">
    <div class="flex justify-between items-center mb-6 pb-4 border-b border-ink-150">
        <div>
            <h1 class="text-base font-bold font-jakarta text-ink-900 flex items-center gap-2 uppercase tracking-wider">
                <i class="fa-solid fa-file-pen text-accent-500"></i>
                Edit JakartaGlobe Content
            </h1>
            <p class="text-xs text-ink-500 mt-1">Configure layout, greeting briefing, sidebar links, and alternating topics</p>
        </div>
        <span class="px-2.5 py-0.5 bg-orange-50 text-orange-600 border border-orange-200 rounded-full text-[10px] font-bold uppercase tracking-wider font-sans">JakartaGlobe Template</span>
    </div>

    <?= form_open('newsletters/save', ['class' => 'space-y-6', 'onsubmit' => "handleFormSubmit(event, '" . base_url('media/upload_image') . "')"]) ?>
        <input type="hidden" name="portal" value="jakartaglobe">
        <?php if (isset($newsletter['id'])): ?>
            <input type="hidden" name="id" value="<?= $newsletter['id'] ?>">
        <?php endif; ?>

        <!-- Section 1: General & Greetings -->
        <div class="space-y-4">
            <h3 class="text-xs font-bold text-ink-900 uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-ink-150">
                <span class="w-1.5 h-3 bg-orange-500 rounded-sm" style="background-color: #ff7a00;"></span> 1. General & Greeting Settings
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-ink-700 mb-1.5" for="volume">Volume / Edition</label>
                    <input type="number" name="volume" id="volume" class="w-full h-9 px-3 py-1.5 text-xs bg-ink-50 border border-ink-300 rounded-[6px] text-ink-900 focus:bg-white focus:outline-none focus:border-accent-500 transition-all" required value="<?= isset($newsletter['volume']) ? $newsletter['volume'] : '1' ?>">
                </div>
                <div>
                    <label class="block text-xs font-bold text-ink-700 mb-1.5" for="subject">Email Subject</label>
                    <input type="text" name="subject" id="subject" class="w-full h-9 px-3 py-1.5 text-xs bg-ink-50 border border-ink-300 rounded-[6px] text-ink-900 focus:bg-white focus:outline-none focus:border-accent-500 transition-all" required placeholder="JakartaGlobe Digest Vol 1" value="<?= isset($newsletter['subject']) ? htmlspecialchars($newsletter['subject']) : '' ?>">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-xs font-bold text-ink-700 mb-1.5" for="greeting_title">Greeting Title</label>
                    <input type="text" name="greeting_title" id="greeting_title" class="w-full h-9 px-3 py-1.5 text-xs bg-ink-50 border border-ink-300 rounded-[6px] text-ink-900 focus:bg-white focus:outline-none focus:border-accent-500 transition-all" placeholder="Dear Reader," value="<?= isset($newsletter['greeting_title']) ? htmlspecialchars($newsletter['greeting_title']) : 'Dear Reader,' ?>">
                    <span class="text-[10px] text-ink-500 mt-1 block">Tip: Use <code class="cursor-pointer bg-ink-150 px-1 py-0.5 rounded hover:bg-ink-300 transition-all" onclick="insertTag('[Nama Subscriber]', 'greeting_title')">[Nama Subscriber]</code> to display the subscriber's name dynamically.</span>
                </div>
            </div>
        </div>

        <?php if ($action === 'edit' && !empty($articles)): ?>
            <!-- Section 2: Main Featured Topic -->
            <?php 
                $main_art = null;
                $sidebar_arts = [];
                $alt_arts = [];
                foreach ($articles as $art) {
                    if ($art['article_type'] === 'main') {
                        $main_art = $art;
                    } elseif ($art['article_type'] === 'sidebar') {
                        $sidebar_arts[] = $art;
                    } elseif ($art['article_type'] === 'alternating') {
                        $alt_arts[] = $art;
                    }
                }
            ?>

            <?php if ($main_art): ?>
                <div class="space-y-4">
                    <h3 class="text-xs font-bold text-ink-900 uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-ink-150">
                        <span class="w-1.5 h-3 bg-orange-500 rounded-sm" style="background-color: #ff7a00;"></span> 2. Featured Topic (Main Content)
                    </h3>
                    <input type="hidden" name="articles[0][id]" value="<?= $main_art['id'] ?>">
                    
                    <div class="bg-ink-50 border border-ink-150 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-bold text-ink-750 mb-1">TITLE</label>
                                    <input type="text" name="articles[0][title]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required value="<?= htmlspecialchars($main_art['title']) ?>">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-ink-750 mb-1">CATEGORY LABEL</label>
                                    <input type="text" name="articles[0][category]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required value="<?= htmlspecialchars($main_art['category']) ?>">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-ink-750 mb-1">ARTICLE URL / LINK</label>
                                    <input type="url" name="articles[0][url]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" placeholder="https://example.com/article" value="<?= htmlspecialchars(isset($main_art['url']) ? $main_art['url'] : '') ?>">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-ink-750 mb-1">EXCERPT / DESCRIPTION</label>
                                    <textarea name="articles[0][excerpt]" rows="7" class="w-full px-3 py-2 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500"><?= htmlspecialchars($main_art['excerpt']) ?></textarea>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-ink-750">ARTICLE IMAGE</label>
                                <input type="hidden" name="articles[0][image_url]" id="img_url_0" value="<?= htmlspecialchars($main_art['image_url']) ?>">
                                <div class="flex items-center justify-center w-full">
                                    <label class="flex flex-col items-center justify-center w-full h-28 border border-ink-300 border-dashed rounded-[6px] cursor-pointer bg-white hover:bg-ink-50 transition-all">
                                        <div class="flex flex-col items-center justify-center pt-2">
                                            <i class="fa-solid fa-image text-sm text-ink-500 mb-1"></i>
                                            <p class="text-[10px] text-ink-500 font-semibold">Click to upload new image</p>
                                        </div>
                                        <input type="file" onchange="handleImageSelect(this, 'img_url_0', 'preview_0', 'status_0')" class="hidden" accept="image/*">
                                    </label>
                                </div>
                                <div class="text-[9px] text-amber-600 font-bold hidden" id="status_0">Uploading...</div>
                                <div class="h-36 border border-ink-150 rounded-[6px] overflow-hidden flex items-center justify-center bg-white" id="preview_0">
                                    <?php if (!empty($main_art['image_url'])): ?>
                                        <img src="<?= htmlspecialchars($main_art['image_url']) ?>" alt="Preview" class="h-full object-contain">
                                    <?php else: ?>
                                        <span class="text-[10px] text-ink-500 font-medium">No image loaded</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Section 3: Sidebar Topics (1-5) -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-ink-900 uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-ink-150">
                    <span class="w-1.5 h-3 bg-orange-500 rounded-sm" style="background-color: #ff7a00;"></span> 3. Sidebar Topics (1-5)
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php 
                    for ($i = 1; $i <= 5; $i++): 
                        $art = isset($sidebar_arts[$i - 1]) ? $sidebar_arts[$i - 1] : ['id' => '', 'title' => '', 'category' => 'Finance', 'image_url' => '', 'url' => ''];
                        $field_idx = $i;
                    ?>
                        <div class="bg-ink-50 border border-ink-150 rounded-lg p-3.5 space-y-3">
                            <h4 class="text-xs font-bold text-ink-700 uppercase tracking-wider">Sidebar Item #<?= $field_idx ?></h4>
                            <?php if (!empty($art['id'])): ?>
                                <input type="hidden" name="articles[<?= $field_idx ?>][id]" value="<?= $art['id'] ?>">
                            <?php endif; ?>
                            
                            <div>
                                <label class="block text-[10px] font-bold text-ink-700 mb-1">Title</label>
                                <input type="text" name="articles[<?= $field_idx ?>][title]" class="w-full px-2 py-1 text-[11px] bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required value="<?= htmlspecialchars($art['title']) ?>">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-ink-700 mb-1">Article Link</label>
                                <input type="url" name="articles[<?= $field_idx ?>][url]" class="w-full px-2 py-1 text-[11px] bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" placeholder="https://example.com/article" value="<?= htmlspecialchars(isset($art['url']) ? $art['url'] : '') ?>">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-ink-700 mb-1">Category</label>
                                <input type="text" name="articles[<?= $field_idx ?>][category]" class="w-full px-2 py-1 text-[11px] bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none" required value="<?= htmlspecialchars($art['category']) ?>">
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Section 4: Alternating Grid Topics (6-9) -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-ink-900 uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-ink-150">
                    <span class="w-1.5 h-3 bg-orange-500 rounded-sm" style="background-color: #ff7a00;"></span> 4. Alternating Grid Topics (1-4)
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php 
                    for ($idx = 0; $idx < 4; $idx++): 
                        $art = isset($alt_arts[$idx]) ? $alt_arts[$idx] : ['id' => '', 'title' => '', 'category' => 'World', 'excerpt' => '', 'image_url' => ''];
                        $field_idx = $idx + 6;
                    ?>
                        <div class="bg-ink-50 border border-ink-150 rounded-lg p-4 space-y-3">
                            <h4 class="text-xs font-bold text-ink-700 uppercase tracking-wider">Alternating Item #<?= $idx + 1 ?></h4>
                            <?php if (!empty($art['id'])): ?>
                                <input type="hidden" name="articles[<?= $field_idx ?>][id]" value="<?= $art['id'] ?>">
                            <?php endif; ?>
                            
                            <div>
                                <label class="block text-xs font-bold text-ink-700 mb-1">Title</label>
                                <input type="text" name="articles[<?= $field_idx ?>][title]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required value="<?= htmlspecialchars($art['title']) ?>">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-ink-700 mb-1">Excerpt / Description</label>
                                <textarea name="articles[<?= $field_idx ?>][excerpt]" rows="7" class="w-full px-3 py-2 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required><?= htmlspecialchars($art['excerpt']) ?></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-ink-700 mb-1">Category</label>
                                    <input type="text" name="articles[<?= $field_idx ?>][category]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none" required value="<?= htmlspecialchars($art['category']) ?>">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-ink-700 mb-1 font-sans">Image</label>
                                    <input type="hidden" name="articles[<?= $field_idx ?>][image_url]" id="img_url_<?= $field_idx ?>" value="<?= htmlspecialchars($art['image_url']) ?>">
                                    <label class="block w-full py-1.5 text-center text-[10px] font-bold bg-white hover:bg-ink-50 text-ink-900 border border-ink-300 rounded-[6px] cursor-pointer transition-all">
                                        Upload
                                        <input type="file" onchange="handleImageSelect(this, 'img_url_<?= $field_idx ?>', 'preview_<?= $field_idx ?>', 'status_<?= $field_idx ?>')" class="hidden" accept="image/*">
                                    </label>
                                    <div class="text-[9px] text-amber-600 font-bold hidden" id="status_<?= $field_idx ?>">Uploading...</div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-ink-700 mb-1">Article URL / Link</label>
                                <input type="url" name="articles[<?= $field_idx ?>][url]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" placeholder="https://example.com/article" value="<?= htmlspecialchars(isset($art['url']) ? $art['url'] : '') ?>">
                            </div>

                            <div class="h-28 border border-ink-150 rounded-[6px] overflow-hidden flex items-center justify-center bg-white" id="preview_<?= $field_idx ?>">
                                <?php if (!empty($art['image_url'])): ?>
                                    <img src="<?= htmlspecialchars($art['image_url']) ?>" alt="Preview" class="h-full object-contain">
                                <?php else: ?>
                                    <span class="text-[9px] text-ink-500 font-medium">No image loaded</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="flex gap-3 pt-4 border-t border-ink-150">
            <button type="submit" class="px-4 py-2 bg-accent-500 hover:bg-accent-600 text-white font-bold rounded-[6px] text-xs shadow-sm transition-all">
                <i class="fa-solid fa-floppy-disk"></i> Save Content
            </button>
            <a href="<?= base_url('newsletters?portal=jakartaglobe') ?>" class="px-4 py-2 bg-white hover:bg-ink-50 text-ink-900 border border-ink-300 rounded-[6px] text-xs font-bold transition-all">Cancel</a>
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

        if (statusEl) {
            statusEl.classList.remove("hidden");
            statusEl.textContent = "Uploading...";
        }
        previewEl.innerHTML = '<span class="text-[9px] text-ink-500">Processing...</span>';

        fetch("<?= base_url('media/upload_image') ?>", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                hiddenEl.value = data.url;
                previewEl.innerHTML = `<img src="${data.url}" alt="Preview" class="h-full object-contain">`;
                if (statusEl) {
                    statusEl.textContent = "Upload successful!";
                    statusEl.className = "text-[9px] text-green-600 font-bold mt-1";
                }
            } else {
                previewEl.innerHTML = '<span class="text-[9px] text-rose-500">Failed</span>';
                if (statusEl) {
                    statusEl.textContent = "Upload failed: " + data.message;
                    statusEl.className = "text-[9px] text-rose-500 font-bold mt-1";
                }
            }
        })
        .catch(err => {
            previewEl.innerHTML = '<span class="text-[9px] text-rose-500">Error</span>';
            if (statusEl) {
                statusEl.textContent = "Request error occurred.";
                statusEl.className = "text-[9px] text-rose-500 font-bold mt-1";
            }
        });
    }
</script>

<?php $this->load->view('admin/footer'); ?>
