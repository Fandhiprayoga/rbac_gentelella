<div class="page__section">
  <div class="card" style="max-width: 720px; margin: 0 auto;">
    <div class="card-header">
      <div>
        <div class="card-title">Tambah User Baru</div>
        <div class="card-subtitle">Lengkapi informasi akun dan tentukan role pengguna.</div>
      </div>
    </div>
    <div class="card-body">
      <form action="<?= base_url('admin/users/store') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
          <label class="form-label" for="username">Username <span class="required">*</span></label>
          <input type="text" class="form-control" id="username" name="username" placeholder="e.g. johndoe" value="<?= old('username') ?>" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="email">Email <span class="required">*</span></label>
          <input type="email" class="form-control" id="email" name="email" placeholder="nama@example.com" value="<?= old('email') ?>" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="password">Password <span class="required">*</span></label>
          <input type="password" class="form-control" id="password" name="password" required>
          <div class="form-help">Minimal 8 karakter.</div>
        </div>

        <div class="form-group">
          <label class="form-label">Role <span class="required">*</span> <span class="form-help">(bisa pilih lebih dari satu)</span></label>
          <?php foreach ($groups as $key => $group): ?>
            <label class="form-check">
              <input type="checkbox" name="groups[]" value="<?= $key ?>"
                     <?= is_array(old('groups')) && in_array($key, old('groups')) ? 'checked' : '' ?>>
              <span><strong><?= esc($group['title']) ?></strong> — <?= esc($group['description']) ?></span>
            </label>
          <?php endforeach; ?>
        </div>

        <div class="form-actions right">
          <a href="<?= base_url('admin/users') ?>" class="btn btn-outline">Batal</a>
          <button type="submit" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" aria-hidden="true">
              <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="M17 21H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4h6l7 7v7a4 4 0 0 1-4 4z" />
              <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.5" d="M13 3v4a2 2 0 0 0 2 2h4" />
            </svg>
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
