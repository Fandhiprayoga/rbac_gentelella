<?php $currentUser = auth()->user(); ?>

<div class="row col-4-8">
  <section class="card" aria-label="Ringkasan profil">
    <div class="card-body" style="text-align:center;padding:24px 16px">
      <div style="width:96px;height:96px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--primary-dk));margin:0 auto 12px;display:flex;align-items:center;justify-content:center;color:white;font-size:32px;font-weight:600" aria-hidden="true">
        <?= esc(strtoupper(substr($currentUser->username, 0, 1))) ?>
      </div>
      <div style="font-size:16px;font-weight:600;color:var(--text)"><?= esc($currentUser->username) ?></div>
      <div style="font-size:12.5px;color:var(--text-muted);margin-top:2px;overflow-wrap:anywhere"><?= esc($currentUser->email) ?></div>
      <div style="margin-top:14px;display:flex;flex-wrap:wrap;gap:6px;justify-content:center">
        <?php foreach ($currentUser->getGroups() as $group): ?>
          <span class="badge badge-teal"><?= esc(config('AuthGroups')->groups[$group]['title'] ?? ucfirst($group)) ?></span>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section class="card" aria-labelledby="profile-form-title">
    <div class="card-header">
      <div>
        <div class="card-title" id="profile-form-title">Informasi pribadi</div>
        <div class="card-subtitle">Perbarui username dan keamanan akun Anda.</div>
      </div>
    </div>
    <div class="card-body">
      <form action="<?= base_url('profile/update') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label" for="username">Username <span class="required">*</span></label>
            <input type="text" class="form-control" id="username" name="username"
                   value="<?= esc(old('username', $currentUser->username), 'attr') ?>" minlength="3" maxlength="30" autocomplete="username" required>
          </div>
          <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input type="email" class="form-control" id="email" value="<?= esc($currentUser->email, 'attr') ?>" disabled>
            <div class="form-help">Email tidak dapat diubah.</div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="password">Password baru</label>
          <input type="password" class="form-control" id="password" name="password" autocomplete="new-password" autocapitalize="off" spellcheck="false">
          <div class="form-help">Kosongkan jika tidak ingin mengubah password.</div>
        </div>

        <div class="form-actions right">
          <button type="reset" class="btn btn-outline">Batalkan</button>
          <button type="submit" class="btn btn-primary">Simpan perubahan</button>
        </div>
      </form>
    </div>
  </section>
</div>
