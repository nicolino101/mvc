<?php 

use App\Models\User;

$user = new User();
$user->setFirstName('Nick');
$fname = $user->getFirstName();
$user->setLastName('Roma');
$lname = $user->getLastName();

var_dump($user, $fname, $lname); 