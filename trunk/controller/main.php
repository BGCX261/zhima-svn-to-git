<?php
class Person {
	var $m_hp	  = 200;			// 血量
	var $m_attack = array(0, 0);	// 攻击上限下限
	var $m_object;					// 人物的攻击目标
	/**
	 * 构造一个任务
	 *
	 * @param 血量 $hp
	 * @param 攻击力 $attack
	 */
	function __construct($hp = 0, $attack = array(0, 0)) {
		$this->m_hp		= $hp;
		$this->m_attack = $attack;
	}
	
	/**
	 * 设置当前人物的攻击目标
	 *
	 * @param unknown_type $obj
	 */
	function setAttackObject($obj = 0) {
		$this->m_object = $obj;
	}
	
	/**
	 * 受到伤害
	 *
	 * @param 减少相应的血量 $hp
	 */
	function Hurt($hp = 0) {
		$this->m_hp -= $hp;
		if ($this->m_hp < 0) {
			$this->m_hp = 0;
		}
	}
	
	/**
	 * 人物是否死亡
	 *
	 * @return 死亡返回true，否则返回false
	 */
	public function isDeath() {
		return $this->m_hp == 0;
	}
}

class Game {
	var $m_p1;
	var $m_p2;
	
	/**
	 * 战斗系统，两个人对战
	 *
	 * @param 人物1 $p1
	 * @param 人物2 $p2
	 */
	function Init($p1 = 0, $p2 = 0) {
		$this->m_p1 = $p1;
		$this->m_p2 = $p2;
	}
	
	function Attack() {
		
	}
	/**
	 * 两个人对战过程
	 *
	 */
	function Fight() {
		$damage = array();
		while (!$this->m_p1->isDeath() && !$this->m_p2->isDeath()) {
			$v = rand($this->m_p2->m_attack[0], $this->m_p2->m_attack[1]);
			$damage[] = array('type' => 'r', 'value' => $v);
			$this->m_p1->Hurt($v);
			
			$v = rand($this->m_p1->m_attack[0], $this->m_p1->m_attack[1]);
			$damage[] = array('type' => 'l', 'value' => $v);
			$this->m_p2->Hurt($v);
		}
		return $damage;
	}
}
class main extends spController {
	function index(){
		$this->display('index.html');
	}
	
	function fight() {
		import('Fighter.php');
		$fighting = new Fighting();
		$fighting->Init();
		for ($i = 0; $i < 1; $i++) {
			$fighter = new Fighter();
			$fighter->hp = 200;
			$fighter->name = 'Red_1'.$i;
			$fighter->damage = array(50,100);
			$fighting->SetFighters($fighter, RED);
		}
		
		for ($i = 0; $i < 1; $i++) {
			$fighter = new Fighter();
			$fighter->hp = 100;
			$fighter->name = 'Blue_1'.$i;
			$fighting->SetFighters($fighter, BLUE);
		}
		$fighting->setFighterTarget(RED);
		$fighting->setFighterTarget(BLUE);
		
		$log = $fighting->teamFighting();
		echo json_encode($log);
	}
	
	function test() {
		$_SESSION['aaa'] = 'aa';
	}
	
	function arrTest() {
		import('Fighter.php');
		$redTeam = new FTeam();
		$blueTeam = new FTeam();
		for($i = 0; $i < 3; $i++) {
			$fighter = new Fighter();
			$fighter->hp = 50;
			$fighter->name = 'Red_'.$i;
			
			$redTeam->setFighter($fighter);
			$blueTeam->setFighter($fighter);
		}
		
		$redTeam->Death(1);
		$redTeam->output();
		print_r($redTeam->RandomTarget());
	}
}