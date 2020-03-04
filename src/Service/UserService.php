<?php
namespace Blogs\Service;

include "../vendor/autoload.php";

class UserService {
  private $collection;

  public function __construct($collection){
    $this->collection=$collection;
  }

  public function register(string $userId, string $password) {
    $user = $this->getUser($userId);
    if($user instanceof \Blogs\Models\UserNull){
        $usuarios= array();
        $usuarios['userId']= $userId;
        $usuarios['password']=$password;
        $var=md5($userId);
        $numero=0;
        for($i=0;$i<strlen($var);$i++){
            $numero+=ord($var[$i]);
        }
        $db=$numero%count($this->collection);
        $this->collection[$db]->insertOne($usuarios);
        return true;
    } else {
        return false;
    }
  }

  public function getUser($userId){
    $var=md5($userId);
    $numero=0;
    for($i=0;$i<strlen($var);$i++){
        $numero+=ord($var[$i]);
    }
    $db=$numero%count($this->collection);
    $cursor= $this->collection[$db]->findOne(['userId'=> $userId]);
    
    if (is_null($cursor)){
        $user = new \Blogs\Models\UserNull('','','');
        return $user;
    }
    $user = new \Blogs\Models\User($cursor['userId'],$cursor['name'], $cursor['password']);
    return $user;
  }
}
