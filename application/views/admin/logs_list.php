<?php $this->load->view('admin/header', ['title' => $title]); ?>

<div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-[#20254D]"><?= htmlspecialchars($title) ?></h1>
            <p class="text-sm text-slate-500 mt-1">Audit log of all sent newsletter editions for <?= ucfirst($portal) ?></p>
        </div>
        <?php if ($portal === 'beritasatu'): ?>
            <span class="px-2.5 py-0.5 bg-red-50 text-[#EC1C24] border border-red-200 rounded-full text-xs font-bold uppercase tracking-wider">BeritaSatu</span>
        <?php elseif ($portal === 'investor'): ?>
            <span class="px-2.5 py-0.5 bg-sky-50 text-sky-600 border border-sky-200 rounded-full text-xs font-bold uppercase tracking-wider">Investor.id</span>
        <?php else: ?>
            <span class="px-2.5 py-0.5 bg-orange-50 text-orange-600 border border-orange-200 rounded-full text-xs font-bold uppercase tracking-wider">Jakarta Globe</span>
        <?php endif; ?>
    </div>

    <div class="overflow-x-auto border border-slate-200 rounded-lg">
        <table class="w-full border-collapse text-left text-sm">
            <thead>
                <tr class="bg-slate-100/80 border-b border-slate-200 text-[#20254D] font-bold">
                    <th class="p-4">Sent At</th>
                    <th class="p-4">Edition (Vol)</th>
                    <th class="p-4">Subject</th>
                    <th class="p-4">Recipients</th>
                    <th class="p-4">Sent Content Summary</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($logs)): ?>
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400">No sending history found for this portal.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                        <tr class="hover:bg-slate-50 transition-all">
                            <td class="p-4 text-slate-650 font-medium"><?= date('d M Y, H:i', strtotime($log['sent_at'])) ?></td>
                            <td class="p-4 text-slate-800 font-semibold">Vol <?= htmlspecialchars($log['volume']) ?></td>
                            <td class="p-4 text-slate-800 font-semibold"><?= htmlspecialchars($log['subject']) ?></td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                    <?= htmlspecialchars($log['recipients_count']) ?> emails
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="text-xs text-slate-600 max-w-md line-clamp-2 bg-slate-50 p-2.5 rounded border border-slate-100 font-mono">
                                    <?= nl2br(htmlspecialchars($log['content_summary'])) ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $this->load->view('admin/footer'); ?>
