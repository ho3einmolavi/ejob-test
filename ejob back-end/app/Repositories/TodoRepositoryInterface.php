<?php


namespace App\Repositories;


use App\Models\Todo;
use App\Models\User;

interface TodoRepositoryInterface
{
    /**
     * @param Todo $todo
     * @param User $user
     * @return mixed
     */
    public function checkUserTodo(Todo $todo , User $user);

    /**
     * @param User $user
     * @param $sort
     * @return mixed
     */
    public function userTodos(User $user , $sort);

    /**
     * @param $title
     * @param $user_id
     * @return mixed
     */
    public function search($title , $user_id = 0);
}
