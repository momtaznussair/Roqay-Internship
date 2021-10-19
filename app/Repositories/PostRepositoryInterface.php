<?php namespace App\Repositories;

interface PostRepositoryInterface{
	
	public function getAll();

	public  function createPost($request);

	public  function updatePost($request, $id);

	public  function deletePost($id);
}