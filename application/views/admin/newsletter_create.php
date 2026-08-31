<?php $this->load->view('admin/header', ['title' => 'Add Content']); ?>

<div class="max-w-4xl mx-auto bg-white border border-ink-150 rounded-lg p-6 shadow-sm font-sans">
    <div class="flex justify-between items-center mb-6 pb-4 border-b border-ink-150">
        <div>
            <h1 class="text-base font-bold font-jakarta text-ink-900 flex items-center gap-2 uppercase tracking-wider">
                <i class="fa-solid fa-file-circle-plus text-accent-500"></i>
                Add New Content Entry
            </h1>
            <p class="text-xs text-ink-500 mt-1">Create a new newsletter edition and fill all layout content at once</p>
        </div>
    </div>

    <?= form_open('newsletters/save', ['class' => 'space-y-6', 'onsubmit' => "handleFormSubmit(event, '" . base_url('media/upload_image') . "')"]) ?>
        <!-- Portal Selector Dropdown -->
        <div>
            <label class="block text-xs font-bold text-ink-700 uppercase tracking-wider mb-2" for="portal_selector">Select Brand Portal / Template</label>
            <select name="portal" id="portal_selector" class="w-full px-3 py-2 text-xs bg-ink-50 border border-ink-300 rounded-[6px] text-ink-900 focus:bg-white focus:outline-none focus:ring-1 focus:ring-accent-500 focus:border-accent-500 font-semibold transition-all">
                <option value="beritasatu" <?= $newsletter['portal'] === 'beritasatu' ? 'selected' : '' ?>>BeritaSatu (Daily Digest Layout)</option>
                <option value="investor" <?= $newsletter['portal'] === 'investor' ? 'selected' : '' ?>>Investor.id (Morning Briefing Layout)</option>
                <option value="jakartaglobe" <?= $newsletter['portal'] === 'jakartaglobe' ? 'selected' : '' ?>>JakartaGlobe (Curated Digest Layout)</option>
            </select>
        </div>

        <!-- Section 1: General & Greetings -->
        <div class="space-y-4">
            <h3 class="text-xs font-bold text-ink-900 uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-ink-150">
                <span class="w-1.5 h-3 bg-accent-500 rounded-sm"></span> 1. General & Greeting Settings
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-ink-700 mb-1.5" for="volume">Volume / Edition</label>
                    <input type="number" name="volume" id="volume" class="w-full h-9 px-3 py-1.5 text-xs bg-ink-50 border border-ink-300 rounded-[6px] text-ink-900 focus:bg-white focus:outline-none focus:border-accent-500 transition-all" required value="1">
                </div>
                <div>
                    <label class="block text-xs font-bold text-ink-700 mb-1.5" for="subject">Email Subject</label>
                    <input type="text" name="subject" id="subject" class="w-full h-9 px-3 py-1.5 text-xs bg-ink-50 border border-ink-300 rounded-[6px] text-ink-900 focus:bg-white focus:outline-none focus:border-accent-500 transition-all" required placeholder="Daily digest - Edisi 01">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4" id="greeting_fields_container">
                <div>
                    <label class="block text-xs font-bold text-ink-700 mb-1.5" for="greeting_title">Greeting Title</label>
                    <input type="text" name="greeting_title" id="greeting_title" class="w-full h-9 px-3 py-1.5 text-xs bg-ink-50 border border-ink-300 rounded-[6px] text-ink-900 focus:bg-white focus:outline-none focus:border-accent-500 transition-all" value="Sahabat Beritasatu,">
                    <span class="text-[10px] text-ink-500 mt-1 block">Tip: Use <code class="cursor-pointer bg-ink-150 px-1 py-0.5 rounded hover:bg-ink-300 transition-all" onclick="insertTag('[Nama Subscriber]', 'greeting_title')">[Nama Subscriber]</code> to display the subscriber's name dynamically.</span>
                </div>
                <div id="greeting_body_container">
                    <label class="block text-xs font-bold text-ink-700 mb-1.5" for="greeting_body">Greeting Body Paragraph</label>
                    <textarea name="greeting_body" id="greeting_body" rows="6" class="w-full px-3 py-2 text-xs bg-ink-50 border border-ink-300 rounded-[6px] text-ink-900 focus:bg-white focus:outline-none focus:border-accent-500 transition-all" placeholder="Tulis kalimat pembuka di sini..."></textarea>
                </div>
            </div>
        </div>

        <!-- Section 2: Brand Layouts (Toggled via JS) -->
        
        <!-- A. BeritaSatu Fields -->
        <div id="section-beritasatu" class="brand-section space-y-5">
            <h3 class="text-xs font-bold text-ink-900 uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-ink-150">
                <span class="w-1.5 h-3 bg-red-650 rounded-sm" style="background-color: #EC1C24;"></span> 2. BeritaSatu Content (1 Featured + 4 Grid Articles)
            </h3>

            <!-- Featured -->
            <div class="bg-ink-50 border border-ink-150 rounded-lg p-4 space-y-4">
                <h4 class="text-xs font-bold text-[#EC1C24] uppercase tracking-wider">Featured Main Article</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-ink-700 mb-1">Title</label>
                            <input type="text" name="articles[0][title]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required placeholder="Main headline title">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-ink-700 mb-1">Header Label (e.g. Nasional)</label>
                            <input type="text" name="articles[0][category]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required value="Nasional" placeholder="e.g. Nasional">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-ink-700 mb-1">Article URL / Link</label>
                            <input type="url" name="articles[0][url]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required placeholder="https://example.com/article">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-ink-700 mb-1">Image File</label>
                            <input type="hidden" name="articles[0][image_url]" id="bs_img_0">
                            <label class="block w-full py-2.5 text-center text-xs font-semibold bg-white hover:bg-ink-50 text-ink-900 border border-dashed border-ink-300 rounded-[6px] cursor-pointer transition-all">
                                Select Image File
                                <input type="file" onchange="handleImageSelect(this, 'bs_img_0', 'bs_preview_0', 'bs_status_0')" class="hidden" accept="image/*">
                            </label>
                            <div class="text-[9px] text-amber-600 font-bold hidden" id="bs_status_0">Gambar dipilih (belum disimpan)</div>
                        </div>
                    </div>
                    <div class="space-y-4 flex flex-col justify-between">
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-ink-700 mb-1">Excerpt / Description</label>
                            <textarea name="articles[0][excerpt]" rows="7" class="w-full h-[calc(100%-20px)] px-3 py-2 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" placeholder="Headline summary paragraph"></textarea>
                        </div>
                        <div class="h-36 border border-ink-150 rounded-[6px] overflow-hidden flex items-center justify-center bg-white" id="bs_preview_0">
                            <span class="text-[9px] text-ink-500">No image loaded</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grids -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <div class="bg-ink-50 border border-ink-150 rounded-lg p-4 space-y-3">
                        <h4 class="text-xs font-bold text-ink-700 uppercase tracking-wider">Grid Article #<?= $i ?></h4>
                        <div>
                            <label class="block text-xs font-bold text-ink-700 mb-1">Title</label>
                            <input type="text" name="articles[<?= $i ?>][title]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required placeholder="Grid title #<?= $i ?>">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-ink-700 mb-1">Excerpt / Description</label>
                            <textarea name="articles[<?= $i ?>][excerpt]" rows="7" class="w-full px-3 py-2 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" placeholder="Grid excerpt/description #<?= $i ?>"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-ink-700 mb-1">Article URL / Link</label>
                            <input type="url" name="articles[<?= $i ?>][url]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required placeholder="https://example.com/article">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-ink-700 mb-1">Category</label>
                                <input type="text" name="articles[<?= $i ?>][category]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required value="Nasional">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-ink-700 mb-1">Image</label>
                                <input type="hidden" name="articles[<?= $i ?>][image_url]" id="bs_img_<?= $i ?>">
                                <label class="block w-full py-1.5 text-center text-[10px] font-bold bg-white hover:bg-ink-50 text-ink-900 border border-ink-300 rounded-[6px] cursor-pointer transition-all">
                                    Upload
                                    <input type="file" onchange="handleImageSelect(this, 'bs_img_<?= $i ?>', 'bs_preview_<?= $i ?>', 'bs_status_<?= $i ?>')" class="hidden" accept="image/*">
                                </label>
                                <div class="text-[8px] text-amber-600 font-bold hidden" id="bs_status_<?= $i ?>">Uploading...</div>
                            </div>
                        </div>
                        <div class="h-28 border border-ink-150 rounded-[6px] overflow-hidden flex items-center justify-center bg-white" id="bs_preview_<?= $i ?>">
                            <span class="text-[9px] text-ink-500">No image loaded</span>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- B. Investor.id Fields -->
        <div id="section-investor" class="brand-section space-y-5" style="display: none;">
            <h3 class="text-xs font-bold text-ink-900 uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-ink-150">
                <span class="w-1.5 h-3 bg-sky-500 rounded-sm" style="background-color: #1E6CA1;"></span> 2. Investor.id Tickers & Content (1 Featured + 4 List Articles)
            </h3>

            <!-- Stock Tickers -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 bg-ink-50 border border-ink-150 rounded-lg p-4">
                <?php foreach (['IHSG', 'USD/IDR', 'EMAS', 'BTC'] as $key): ?>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-ink-900"><?= $key ?></label>
                        <div class="flex items-center">
                            <input type="text" name="stats[<?= $key ?>][value]" class="flex-1 w-full h-8 px-2.5 py-1 text-xs bg-white border border-ink-300 rounded-l-[6px] text-ink-900 focus:outline-none focus:border-accent-500" placeholder="e.g. 0.5" value="0.0">
                            <span class="h-8 px-2.5 flex items-center bg-ink-150 border-y border-r border-ink-300 rounded-r-[6px] text-xs font-bold text-ink-605">%</span>
                        </div>
                        <select name="stats[<?= $key ?>][direction]" class="w-full h-8 px-2 py-1 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-700 focus:outline-none focus:border-accent-500">
                            <option value="up">Naik (Green)</option>
                            <option value="down">Turun (Red)</option>
                        </select>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Featured -->
            <div class="bg-ink-50 border border-ink-150 rounded-lg p-4 space-y-4">
                <h4 class="text-xs font-bold text-[#1E6CA1] uppercase tracking-wider font-jakarta">Featured Main Article</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-ink-700 mb-1">Title</label>
                            <input type="text" name="articles[0][title]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required placeholder="Featured title">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-ink-700 mb-1">Excerpt / Description</label>
                            <textarea name="articles[0][excerpt]" rows="7" class="w-full px-3 py-2 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" placeholder="Featured summary"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-ink-700 mb-1">Article URL / Link</label>
                            <input type="url" name="articles[0][url]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required placeholder="https://example.com/article">
                        </div>
                        <input type="hidden" name="articles[0][category]" value="Analisis Pasar">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-ink-700 mb-1">Image File</label>
                        <input type="hidden" name="articles[0][image_url]" id="inv_img_0">
                        <label class="block w-full py-2.5 text-center text-xs font-semibold bg-white hover:bg-ink-50 text-ink-900 border border-dashed border-ink-300 rounded-[6px] cursor-pointer transition-all">
                            Select Image File
                            <input type="file" onchange="handleImageSelect(this, 'inv_img_0', 'inv_preview_0', 'inv_status_0')" class="hidden" accept="image/*">
                        </label>
                        <div class="text-[9px] text-amber-600 font-bold hidden" id="inv_status_0">Uploading...</div>
                        <div class="h-36 border border-ink-150 rounded-[6px] overflow-hidden flex items-center justify-center bg-white" id="inv_preview_0">
                            <span class="text-[9px] text-ink-500">No image loaded</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lists -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <div class="bg-ink-50 border border-ink-150 rounded-lg p-4 space-y-3">
                        <h4 class="text-xs font-bold text-ink-700 uppercase tracking-wider">List Article #<?= $i ?></h4>
                        <div>
                            <label class="block text-xs font-bold text-ink-700 mb-1">Title</label>
                            <input type="text" name="articles[<?= $i ?>][title]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required placeholder="List news title #<?= $i ?>">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-ink-700 mb-1">Article URL / Link</label>
                            <input type="url" name="articles[<?= $i ?>][url]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required placeholder="https://example.com/article">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-ink-700 mb-1">Category</label>
                            <input type="text" name="articles[<?= $i ?>][category]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none" required value="Market Update">
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>

        <!-- C. JakartaGlobe Fields -->
        <div id="section-jakartaglobe" class="brand-section space-y-5" style="display: none;">
            <h3 class="text-xs font-bold text-ink-900 uppercase tracking-wider flex items-center gap-2 pb-2 border-b border-ink-150">
                <span class="w-1.5 h-3 bg-orange-500 rounded-sm" style="background-color: #ff7a00;"></span> 2. JakartaGlobe Content (1 Featured + 5 Sidebar + 4 Alternating Topics)
            </h3>

            <!-- Featured -->
            <div class="bg-ink-50 border border-ink-150 rounded-lg p-4 space-y-4">
                <h4 class="text-xs font-bold text-[#ff7a00] uppercase tracking-wider font-jakarta">Featured Main Topic</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-ink-700 mb-1">Title</label>
                            <input type="text" name="articles[0][title]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required placeholder="Main topic title">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-ink-700 mb-1">Excerpt / Description</label>
                            <textarea name="articles[0][excerpt]" rows="7" class="w-full px-3 py-2 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" placeholder="Summary paragraph"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-ink-700 mb-1">Article URL / Link</label>
                            <input type="url" name="articles[0][url]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required placeholder="https://example.com/article">
                        </div>
                        <input type="hidden" name="articles[0][category]" value="National">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-ink-700 mb-1">Image File</label>
                        <input type="hidden" name="articles[0][image_url]" id="jg_img_0">
                        <label class="block w-full py-2.5 text-center text-xs font-semibold bg-white hover:bg-ink-50 text-ink-900 border border-dashed border-ink-300 rounded-[6px] cursor-pointer transition-all">
                            Select Image File
                            <input type="file" onchange="handleImageSelect(this, 'jg_img_0', 'jg_preview_0', 'jg_status_0')" class="hidden" accept="image/*">
                        </label>
                        <div class="text-[9px] text-amber-600 font-bold hidden" id="jg_status_0">Uploading...</div>
                        <div class="h-36 border border-ink-150 rounded-[6px] overflow-hidden flex items-center justify-center bg-white" id="jg_preview_0">
                            <span class="text-[9px] text-ink-500">No image loaded</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebars (1-5) -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-ink-700 uppercase tracking-wider pb-1 border-b border-ink-150">Sidebar Topic Links</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <div class="bg-ink-50 border border-ink-150 rounded-lg p-3.5 space-y-3">
                            <h5 class="text-[10px] font-bold text-ink-500 uppercase">Sidebar Link #<?= $i ?></h5>
                            <div>
                                <label class="block text-[10px] font-bold text-ink-700 mb-1">Title</label>
                                <input type="text" name="articles[<?= $i ?>][title]" class="w-full px-2 py-1 text-[11px] bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required placeholder="Sidebar title #<?= $i ?>">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-ink-700 mb-1">Article Link</label>
                                <input type="url" name="articles[<?= $i ?>][url]" class="w-full px-2 py-1 text-[11px] bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required placeholder="https://example.com/article">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-ink-700 mb-1">Category</label>
                                <input type="text" name="articles[<?= $i ?>][category]" class="w-full px-2 py-1 text-[11px] bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none" required value="Finance">
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Alternatings (6-9) -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-ink-700 uppercase tracking-wider pb-1 border-b border-ink-150">Alternating Feed Topics</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php for ($i = 6; $i <= 9; $i++): ?>
                        <?php $item_idx = $i - 5; ?>
                        <div class="bg-ink-50 border border-ink-150 rounded-lg p-4 space-y-3">
                            <h5 class="text-[10px] font-bold text-ink-500 uppercase">Feed Topic #<?= $item_idx ?></h5>
                            <div>
                                <label class="block text-xs font-bold text-ink-700 mb-1">Title</label>
                                <input type="text" name="articles[<?= $i ?>][title]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required placeholder="Feed topic title #<?= $item_idx ?>">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-ink-700 mb-1">Excerpt / Summary</label>
                                <textarea name="articles[<?= $i ?>][excerpt]" rows="7" class="w-full px-3 py-2 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required placeholder="Feed summary paragraph"></textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-ink-700 mb-1">Article URL / Link</label>
                                <input type="url" name="articles[<?= $i ?>][url]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none focus:border-accent-500" required placeholder="https://example.com/article">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-ink-700 mb-1">Category</label>
                                    <input type="text" name="articles[<?= $i ?>][category]" class="w-full h-9 px-3 py-1.5 text-xs bg-white border border-ink-300 rounded-[6px] text-ink-900 focus:outline-none" required value="World">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-ink-700 mb-1">Image</label>
                                    <input type="hidden" name="articles[<?= $i ?>][image_url]" id="jg_img_<?= $i ?>">
                                    <label class="block w-full py-1.5 text-center text-[10px] font-bold bg-white hover:bg-ink-50 text-ink-900 border border-ink-300 rounded-[6px] cursor-pointer transition-all">
                                        Upload
                                        <input type="file" onchange="handleImageSelect(this, 'jg_img_<?= $i ?>', 'jg_preview_<?= $i ?>', 'jg_status_<?= $i ?>')" class="hidden" accept="image/*">
                                    </label>
                                </div>
                            </div>
                            <div class="h-28 border border-ink-150 rounded-[6px] overflow-hidden flex items-center justify-center bg-white" id="jg_preview_<?= $i ?>">
                                <span class="text-[9px] text-ink-500">No image loaded</span>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>

        <div class="flex gap-3 pt-4 border-t border-ink-150">
            <button type="submit" class="px-4 py-2 bg-accent-500 hover:bg-accent-600 text-white font-bold rounded-[6px] text-xs shadow-sm transition-all">
                <i class="fa-solid fa-floppy-disk"></i> Save Content
            </button>
            <a href="<?= base_url('newsletters') ?>" class="px-4 py-2 bg-white hover:bg-ink-50 text-ink-900 border border-ink-300 rounded-[6px] text-xs font-bold transition-all">Cancel</a>
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

            // Keep greeting settings container always visible
            const greetingContainer = document.getElementById("greeting_fields_container");
            greetingContainer.style.display = '';
            greetingContainer.querySelectorAll("input, textarea").forEach(input => {
                input.disabled = false;
            });

            // Toggle Greeting Body container based on portal (statis for Beritasatu & JakartaGlobe)
            const greetingBodyContainer = document.getElementById("greeting_body_container");
            if (selectedPortal === 'beritasatu' || selectedPortal === 'jakartaglobe') {
                greetingBodyContainer.style.display = 'none';
                greetingBodyContainer.querySelector("textarea").disabled = true;
            } else {
                greetingBodyContainer.style.display = '';
                greetingBodyContainer.querySelector("textarea").disabled = false;
            }

            // Hide all brand sections
            document.querySelectorAll(".brand-section").forEach(sec => {
                sec.style.display = 'none';
                // Disable all inputs inside hidden sections so they don't submit empty values
                sec.querySelectorAll("input, textarea, select").forEach(input => {
                    input.disabled = true;
                });
            });

            // Show active brand section
            const activeSec = document.getElementById("section-" + selectedPortal);
            if (activeSec) {
                activeSec.style.display = '';
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
