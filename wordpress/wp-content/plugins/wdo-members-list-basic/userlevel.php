<?php

if ($memberlist['meta_value'] == 0){
$userlevel = 'Subscriber';
}
if ($memberlist['meta_value'] == 1){
$userlevel = 'Contributor';
}
if ($memberlist['meta_value'] == 2 || $memberlist['meta_value'] == 3 || $memberlist['meta_value'] == 4){
$userlevel = 'Author';
}
if ($memberlist['meta_value'] == 5 || $memberlist['meta_value'] == 6 || $memberlist['meta_value'] == 7){
$userlevel = 'Editor';
}
if ($memberlist['meta_value'] == 8 || $memberlist['meta_value'] == 9 || $memberlist['meta_value'] == '10'){
$userlevel = 'Administrator';
}

if ($searchres['meta_value'] == 0){
$userlevel2 = 'Subscriber';
}
if ($searchres['meta_value'] == 1){
$userlevel2 = 'Contributor';
}
if ($searchres['meta_value'] == 2 || $searchres['meta_value'] == 3 || $searchres['meta_value'] == 4){
$userlevel2 = 'Author';
}
if ($searchres['meta_value'] == 5 || $searchres['meta_value'] == 6 || $searchres['meta_value'] == 7){
$userlevel2 = 'Editor';
}
if ($searchres['meta_value'] == 8 || $searchres['meta_value'] == 9 || $searchres['meta_value'] == '10'){
$userlevel2 = 'Administrator';
}

?>