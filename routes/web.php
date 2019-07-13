<?php
/*
One-to-Many
*/
Route::get('one-to-many', 'OneToManyController@oneToMany');
Route::get('many-to-one', 'OneToManyController@manyToOne');
Route::get('one-to-many-insert', 'OneToManyController@oneToManyInsert');
/*
On-to-One
*/
Route::get('one-to-one', 'OneToOneController@oneToOne');
Route::get('one-to-one-inverse', 'OneToOneController@oneToOneInverse');
Route::get('one-to-one-insert', 'OneToOneController@oneToOneInsert');

/*
Has-Many-hrough
*/
Route::get('has-many-through', 'OneToManyController@hasManyThrough');

/*
POLYMORPHIC
*/
Route::get('polymorphic', 'PolymorphicController@polymorphic');
Route::get('polymorphic-insert', 'PolymorphicController@polymorphicInsert');

/*
Many-to-Many
*/

Route::get('many-to-many-insert', 'ManyToManyController@ManyToManyInsert');
Route::get('many-to-many', 'ManyToManyController@ManyToMany');
Route::get('many-to-many-inverse', 'ManyToManyController@ManyToManyInverse');









Route::get('/', function () {
    return view('welcome');
});
