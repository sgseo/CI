<?php
class People{
    private $name;
    private $age;
    private $hobby;

    public function __construct($name,$age,$hobby)
    {
        $this->name=$name;
        $this->age=$age;
        $this->hobby=$hobby;
    }

    public function say()
    {
         echo "my name is ".$this->name.' and '.$this->age.' sui '.'and hobby is '.$this->hobby;
    }
}
//创建以个student 集成 people
class Student extends People{
    public $grade='7';

    public function __construct($grade)
    {
        parent::__construct();
        $this->grade=$grade;
    }

    function say()
    {
        parent::say();
        echo 'my grade is '.$this->grade;
    }
    function study()
    {
        echo  "my name is ".$this->name." i'm in grade ".$this->grade;
    }
}

 $s=new Student('yee','24',7,'fuckpig');

 $s->say();
