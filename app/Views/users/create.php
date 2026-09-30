<div class="page__section">
  <div class="card" style="max-width: 720px; margin: 0 auto;">
    <div class="card-header">
      <div>
        <div class="card-title">Tambah User Baru</div>
        <div class="card-subtitle">Lengkapi informasi akun dan tentukan role pengguna.</div>
      </div>
    </div>
    <div class="card-body">
      <form action="<?= base_url('admin/users/store') ?>" method="post" class="flex flex-col gap-4">
        <?= csrf_field() ?>

        <div class="field">
          <label for="username" class="field__label">Username <span class="text-danger">*</span></label>
          <div class="input-group">
            <input type="text" class="input" id="username" name="username" value="<?= old('username') ?>" required>
          </div>
        </div>

        <div class="field">
          <label for="email" class="field__label">Email <span class="text-danger">*</span></label>
          <div class="input-group">
            <input type="email" class="input" id="email" name="email" value="<?= old('email') ?>" required>
          </div>
        </div>

        <div class="field">
          <label for="password" class="field__label">Password <span class="text-danger">*</span></label>
          <div class="input-group">
            <input type="password" class="input" id="password" name="password" required>
          </div>
          <small class="text-muted-foreground text-xs">Minimal 8 karakter</small>
        </div>

        <div class="field">
          <label class="field__label">Role <span class="text-danger">*</span> <small class="text-muted-foreground">(bisa pilih lebih dari satu)</small></label>
          <div class="flex flex-col gap-2 mt-1">
            <?php foreach ($groups as $key => $group): ?>
              <div class="field__item">
                <input class="checkbox" type="checkbox" id="group-<?= $key ?>"
                       name="groups[]" value="<?= $key ?>"
                       <?= is_array(old('groups')) && in_array($key, old('groups')) ? 'checked' : '' ?>>
                <label class="field__label" for="group-<?= $key ?>">
                  <strong><?= esc($group['title']) ?></strong> — <?= esc($group['description']) ?>
                </label>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="flex justify-end gap-2 pt-2">
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
