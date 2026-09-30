<?php
/** @var array $settings */
/** @var array $groups */
/** @var string $activeTab */

$s = function (string $key) use ($settings) {
    return esc($settings[$key] ?? '');
};
?>

<div class="page__section">
  <div class="flex flex-col gap-4">
    <nav class="w-full overflow-x-auto" aria-label="Bagian pengaturan">
      <div class="btn-group" role="group" data-group="settings-tabs" aria-label="Pilih bagian pengaturan">
        <button type="button" class="btn btn-outline <?= $activeTab === 'general' ? 'active' : '' ?>" aria-controls="settingsTabs" aria-pressed="<?= $activeTab === 'general' ? 'true' : 'false' ?>" data-stisla-tabs-value="general">Umum</button>
        <button type="button" class="btn btn-outline <?= $activeTab === 'appearance' ? 'active' : '' ?>" aria-controls="settingsTabs" aria-pressed="<?= $activeTab === 'appearance' ? 'true' : 'false' ?>" data-stisla-tabs-value="appearance">Tampilan</button>
        <button type="button" class="btn btn-outline <?= $activeTab === 'auth' ? 'active' : '' ?>" aria-controls="settingsTabs" aria-pressed="<?= $activeTab === 'auth' ? 'true' : 'false' ?>" data-stisla-tabs-value="auth">Autentikasi</button>
        <button type="button" class="btn btn-outline <?= $activeTab === 'mail' ? 'active' : '' ?>" aria-controls="settingsTabs" aria-pressed="<?= $activeTab === 'mail' ? 'true' : 'false' ?>" data-stisla-tabs-value="mail">Email</button>
      </div>
    </nav>

    <div class="w-full">
      <div class="tabs" id="settingsTabs" data-stisla-tabs>

        <!-- ======================== TAB: UMUM ======================== -->
        <div class="tabs__panel" data-value="general" data-state="<?= $activeTab === 'general' ? 'active' : 'inactive' ?>">
          <div class="flex flex-col gap-6">
            <section>
              <form action="<?= base_url('admin/settings/update/general') ?>" method="post">
                <?= csrf_field() ?>
                <div class="card">
                  <div class="card-header">
                    <div>
                      <div class="card-title">Pengaturan Umum</div>
                      <div class="card-subtitle">Nama aplikasi, deskripsi, dan informasi dasar.</div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="grid grid-cols-12 gap-4">
                      <div class="col-span-12 sm:col-span-6">
                        <div class="field">
                          <label for="site_name" class="field__label">Nama Aplikasi <span class="text-danger">*</span></label>
                          <input type="text" class="input" id="site_name" name="site_name"
                                 value="<?= old('site_name', $s('App.siteName')) ?>" required>
                        </div>
                      </div>
                      <div class="col-span-12 sm:col-span-6">
                        <div class="field">
                          <label for="site_name_short" class="field__label">Nama Pendek</label>
                          <input type="text" class="input" id="site_name_short" name="site_name_short"
                                 value="<?= old('site_name_short', $s('App.siteNameShort')) ?>" maxlength="10">
                          <small class="text-muted-foreground text-xs">Maks 10 karakter, ditampilkan saat sidebar diminimalkan.</small>
                        </div>
                      </div>
                      <div class="col-span-12">
                        <div class="field">
                          <label for="site_description" class="field__label">Deskripsi</label>
                          <textarea class="input" id="site_description" name="site_description" rows="2"><?= old('site_description', $s('App.siteDescription')) ?></textarea>
                        </div>
                      </div>
                      <div class="col-span-12 sm:col-span-8">
                        <div class="field">
                          <label for="site_footer" class="field__label">Teks Footer</label>
                          <input type="text" class="input" id="site_footer" name="site_footer"
                                 value="<?= old('site_footer', $s('App.siteFooter')) ?>">
                        </div>
                      </div>
                      <div class="col-span-12 sm:col-span-4">
                        <div class="field">
                          <label for="site_version" class="field__label">Versi</label>
                          <input type="text" class="input" id="site_version" name="site_version"
                                 value="<?= old('site_version', $s('App.siteVersion')) ?>">
                        </div>
                      </div>
                    </div>
                    <div class="flex justify-end mt-4">
                      <button type="submit" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" aria-hidden="true"><path fill="none" stroke="currentColor" stroke-width="1.5" d="M17 21H7a4 4 0 0 1-4-4V7a4 4 0 0 1 4-4h6l7 7v7a4 4 0 0 1-4 4z" /><path fill="none" stroke="currentColor" stroke-width="1.5" d="M13 3v4a2 2 0 0 0 2 2h4" /></svg>
                        Simpan
                      </button>
                    </div>
                  </div>
                </div>
              </form>
            </section>

            <section>
              <form action="<?= base_url('admin/settings/update/branding') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="card">
                  <div class="card-header">
                    <div>
                      <div class="card-title">Branding</div>
                      <div class="card-subtitle">Logo dan favicon aplikasi.</div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="grid grid-cols-12 gap-4">
                      <div class="col-span-12 sm:col-span-6">
                        <div class="field">
                          <label class="field__label">Logo Aplikasi</label>
                          <?php
                            $currentLogo = $settings['App.siteLogo'] ?? '';
                            $logoUrl = ! empty($currentLogo) ? base_url($currentLogo) : base_url('assets/img/stisla-fill.svg');
                          ?>
                          <div class="mb-2">
                            <img src="<?= $logoUrl ?>" alt="Current Logo" id="logoPreview"
                                 style="max-height: 60px; border: 1px solid var(--color-border); padding: 4px; border-radius: 6px; background: var(--color-surface-raised);">
                            <?php if (empty($currentLogo)): ?>
                              <span class="badge badge--soft badge--secondary ml-1">Default</span>
                            <?php endif; ?>
                          </div>
                          <input type="file" class="input" id="site_logo" name="site_logo" accept="image/*"
                                 onchange="previewImage(this, 'logoPreview')">
                          <small class="text-muted-foreground text-xs">PNG, JPG, SVG, WebP. Maks 2MB.</small>
                        </div>
                      </div>
                      <div class="col-span-12 sm:col-span-6">
                        <div class="field">
                          <label class="field__label">Favicon</label>
                          <?php
                            $currentFavicon = $settings['App.siteFavicon'] ?? '';
                            $faviconUrl = ! empty($currentFavicon) ? base_url($currentFavicon) : base_url('assets/img/stisla-fill.svg');
                          ?>
                          <div class="mb-2">
                            <img src="<?= $faviconUrl ?>" alt="Current Favicon" id="faviconPreview"
                                 style="max-height: 40px; max-width: 40px; border: 1px solid var(--color-border); padding: 4px; border-radius: 4px; background: var(--color-surface-raised);">
                            <?php if (empty($currentFavicon)): ?>
                              <span class="badge badge--soft badge--secondary ml-1">Default</span>
                            <?php endif; ?>
                          </div>
                          <input type="file" class="input" id="site_favicon" name="site_favicon" accept="image/*,.ico"
                                 onchange="previewImage(this, 'faviconPreview')">
                          <small class="text-muted-foreground text-xs">PNG, ICO, SVG, WebP. Maks 1MB.</small>
                        </div>
                      </div>
                    </div>
                    <div class="flex justify-end mt-4">
                      <button type="submit" class="btn btn-primary">Upload Branding</button>
                    </div>
                  </div>
                </div>
              </form>
            </section>

            <section>
              <form action="<?= base_url('admin/settings/reset') ?>" method="post"
                    onsubmit="return confirm('Reset pengaturan Umum & Branding ke default?')">
                <?= csrf_field() ?>
                <input type="hidden" name="tab" value="general">
                <button type="submit" class="btn btn-danger btn-sm">Reset ke Default</button>
              </form>
            </section>
          </div>
        </div>

        <!-- ======================== TAB: TAMPILAN ======================== -->
        <div class="tabs__panel" data-value="appearance" data-state="<?= $activeTab === 'appearance' ? 'active' : 'inactive' ?>">
          <div class="flex flex-col gap-6">
            <section>
              <form action="<?= base_url('admin/settings/update/appearance') ?>" method="post">
                <?= csrf_field() ?>
                <div class="card">
                  <div class="card-header">
                    <div>
                      <div class="card-title">Warna Tema</div>
                      <div class="card-subtitle">Kustomisasi dua warna gradient untuk latar auth aside.</div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="grid grid-cols-12 gap-4">
                      <div class="col-span-12 sm:col-span-6">
                        <div class="field">
                          <label for="auth_aside_start" class="field__label">Warna Gradient Awal <span class="text-danger">*</span></label>
                          <div class="flex items-center gap-2">
                            <input type="color" id="auth_aside_start_picker"
                                   value="<?= old('auth_aside_start', $s('App.authAsideStart') ?: '#2f3f63') ?>"
                                   style="width: 44px; height: 36px; padding: 2px; cursor: pointer; border: 1px solid var(--color-border); border-radius: 6px;"
                                   oninput="document.getElementById('auth_aside_start').value=this.value; updatePreview()">
                            <input type="text" class="input" id="auth_aside_start" name="auth_aside_start"
                                   value="<?= old('auth_aside_start', $s('App.authAsideStart') ?: '#2f3f63') ?>"
                                   pattern="^#[0-9A-Fa-f]{6}$" maxlength="7" required
                                   oninput="document.getElementById('auth_aside_start_picker').value=this.value; updatePreview()">
                          </div>
                        </div>
                      </div>
                      <div class="col-span-12 sm:col-span-6">
                        <div class="field">
                          <label for="auth_aside_end" class="field__label">Warna Gradient Akhir <span class="text-danger">*</span></label>
                          <div class="flex items-center gap-2">
                            <input type="color" id="auth_aside_end_picker"
                                   value="<?= old('auth_aside_end', $s('App.authAsideEnd') ?: '#1b2338') ?>"
                                   style="width: 44px; height: 36px; padding: 2px; cursor: pointer; border: 1px solid var(--color-border); border-radius: 6px;"
                                   oninput="document.getElementById('auth_aside_end').value=this.value; updatePreview()">
                            <input type="text" class="input" id="auth_aside_end" name="auth_aside_end"
                                   value="<?= old('auth_aside_end', $s('App.authAsideEnd') ?: '#1b2338') ?>"
                                   pattern="^#[0-9A-Fa-f]{6}$" maxlength="7" required
                                   oninput="document.getElementById('auth_aside_end_picker').value=this.value; updatePreview()">
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Live Preview -->
                    <div class="mt-4 p-3 rounded" style="background: var(--color-surface-raised); border: 1px solid var(--color-border); max-width: 400px;">
                      <div id="preview-auth-aside"
                           style="min-height: 140px; border-radius: 8px; padding: 12px; color: #fff; background: linear-gradient(160deg, <?= $s('App.authAsideStart') ?: '#2f3f63' ?> 0%, <?= $s('App.authAsideEnd') ?: '#1b2338' ?> 55%);">
                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
                          <div style="width:28px; height:28px; border-radius:6px; background: rgba(255,255,255,0.16);"></div>
                          <div style="font-size:11px; font-weight:600;">Brand</div>
                        </div>
                        <div style="font-size:16px; line-height:1.2; font-weight:300; margin-bottom:8px;">Akses aman,<br>proses lebih tertata.</div>
                        <div style="font-size:11px; opacity:0.75;">Pratinjau latar gradient untuk area auth aside.</div>
                      </div>
                    </div>

                    <div class="flex justify-end mt-4">
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </div>
                </div>
              </form>
            </section>

            <section>
              <form action="<?= base_url('admin/settings/reset') ?>" method="post"
                    onsubmit="return confirm('Reset pengaturan Tampilan ke default?')">
                <?= csrf_field() ?>
                <input type="hidden" name="tab" value="appearance">
                <button type="submit" class="btn btn-danger btn-sm">Reset ke Default</button>
              </form>
            </section>
          </div>
        </div>

        <!-- ======================== TAB: AUTENTIKASI ======================== -->
        <div class="tabs__panel" data-value="auth" data-state="<?= $activeTab === 'auth' ? 'active' : 'inactive' ?>">
          <div class="flex flex-col gap-6">
            <section>
              <form action="<?= base_url('admin/settings/update/auth') ?>" method="post">
                <?= csrf_field() ?>
                <div class="card">
                  <div class="card-header">
                    <div>
                      <div class="card-title">Autentikasi & Registrasi</div>
                      <div class="card-subtitle">Pengaturan role default, registrasi, dan mode pemeliharaan.</div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="flex flex-col gap-4">
                      <div class="field">
                        <label for="default_role" class="field__label">Default Role <span class="text-danger">*</span></label>
                        <select class="select" id="default_role" name="default_role">
                          <?php foreach ($groups as $key => $group): ?>
                            <option value="<?= $key ?>" <?= ($settings['App.defaultRole'] ?? 'user') === $key ? 'selected' : '' ?>>
                              <?= esc($group['title']) ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                        <small class="text-muted-foreground text-xs">Role otomatis untuk user baru saat registrasi.</small>
                      </div>

                      <div class="flex items-center justify-between">
                        <div>
                          <label class="field__label mb-0" for="allow_registration">Izinkan Registrasi</label>
                          <small class="text-muted-foreground text-xs">User baru bisa mendaftar sendiri.</small>
                        </div>
                           <label class="switch">
                             <input type="checkbox" role="switch" id="allow_registration"
                               name="allow_registration" value="1"
                               <?= !empty($settings['Auth.allowRegistration']) ? 'checked' : '' ?>>
                             <span class="track" aria-hidden="true"></span>
                           </label>
                      </div>

                      <hr class="separator">

                      <h3 class="text-sm font-semibold">Mode Pemeliharaan</h3>

                      <div class="flex items-center justify-between">
                        <div>
                          <label class="field__label mb-0" for="maintenance_mode">Maintenance Mode</label>
                          <small class="text-muted-foreground text-xs">Hanya Super Admin yang bisa mengakses sistem.</small>
                        </div>
                           <label class="switch">
                             <input type="checkbox" role="switch" id="maintenance_mode"
                               name="maintenance_mode" value="1"
                               <?= ($settings['App.maintenanceMode'] ?? '0') === '1' ? 'checked' : '' ?>>
                             <span class="track" aria-hidden="true"></span>
                           </label>
                      </div>

                      <div class="field">
                        <label for="maintenance_msg" class="field__label">Pesan Maintenance</label>
                        <textarea class="input" id="maintenance_msg" name="maintenance_msg" rows="2"><?= old('maintenance_msg', $s('App.maintenanceMsg')) ?></textarea>
                      </div>
                    </div>

                    <div class="flex justify-end mt-4">
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </div>
                </div>
              </form>
            </section>

            <section>
              <form action="<?= base_url('admin/settings/reset') ?>" method="post"
                    onsubmit="return confirm('Reset pengaturan Autentikasi ke default?')">
                <?= csrf_field() ?>
                <input type="hidden" name="tab" value="auth">
                <button type="submit" class="btn btn-danger btn-sm">Reset ke Default</button>
              </form>
            </section>
          </div>
        </div>

        <!-- ======================== TAB: EMAIL ======================== -->
        <div class="tabs__panel" data-value="mail" data-state="<?= $activeTab === 'mail' ? 'active' : 'inactive' ?>">
          <div class="flex flex-col gap-6">
            <section>
              <form action="<?= base_url('admin/settings/update/mail') ?>" method="post">
                <?= csrf_field() ?>
                <div class="card">
                  <div class="card-header">
                    <div>
                      <div class="card-title">Konfigurasi Email</div>
                      <div class="card-subtitle">Pengaturan SMTP dan identitas pengirim.</div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="flex flex-col gap-4">
                      <div class="field">
                        <label for="mail_protocol" class="field__label">Protokol <span class="text-danger">*</span></label>
                        <select class="select" id="mail_protocol" name="mail_protocol" onchange="toggleSmtp()">
                          <?php $proto = $settings['Mail.protocol'] ?? 'smtp'; ?>
                          <option value="smtp" <?= $proto === 'smtp' ? 'selected' : '' ?>>SMTP</option>
                          <option value="sendmail" <?= $proto === 'sendmail' ? 'selected' : '' ?>>Sendmail</option>
                          <option value="mail" <?= $proto === 'mail' ? 'selected' : '' ?>>PHP Mail</option>
                        </select>
                      </div>

                      <div id="smtp-settings" class="flex flex-col gap-4">
                        <div class="grid grid-cols-12 gap-4">
                          <div class="col-span-12 sm:col-span-8">
                            <div class="field">
                              <label for="mail_hostname" class="field__label">SMTP Host</label>
                              <input type="text" class="input" id="mail_hostname" name="mail_hostname"
                                     value="<?= old('mail_hostname', $s('Mail.hostname')) ?>" placeholder="smtp.gmail.com">
                            </div>
                          </div>
                          <div class="col-span-12 sm:col-span-4">
                            <div class="field">
                              <label for="mail_port" class="field__label">Port</label>
                              <input type="number" class="input" id="mail_port" name="mail_port"
                                     value="<?= old('mail_port', $s('Mail.port')) ?>" placeholder="587">
                            </div>
                          </div>
                        </div>

                        <div class="grid grid-cols-12 gap-4">
                          <div class="col-span-12 sm:col-span-4">
                            <div class="field">
                              <label for="mail_encryption" class="field__label">Enkripsi</label>
                              <?php $enc = $settings['Mail.encryption'] ?? 'tls'; ?>
                              <select class="select" id="mail_encryption" name="mail_encryption">
                                <option value="tls" <?= $enc === 'tls' ? 'selected' : '' ?>>TLS</option>
                                <option value="ssl" <?= $enc === 'ssl' ? 'selected' : '' ?>>SSL</option>
                                <option value="none" <?= $enc === 'none' ? 'selected' : '' ?>>Tanpa Enkripsi</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-span-12 sm:col-span-8">
                            <div class="field">
                              <label for="mail_username" class="field__label">Username</label>
                              <input type="text" class="input" id="mail_username" name="mail_username"
                                     value="<?= old('mail_username', $s('Mail.username')) ?>" placeholder="email@gmail.com" autocomplete="off">
                            </div>
                          </div>
                        </div>

                        <div class="field">
                          <label for="mail_password" class="field__label">Password</label>
                          <input type="password" class="input" id="mail_password" name="mail_password"
                                 placeholder="Kosongkan jika tidak ingin mengubah" autocomplete="new-password">
                          <?php if (! empty($settings['Mail.password'])): ?>
                            <small class="text-success text-xs">✓ Password sudah diatur</small>
                          <?php endif; ?>
                        </div>
                      </div>

                      <hr class="separator">

                      <h3 class="text-sm font-semibold">Identitas Pengirim</h3>

                      <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 sm:col-span-6">
                          <div class="field">
                            <label for="mail_from_email" class="field__label">Email Pengirim</label>
                            <input type="email" class="input" id="mail_from_email" name="mail_from_email"
                                   value="<?= old('mail_from_email', $s('Mail.fromEmail')) ?>" placeholder="noreply@example.com">
                          </div>
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                          <div class="field">
                            <label for="mail_from_name" class="field__label">Nama Pengirim</label>
                            <input type="text" class="input" id="mail_from_name" name="mail_from_name"
                                   value="<?= old('mail_from_name', $s('Mail.fromName')) ?>" placeholder="My App">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="flex justify-between items-center mt-4">
                      <button type="button" class="btn btn-outline btn-sm" onclick="openTestEmail()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" aria-hidden="true"><g fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 12c0-3.771 0-5.657 1.172-6.828S6.229 4 10 4h4c3.771 0 5.657 0 6.828 1.172S22 8.229 22 12s0 5.657-1.172 6.828S17.771 20 14 20h-4c-3.771 0-5.657 0-6.828-1.172S2 15.771 2 12Z" /><path stroke-linecap="round" d="m6 8l2.159 1.8c1.837 1.53 2.755 2.295 3.841 2.295s2.005-.765 3.841-2.296L18 8" /></g></svg>
                        Test Email
                      </button>
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </div>
                </div>
              </form>
            </section>

            <section>
              <form action="<?= base_url('admin/settings/reset') ?>" method="post"
                    onsubmit="return confirm('Reset pengaturan Email ke default?')">
                <?= csrf_field() ?>
                <input type="hidden" name="tab" value="mail">
                <button type="submit" class="btn btn-danger btn-sm">Reset ke Default</button>
              </form>
            </section>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- Dialog: Test Email -->
