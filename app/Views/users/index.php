<?php
$avatarColors = ['var(--primary)', 'var(--azure)', 'var(--purple)', 'var(--yellow)', 'var(--green)', 'var(--blue)', 'var(--red)'];
?>
<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Semua user</div>
      <div class="card-subtitle">Daftar akun beserta role dan status aktifnya.</div>
    </div>
    <form method="get" action="<?= base_url('admin/users') ?>" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
      <input type="search" name="q" class="form-control" style="width:200px" placeholder="Cari username atau email"
             value="<?= esc($filters['q'] ?? '', 'attr') ?>" aria-label="Cari user">
      <select name="role" class="form-control" style="width:150px" aria-label="Filter role">
        <option value="">Semua role</option>
        <?php foreach (($roles ?? []) as $roleName => $roleConfig): ?>
        <option value="<?= esc($roleName, 'attr') ?>" <?= ($filters['role'] ?? '') === $roleName ? 'selected' : '' ?>>
          <?= esc($roleConfig['title'] ?? ucfirst($roleName)) ?>
        </option>
        <?php endforeach; ?>
      </select>
      <select name="status" class="form-control" style="width:140px" aria-label="Filter status">
        <option value="">Semua status</option>
        <option value="active" <?= ($filters['status'] ?? '') === 'active' ? 'selected' : '' ?>>Aktif</option>
        <option value="inactive" <?= ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Nonaktif</option>
      </select>
      <button type="submit" class="btn btn-outline">
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="7" cy="7" r="4.5" /><path d="M10.5 10.5L14 14" /></svg>
        Filter
      </button>
      <?php if (!empty(array_filter($filters ?? []))): ?>
      <a href="<?= base_url('admin/users') ?>" class="btn btn-outline">Reset</a>
      <?php endif; ?>
    </form>
  </div>

  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th style="width:48px">#</th>
          <th>Username</th>
          <th>Email</th>
          <th>Role</th>
          <th>Status</th>
          <th style="width:56px;text-align:right"></th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($users)): ?>
          <?php $no = isset($pager) ? (($pager->getCurrentPage() - 1) * $pager->getPerPage()) + 1 : 1; ?>
          <?php foreach ($users as $index => $user): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td>
              <div class="cell-customer">
                <div class="cell-avatar" style="background:<?= $avatarColors[$index % count($avatarColors)] ?>">
                  <?= esc(strtoupper(substr($user->username, 0, 2))) ?>
                </div>
                <span class="cell-strong"><?= esc($user->username) ?></span>
              </div>
            </td>
            <td><?= esc($user->email) ?></td>
            <td>
              <?php if (!empty($user->groups)): ?>
                <?php foreach ($user->groups as $group): ?>
                  <?php
                    $chipClass = match ($group) {
                        'superadmin' => 'chip chip-red',
                        'admin'      => 'chip chip-yellow',
                        'manager'    => 'chip chip-blue',
                        default      => 'chip',
                    };
                  ?>
                  <span class="<?= $chipClass ?>"><?= esc(ucfirst($group)) ?></span>
                <?php endforeach; ?>
              <?php else: ?>
                <span class="chip">No Role</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if ($user->active): ?>
                <span class="status status-green">Aktif</span>
              <?php else: ?>
                <span class="status status-red">Nonaktif</span>
              <?php endif; ?>
            </td>
            <td style="text-align:right">
              <?php
                $canEdit   = activeGroupCan('users.edit');
                $canDelete = activeGroupCan('users.delete') && (int) $user->id !== (int) auth()->id();
              ?>
              <?php if ($canEdit || $canDelete): ?>
              <button type="button" class="card-opt-btn" style="display:inline-flex"
                      data-user-menu
                      aria-haspopup="menu" aria-expanded="false"
                      aria-label="Aksi untuk <?= esc($user->username, 'attr') ?>"
                      data-username="<?= esc($user->username, 'attr') ?>"
                      <?= $canEdit ? 'data-edit-url="' . base_url('admin/users/edit/' . $user->id) . '"' : '' ?>
                      <?= $canDelete ? 'data-delete-form="delete-user-' . $user->id . '"' : '' ?>>
                <svg viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><circle cx="3" cy="8" r="1.4" /><circle cx="8" cy="8" r="1.4" /><circle cx="13" cy="8" r="1.4" /></svg>
              </button>
              <?php endif; ?>
              <?php if ($canDelete): ?>
              <form id="delete-user-<?= $user->id ?>" action="<?= base_url('admin/users/delete/' . $user->id) ?>" method="post" hidden>
                <?= csrf_field() ?>
              </form>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" style="text-align:center;padding:32px 0;color:var(--text-muted)">Tidak ada user yang cocok dengan filter.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php if (isset($pager) && !empty($users)): ?>
    <?= $pager->only(['q', 'status', 'role'])->links('default', 'gentelella') ?>
  <?php endif; ?>
