<?php

require 'do_post_request.php';

class Jojo {

	private $name;
	private $cardno;
	private $backno;
	private $balance; 

	private function __construct($name, $cardno, $backno) {
		$this->name = $name;
		$this->cardno = $cardno;
		$this->backno = $backno;
	}

	public static function getCards() {
		$data = file_get_contents('model/jojo.json');
		$json = json_decode($data);
		
		$cards = array();
		foreach ($json->cards as $c) {
			$cards[] = new Jojo(
				$c->name,
				$c->cardno,
				$c->backno
			);
		}
		return $cards;
	}

	public function getName() {
		return $this->name;
	}

	public function getCardNumber() {
		return $this->cardno;
	}

	public function getBackNumber() {
		return $this->backno;
	}

	public function getBalance() {
		if ($this->balance === NULL)
			$this->balance = $this->fetchBalance();
		return $this->balance;
	}

	private function fetchBalance() {
		$url = 'http://www.shop.skanetrafiken.se/kollasaldo.html';
		$data = array(
			'cardno' => $this->cardno, 
			'backno' => $this->backno, 
			'ST_CHECK_SALDO' => 'Se saldo'
		);
		$page = do_post_request($url, $data);

		libxml_use_internal_errors(true);
		$dom = new DOMDocument();
		$dom->loadHTML($page);
		libxml_clear_errors();

		$xpath = new DOMXPath($dom);
		$balanceNode = $xpath->query("//td[@class='greenrow right']/h3")->item(0);
		
		if ($balanceNode !== NULL)
			return $balanceNode->nodeValue;
		return FALSE;
	}
}

?>