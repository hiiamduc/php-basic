<?php
trait classA 
{
	public function hello()
	{
		echo "chao a";
	}
	public function test()
	{
		echo "test";
	}
}
trait classB
{
	public function hello()
	{
		echo "kdasld";
	}
	public function abc()
	{
		echo "adad";
	}
}

class my_class
{
	use classA,classB,duc
	{
		classA::hello insteadof classB;
		classA::test insteadof classB;
	}
}

$a = new my_class();
$a->test();
echo "<br/>";
$a->abc();
echo "<br/>";
$a->duc();
