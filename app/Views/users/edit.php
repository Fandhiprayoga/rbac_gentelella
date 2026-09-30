<div class="page__section">
  <div class="card" style="max-width: 720px; margin: 0 auto;">
    <div class="card-header">
      <div>
        <div class="card-title">Edit User: <?= esc($user_edit->username) ?></div>
        <div class="card-subtitle">Perbarui informasi akun dan role pengguna.</div>
      </div>
    </div>
    <div class="card-body">
      <form action="<?= base_url('admin/users/update/' . $user_edit->id) ?>" method="post" class="flex flex-col gap-4">
        <?= csrf_field() ?>

        <div class="field">
          <label for="username" class="field__label">Username <span class="text-danger">*</span></label>
          <div class="input-group">
            <input type="text" class="input" id="username" name="username"
                   value="<?= old('username', $user_edit->username) ?>" required>
          </div>
        </div>

        <div class="field">
          <label for="email" class="field__label">Email <span class="text-danger">*</span></label>
          <div class="input-group">
            <input type="email" class="input" id="email" name="email"
                   value="<?= old('email', $user_edit->email) ?>" required>
          </div>
        </div>

        <div class="field">
          <label for="password" class="field__label">Password</label>
          <div class="input-group">
            <input type="password" class="input" id="password" name="password">
          </div>
          <small class="text-muted-foreground text-xs">Kosongkan jika tidak ingin mengubah password. Minimal 8 karakter.</small>
        </div>

        <?php if (activeGroupCan('users.manage-roles')): ?>
        <div class="field">
          <label class="field__label">Role <small class="text-muted-foreground">(bisa pilih lebih dari satu)</small></label>
          <div class="flex flex-col gap-2 mt-1">
            <?php foreach ($groups as $key => $group): ?>
              <div class="field__item">
                <input class="checkbox" type="checkbox" id="group-<?= $key ?>"
                       name="groups[]" value="<?= $key ?>"
                       <?= in_array($key, $userGroups) ? 'checked' : '' ?>>
                <label class="field__label" for="group-<?= $key ?>">
                  <strong><?= esc($group['title']) ?></strong> — <?= esc($group['description']) ?>
                </label>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <div class="flex justify-end gap-2 pt-2">
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
