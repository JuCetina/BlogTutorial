<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Category'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="categories index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th>id</th>
            <th>Parent Id</th>
            <th>Title</th>
            <th>Lft</th>
            <th>Rght</th>
            <th>Name</th>
            <th>Description</th>
            <th>Created</th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($categories as $category): ?>
        <tr>
            <td><?= $this->Number->format($category->id) ?></td>
            <td><?= $this->Number->format($category->parent_id) ?></td>
            <td><?= $this->Number->format($category->lft) ?></td>
            <td><?= $this->Number->format($category->rght) ?></td>
            <td><?= h($category->name) ?></td>
            <td><?= h($category->description) ?></td>
            <td><?= h($category->created) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $category->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $category->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id)]) ?>
                <?= $this->Form->postLink(__('Move down'), ['action' => 'move_down', $category->id], ['confirm' => __('Are you sure you want to move down # {0}?', $category->id)]) ?>
                <?= $this->Form->postLink(__('Move up'), ['action' => 'move_up', $category->id], ['confirm' => __('Are you sure you want to move up # {0}?', $category->id)]) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
</div>