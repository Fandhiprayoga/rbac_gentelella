<?php
/**
 * Pager template mengikuti komponen pagination Gentelella v4 (.pagination > .page-btn).
 *
 * @var CodeIgniter\Pager\PagerRenderer $pager
 */
$pager->setSurroundCount(2);

$total = (int) $pager->getTotal();
$from  = $total > 0 ? (int) $pager->getPerPageStart() : 0;
$to    = $total > 0 ? (int) $pager->getPerPageEnd() : 0;
?>
<nav class="pagination" aria-label="Navigasi halaman">
  <span class="page-info">Showing <?= $from ?>&ndash;<?= $to ?> of <?= $total ?></span>

  <div class="page-btns" style="display:inline-flex;align-items:center;gap:var(--space-1)">
  <?php if ($pager->hasPrevious()): ?>
    <a class="page-btn" href="<?= $pager->getPrevious() ?>" aria-label="Sebelumnya">
      <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M10 4l-4 4 4 4" /></svg>
    </a>
  <?php else: ?>
    <button type="button" class="page-btn" disabled aria-label="Sebelumnya">
      <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M10 4l-4 4 4 4" /></svg>
    </button>
  <?php endif; ?>

  <?php if ($pager->hasPreviousPage()): ?>
    <a class="page-btn" href="<?= $pager->getFirst() ?>"><?= $pager->getFirstPageNumber() ?></a>
    <span class="page-ellipsis">&hellip;</span>
  <?php endif; ?>

  <?php foreach ($pager->links() as $link): ?>
    <a class="page-btn <?= $link['active'] ? 'active' : '' ?>" href="<?= $link['uri'] ?>"
       <?= $link['active'] ? 'aria-current="page"' : '' ?>><?= $link['title'] ?></a>
  <?php endforeach; ?>

  <?php if ($pager->hasNextPage()): ?>
    <span class="page-ellipsis">&hellip;</span>
    <a class="page-btn" href="<?= $pager->getLast() ?>"><?= $pager->getLastPageNumber() ?></a>
  <?php endif; ?>

  <?php if ($pager->hasNext()): ?>
    <a class="page-btn" href="<?= $pager->getNext() ?>" aria-label="Berikutnya">
      <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M6 4l4 4-4 4" /></svg>
    </a>
  <?php else: ?>
    <button type="button" class="page-btn" disabled aria-label="Berikutnya">
      <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M6 4l4 4-4 4" /></svg>
    </button>
  <?php endif; ?>
  </div>
</nav>
