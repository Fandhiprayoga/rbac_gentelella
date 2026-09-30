<?php if (activeGroupCan('users.create')): ?>
<a href="<?= base_url('admin/users/create') ?>" class="btn btn-primary">
  <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M4 8h8M8 4v8" /></svg>
  Tambah User
</a>
<?php endif; ?>
