<?php
require 'model/Jojo.php';
$cards = Jojo::getCards();
?>

<!doctype html>
<html>
	<head>
		<title>Jojo-kort</title>
		<meta charset="UTF-8">
		<link rel="icon" href="jojo.png">
		<link rel="stylesheet" href="jojo.css">
	</head>
	<body>
		<header class="container">
			<h1>Jojo-kort</h1>
		</header>
		<main class="container">
			<div id="cards">
				<?php foreach($cards as $card): ?>
				<form method="POST" action="http://www.shop.skanetrafiken.se/ladda.html">
					<input type="hidden" name="FROMKOLLA" value="1">
					<input type="hidden" name="cardno" value="<?=$card->getCardNumber();?>">
					<input type="hidden" name="backno" value="<?=$card->getBackNumber();?>">
					<button type="submit" class="card">
						<h2 class="name"><?=$card->getName();?></h2>
						<p class="number"><?=$card->getCardNumber();?></p>
						<?php if ($card->getBalance() !== FALSE): ?>
						<p class="balance"><?=$card->getBalance();?></p>
						<?php else: ?>
						<p class="error"><span class="x">❌</span> Ogiltigt kort</p>
						<?php endif; ?>
					</button>
				</form>
				<?php endforeach; ?>
				<span class="stretch"></span>
			</div>
		</main>
		<footer class="container">
			<div id="author">
				<p>© Robin Gustafsson</p>
				<a href="https://github.com/rgson/jojo">View on GitHub</a>
			</div>
		</footer>
	</body>
</html>