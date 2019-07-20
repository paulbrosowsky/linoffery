<?php 

/**
 * Helper function to create database instace for testing
 */
function create($class, $attributes = [], $times = null)
{
	return factory($class, $times)->create($attributes);
}

/**
 * Helper function to make instace for testing (does not save it in DB)
 */
function make($class, $attributes = [], $times = null)
{
	return factory($class, $times)->make($attributes);
}