<div class="dialog dialog--sm" id="testEmailDialog" data-stisla-dialog data-state="closed" role="dialog" aria-modal="true" aria-labelledby="testEmailDialogTitle" aria-hidden="true" tabindex="-1">
  <div class="dialog__backdrop" data-stisla-dialog-dismiss></div>
  <div class="dialog__panel">
    <div class="dialog__content">
      <div class="dialog__header">
        <h3 class="dialog__title" id="testEmailDialogTitle">Test Kirim Email</h3>
        <button type="button" class="dialog__close" aria-label="Tutup" data-stisla-dialog-dismiss>
          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" aria-hidden="true">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M6 6l12 12M18 6L6 18" />
          </svg>
        </button>
      </div>
      <div class="dialog__body">
        <p class="text-muted-foreground text-sm mb-4">Kirim email percobaan menggunakan konfigurasi SMTP yang sudah disimpan.</p>

        <div id="testEmailResult" class="hidden"></div>

        <div class="flex flex-col gap-3">
          <div class="field">
            <label for="test_email_to" class="field__label">Alamat Email Tujuan <span class="text-danger">*</span></label>
            <input type="email" class="input" id="test_email_to" placeholder="contoh@email.com" required>
          </div>
          <div class="field">
            <label for="test_email_subject" class="field__label">Subjek</label>
            <input type="text" class="input" id="test_email_subject" value="Test Email - <?= esc(setting('App.siteName') ?? 'CI4 Shield RBAC') ?>">
          </div>
          <div class="field">
            <label for="test_email_message" class="field__label">Pesan</label>
            <textarea class="input" id="test_email_message" rows="3">Ini adalah email percobaan dari <?= esc(setting('App.siteName') ?? 'CI4 Shield RBAC') ?>. Jika Anda menerima email ini, konfigurasi SMTP sudah benar.</textarea>
          </div>
        </div>
      </div>
      <div class="dialog__footer">
        <button type="button" class="btn btn-outline" data-stisla-dialog-dismiss>Batal</button>
        <button type="button" class="btn btn-primary" id="btnSendTestEmail">Kirim</button>
      </div>
    </div>
  </div>
