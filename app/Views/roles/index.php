<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Semua role</div>
      <div class="card-subtitle">Daftar role beserta permission yang dimilikinya.</div>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th style="width:48px">#</th>
          <th>Role</th>
          <th>Deskripsi</th>
          <th>Permissions</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($groups)): ?>
          <?php $no = 1; foreach ($groups as $key => $group): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td>
              <?php
                $chipClass = match ($key) {
                    'superadmin' => 'chip chip-red',
                    'admin'      => 'chip chip-yellow',
                    'manager'    => 'chip chip-blue',
                    default      => 'chip',
                };
              ?>
              <span class="<?= $chipClass ?>"><?= esc($group['title']) ?></span>
            </td>
            <td><?= esc($group['description']) ?></td>
            <td>
              <?php if (!empty($matrix[$key])): ?>
                <div style="display:flex;flex-wrap:wrap;gap:4px">
                  <?php foreach ($matrix[$key] as $perm): ?>
                    <span class="chip"><?= esc($perm) ?></span>
                  <?php endforeach; ?>
                </div>
              <?php else: ?>
                <span style="color:var(--text-muted)">Tidak ada permission</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" style="text-align:center;padding:32px 0;color:var(--text-muted)">Belum ada data role.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php $totalRoles = count($groups ?? []); ?>
  <nav class="pagination" aria-label="Navigasi halaman">
    <span class="page-info">Showing <?= $totalRoles > 0 ? 1 : 0 ?>&ndash;<?= $totalRoles ?> of <?= $totalRoles ?></span>
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

