<div class="page__section">
  <div class="card" style="max-width: 720px; margin: 0 auto;">
    <div class="card-header">
      <div>
        <div class="card-title">Edit User: <?= esc($user_edit->username) ?></div>
        <div class="card-subtitle">Perbarui informasi akun dan role pengguna.</div>
      </div>
    </div>
    <div class="card-body">
      <form action="<?= base_url('admin/users/update/' . $user_edit->id) ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
          <label class="form-label" for="username">Username <span class="required">*</span></label>
          <input type="text" class="form-control" id="username" name="username"
                 value="<?= old('username', $user_edit->username) ?>" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="email">Email <span class="required">*</span></label>
          <input type="email" class="form-control" id="email" name="email"
                 value="<?= old('email', $user_edit->email) ?>" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="password">Password</label>
          <input type="password" class="form-control" id="password" name="password">
          <div class="form-help">Kosongkan jika tidak ingin mengubah password. Minimal 8 karakter.</div>
        </div>

        <?php if (activeGroupCan('users.manage-roles')): ?>
        <div class="form-group">
          <label class="form-label">Role <span class="form-help">(bisa pilih lebih dari satu)</span></label>
          <?php foreach ($groups as $key => $group): ?>
            <label class="form-check">
              <input type="checkbox" name="groups[]" value="<?= $key ?>"
                     <?= in_array($key, $userGroups) ? 'checked' : '' ?>>
              <span><strong><?= esc($group['title']) ?></strong> — <?= esc($group['description']) ?></span>
            </label>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="form-actions right">
          <a href="<?= base_url('admin/users') ?>" class="btn btn-outline">Batal</a>
          <button type="submit" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" aria-hidden="true">
              <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m16.475 5.408l2.117 2.117m-.756-3.482L12.109 9.77a2.1 2.1 0 0 0-.58 1.082L11 13l2.148-.53c.408-.1.787-.3 1.083-.579l5.727-5.727a1.85 1.85 0 1 0-2.617-2.617" />
            </svg>
            Perbarui
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
