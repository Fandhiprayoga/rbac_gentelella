<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Matrix permission per role</div>
      <div class="card-subtitle">Permission yang dimiliki setiap role dalam sistem.</div>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Permission</th>
          <th>Deskripsi</th>
          <?php foreach ($groups as $key => $group): ?>
          <th style="text-align:center"><?= esc($group['title']) ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($permissions)): ?>
          <?php foreach ($permissions as $permKey => $permDesc): ?>
          <tr>
            <td><span class="cell-strong"><?= esc($permKey) ?></span></td>
            <td><?= esc($permDesc) ?></td>
            <?php foreach ($groups as $groupKey => $group): ?>
            <td style="text-align:center">
              <?php
                $hasPermission = false;
                foreach ($matrix[$groupKey] ?? [] as $matrixPerm) {
                    if ($matrixPerm === $permKey) {
                        $hasPermission = true;
                        break;
                    }
                    if (str_contains($matrixPerm, '*') && str_starts_with($permKey, str_replace('*', '', $matrixPerm))) {
                        $hasPermission = true;
                        break;
                    }
                }
              ?>
              <?php if ($hasPermission): ?>
                <span class="status status-green">Ya</span>
              <?php else: ?>
                <span class="status status-red">Tidak</span>
              <?php endif; ?>
            </td>
            <?php endforeach; ?>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="<?= 2 + count($groups) ?>" style="text-align:center;padding:32px 0;color:var(--text-muted)">Belum ada data permission.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php $totalPermissions = count($permissions ?? []); ?>
  <nav class="pagination" aria-label="Navigasi halaman">
    <span class="page-info">Showing <?= $totalPermissions > 0 ? 1 : 0 ?>&ndash;<?= $totalPermissions ?> of <?= $totalPermissions ?></span>
    <div style="display:inline-flex;align-items:center;gap:var(--space-1)">
      <button type="button" class="page-btn" disabled aria-label="Sebelumnya">
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M10 4l-4 4 4 4" /></svg>
      </button>
      <button type="button" class="page-btn active" aria-current="page">1</button>
      <button type="button" class="page-btn" disabled aria-label="Berikutnya">
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M6 4l4 4-4 4" /></svg>
      </button>
    </div>
  </nav>
</div>