</div>

<script>
(function () {
  var menu = null;
  var trigger = null;

  function close() {
    if (menu) { menu.remove(); menu = null; }
    if (trigger) { trigger.setAttribute('aria-expanded', 'false'); trigger = null; }
  }

  function createItem(label, action) {
    var item = document.createElement('button');
    item.type = 'button';
    item.className = 'menu-item';
    item.setAttribute('role', 'menuitem');
    item.textContent = label;
    item.addEventListener('click', function () {
      close();
      action();
    });
    return item;
  }

  function open(btn) {
    var popover = document.createElement('div');
    popover.className = 'menu-popover';
    popover.setAttribute('role', 'menu');

    if (btn.dataset.editUrl) {
      popover.appendChild(createItem('Edit', function () {
        window.location.href = btn.dataset.editUrl;
      }));
    }

    if (btn.dataset.deleteForm) {
      if (popover.childElementCount) {
        var separator = document.createElement('div');
        separator.className = 'menu-separator';
        popover.appendChild(separator);
      }
      popover.appendChild(createItem('Hapus', function () {
        var form = document.getElementById(btn.dataset.deleteForm);
        if (!form) { return; }

        var message = document.createElement('p');
        message.textContent = 'User "' + btn.dataset.username + '" akan dihapus. Tindakan ini tidak dapat dibatalkan.';
        message.style.cssText = 'font-size:13px;color:var(--text-secondary);line-height:1.6;margin:0';

        import(<?= json_encode(base_url('gentelella/js/main-v4-CmWkxJuV.js')) ?>).then(function (ui) {
          ui.r({
            title: 'Hapus user?',
            size: 'sm',
            body: message,
            actions: [
              { label: 'Batal', variant: 'ghost' },
              { label: 'Hapus user', variant: 'danger', action: function () { form.submit(); } }
            ]
          });
        });
      }));
    }

    if (!popover.childElementCount) { return; }

    popover.style.visibility = 'hidden';
    document.body.appendChild(popover);

    var rect = btn.getBoundingClientRect();
    var top = rect.bottom + 6;
    var left = rect.right - popover.offsetWidth;
    if (top + popover.offsetHeight > window.innerHeight - 8) {
      top = rect.top - popover.offsetHeight - 6;
    }
    left = Math.max(8, Math.min(left, window.innerWidth - popover.offsetWidth - 8));
    popover.style.top = Math.round(top) + 'px';
    popover.style.left = Math.round(left) + 'px';
    popover.style.visibility = '';

    menu = popover;
    trigger = btn;
    btn.setAttribute('aria-expanded', 'true');
    popover.querySelector('.menu-item').focus();
  }

  document.addEventListener('click', function (event) {
    var btn = event.target.closest('[data-user-menu]');
    if (!btn) {
      if (menu && !menu.contains(event.target)) { close(); }
      return;
    }
    event.preventDefault();
    var wasOpen = trigger === btn;
    close();
    if (!wasOpen) { open(btn); }
  });

  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') { close(); }
  });
  window.addEventListener('resize', close);
  window.addEventListener('scroll', close, true);
})();
</script>

