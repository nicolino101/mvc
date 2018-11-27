<?php 


use App\Models\User;


$user = new User();
$user->setFirstName('Nick');
$fname = $user->getFirstName();
$user->setLastName('Roma');
$lname = $user->getLastName();
$user->setEmail('nicolino@gmail.com');
$email = $user->getEmail();
echo '<pre>';
var_dump($user, $fname, $lname, $email);