<?php
/*
* To implement in admingroups permissions
* to remove CRUD from Validation remove route name
* CRUD Role permission (create,read,update,delete)
* [it v 1.6.40]
*/
return [
	"products"=>["create","read","update","delete"],
	"categories"=>["create","read","update","delete"],
	""=>["create","read","update","delete"],
	"card"=>["create","read","update","delete"],
	"admins"=>["create","read","update","delete"],
	"admingroups"=>["create","read","update","delete"],
];