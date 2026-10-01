<?php
$user = $user ?? auth()->user();
$userGroups = $userGroups ?? $user->getGroups();
$userCount = $userCount ?? null;
$roleCount = $roleCount ?? count(config('AuthGroups')->groups);
$permissionCount = $permissionCount ?? count(config('AuthGroups')->permissions);
$roleName = $groupTitle ?? activeGroupTitle();
$groupTitles = array_map(
    static fn (string $group): string => config('AuthGroups')->groups[$group]['title'] ?? ucfirst($group),
    $userGroups
);
?>
<div class="dashboard-overview">
  <section class="dashboard-intro" aria-label="Selamat datang">
    <div>
      <div class="dashboard-eyebrow">Ruang kerja Anda</div>
      <h2>Selamat datang, <?= esc($user->username) ?></h2>
      <p>Semua yang Anda perlukan untuk mengelola akun dan akses ada di satu tempat.</p>
    </div>
  </section>

  <section class="row col-4 dashboard-kpis" aria-label="Ringkasan sistem">
    <article class="card dashboard-metric">
      <div class="card-header"><div><div class="card-title">Pengguna</div><div class="card-subtitle"><?= $userCount !== null ? 'Akun terdaftar' : 'Akun Anda' ?></div></div><span class="dashboard-metric-icon teal" aria-hidden="true">U</span></div>
      <div class="card-body"><div class="dashboard-metric-value"><?= $userCount !== null ? number_format($userCount) : '1' ?></div><div class="dashboard-metric-note"><?= $userCount !== null ? 'di seluruh sistem' : 'status akun aktif' ?></div></div>
    </article>
    <article class="card dashboard-metric">
      <div class="card-header"><div><div class="card-title">Role tersedia</div><div class="card-subtitle">Role terkonfigurasi</div></div><span class="dashboard-metric-icon blue" aria-hidden="true">R</span></div>
      <div class="card-body"><div class="dashboard-metric-value"><?= number_format($roleCount) ?></div><div class="dashboard-metric-note">termasuk <?= esc($roleName) ?></div></div>
    </article>
    <article class="card dashboard-metric">
      <div class="card-header"><div><div class="card-title">Permission</div><div class="card-subtitle">Aturan akses sistem</div></div><span class="dashboard-metric-icon yellow" aria-hidden="true">P</span></div>
      <div class="card-body"><div class="dashboard-metric-value"><?= number_format($permissionCount) ?></div><div class="dashboard-metric-note">terdefinisi</div></div>
    </article>
    <article class="card dashboard-metric">
      <div class="card-header"><div><div class="card-title">Keanggotaan</div><div class="card-subtitle">Role pada akun Anda</div></div><span class="dashboard-metric-icon green" aria-hidden="true">+</span></div>
      <div class="card-body"><div class="dashboard-metric-value"><?= number_format(count($userGroups)) ?></div><div class="dashboard-metric-note">role dapat digunakan</div></div>
    </article>
  </section>

  <section class="row col-8-4 dashboard-details" aria-label="Informasi akun dan akses">
    <article class="card">
      <div class="card-header"><div><h2 class="card-title">Informasi akun</h2><div class="card-subtitle">Detail akun yang sedang digunakan</div></div><a class="btn btn-outline btn-sm" href="<?= base_url('profile') ?>">Buka profil</a></div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table dashboard-account-table">
            <tbody>
              <tr><th scope="row">Nama pengguna</th><td><?= esc($user->username) ?></td></tr>
              <tr><th scope="row">Email</th><td><?= esc($user->email) ?></td></tr>
              <tr><th scope="row">Role aktif</th><td><span class="status status-blue"><?= esc($roleName) ?></span></td></tr>
              <tr><th scope="row">Keanggotaan</th><td class="dashboard-memberships"><?php foreach ($groupTitles as $groupTitle): ?><span class="dashboard-membership <?= $groupTitle === $roleName ? 'is-active' : '' ?>"><?= esc($groupTitle) ?></span><?php endforeach; ?></td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </article>

    <article class="card">
      <div class="card-header"><div><h2 class="card-title">Akses cepat</h2><div class="card-subtitle">Modul untuk role aktif</div></div></div>
      <div class="card-body quick-links">
        <?php if (activeGroupCan('users.list')): ?>
        <a href="<?= base_url('admin/users') ?>"><span class="quick-link-icon teal" aria-hidden="true">U</span><span><strong>Manajemen user</strong><small>Kelola akun pengguna</small></span><span aria-hidden="true">›</span></a>
        <?php endif; ?>
        <?php if (activeGroupIs('superadmin')): ?>
        <a href="<?= base_url('admin/roles') ?>"><span class="quick-link-icon blue" aria-hidden="true">R</span><span><strong>Role &amp; permission</strong><small>Atur akses sistem</small></span><span aria-hidden="true">›</span></a>
        <?php endif; ?>
        <?php if (activeGroupCan('admin.settings')): ?>
        <a href="<?= base_url('admin/settings') ?>"><span class="quick-link-icon yellow" aria-hidden="true">S</span><span><strong>Pengaturan</strong><small>Konfigurasi aplikasi</small></span><span aria-hidden="true">›</span></a>
        <?php endif; ?>
        <a href="<?= base_url('profile') ?>"><span class="quick-link-icon green" aria-hidden="true">P</span><span><strong>Profil saya</strong><small>Perbarui informasi akun</small></span><span aria-hidden="true">›</span></a>
      </div>
    </article>
  </section>
</div>