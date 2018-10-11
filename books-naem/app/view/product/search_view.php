<ul>
	<?php foreach ($data['lstPd'] as $key => $item): ?>
		<li style="list-style-image: url('public/upload/image/search.png');">
			<a href="?c=product&m=detail&id=<?= $item['id']?>">
				<img src="<?= PATH_IMAGE.$item['image_pd']; ?>" alt="product" width="45" height="45">
				<span>|</span>
				<span><?= $item['name_pd']; ?></span>				
			</a>
		</li>
	<?php endforeach; ?>
</ul>