</div>

<script>
  (function() {
    var tabs = document.getElementById('settingsTabs');
    if (!tabs) return;

    var buttons = document.querySelectorAll('[data-stisla-tabs-value][aria-controls="settingsTabs"]');
    var panels = tabs.querySelectorAll('.tabs__panel[data-value]');

    function activateTab(value) {
      var selectedButton = Array.prototype.find.call(buttons, function(button) {
        return button.dataset.stislaTabsValue === value;
      });
      if (!selectedButton) selectedButton = buttons[0];
      if (!selectedButton) return;

      value = selectedButton.dataset.stislaTabsValue;
      buttons.forEach(function(button) {
        var isSelected = button === selectedButton;
        button.classList.toggle('active', isSelected);
        button.setAttribute('aria-pressed', isSelected ? 'true' : 'false');
      });
      panels.forEach(function(panel) {
        panel.dataset.state = panel.dataset.value === value ? 'active' : 'inactive';
      });
    }

    buttons.forEach(function(button) {
      button.addEventListener('click', function() {
        var value = button.dataset.stislaTabsValue;
        activateTab(value);

        var url = new URL(window.location.href);
        url.searchParams.set('tab', value);
        window.history.pushState({ tab: value }, '', url);
      });
    });

    window.addEventListener('popstate', function() {
      activateTab(new URL(window.location.href).searchParams.get('tab'));
    });

    activateTab(new URL(window.location.href).searchParams.get('tab') || <?= json_encode($activeTab) ?>);
  })();

  function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) { document.getElementById(previewId).src = e.target.result; };
      reader.readAsDataURL(input.files[0]);
    }
  }

  function updatePreview() {
    var start = document.getElementById('auth_aside_start') ? document.getElementById('auth_aside_start').value : '#2f3f63';
    var end = document.getElementById('auth_aside_end') ? document.getElementById('auth_aside_end').value : '#1b2338';
    var preview = document.getElementById('preview-auth-aside');
    if (preview) {
      preview.style.background = 'linear-gradient(160deg, ' + start + ' 0%, ' + end + ' 55%)';
    }
  }

  function toggleSmtp() {
    var proto = document.getElementById('mail_protocol').value;
    var smtp = document.getElementById('smtp-settings');
    if (smtp) smtp.style.display = proto === 'smtp' ? '' : 'none';
  }

  function openTestEmail() {
    var dialog = document.getElementById('testEmailDialog');
    if (!dialog) return;
    var resultDiv = document.getElementById('testEmailResult');
    var btn = document.getElementById('btnSendTestEmail');
    if (resultDiv) {
      resultDiv.className = 'hidden';
      resultDiv.textContent = '';
    }
    if (btn) {
      btn.disabled = false;
      btn.textContent = 'Kirim';
    }
    dialog.dataset.state = 'open';
    dialog.setAttribute('aria-hidden', 'false');
  }

  function closeTestEmail() {
    var dialog = document.getElementById('testEmailDialog');
    if (dialog) {
      dialog.dataset.state = 'closed';
      dialog.setAttribute('aria-hidden', 'true');
    }
  }

  document.querySelectorAll('[data-stisla-dialog-dismiss]').forEach(function(el) {
    el.addEventListener('click', closeTestEmail);
  });

  document.getElementById('btnSendTestEmail').addEventListener('click', function() {
    var btn = this;
    var resultDiv = document.getElementById('testEmailResult');
    var emailTo = document.getElementById('test_email_to').value.trim();
    var subject = document.getElementById('test_email_subject').value.trim();
    var message = document.getElementById('test_email_message').value.trim();

    if (!emailTo) {
      resultDiv.className = 'mb-3 p-3 rounded text-sm';
      resultDiv.style.background = 'var(--color-warning-subtle, #fff3cd)';
      resultDiv.style.color = 'var(--color-warning, #856404)';
      resultDiv.textContent = 'Alamat email tujuan wajib diisi.';
      resultDiv.classList.remove('hidden');
      return;
    }

    btn.disabled = true;
    btn.textContent = 'Mengirim...';
    resultDiv.classList.add('hidden');

    fetch('<?= base_url('admin/settings/test-email') ?>', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        '<?= csrf_header() ?>': '<?= csrf_hash() ?>'
      },
      body: JSON.stringify({ email: emailTo, subject: subject, message: message })
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
      resultDiv.classList.remove('hidden');
      resultDiv.className = 'mb-3 p-3 rounded text-sm';
      if (data.success) {
        resultDiv.style.background = 'var(--color-success-subtle, #d4edda)';
        resultDiv.style.color = 'var(--color-success, #155724)';
      } else {
        resultDiv.style.background = 'var(--color-danger-subtle, #f8d7da)';
        resultDiv.style.color = 'var(--color-danger, #721c24)';
      }
      resultDiv.textContent = data.message;
    })
    .catch(function() {
      resultDiv.classList.remove('hidden');
      resultDiv.className = 'mb-3 p-3 rounded text-sm';
      resultDiv.style.background = 'var(--color-danger-subtle, #f8d7da)';
      resultDiv.style.color = 'var(--color-danger, #721c24)';
      resultDiv.textContent = 'Terjadi kesalahan saat mengirim email.';
    })
    .finally(function() {
      btn.disabled = false;
      btn.textContent = 'Kirim';
    });
  });

  toggleSmtp();
</script>
