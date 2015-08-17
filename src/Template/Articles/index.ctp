<h1>Blog Articles</h1>
<p><?= $this->Html->link('Add Article', ['controller' => 'Articles', 'action' => 'add']) ?></p>
<table>
	<tr>
		<th>Id</th>
		<th>Title</th>
		<th>Created</th>
		<th>Actions</th>
	</tr>
	<?php foreach($articles as $article): ?>
	<tr>
		<td><?= $article->id ?></td>
		<td><?= $this->Html->link($article->title, ['action' => 'view', $article->id]) ?></td>
		<td><?= $article->created->format(DATE_RFC850) ?></td>
		<td>
			<?= $this->Form->postLink('Delete', ['action' => 'delete', $article->id], ['confirm' => 'Are you sure?']) ?>
			<?= $this->Html->link('Edit', ['action' => 'edit', $article->id]) ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>