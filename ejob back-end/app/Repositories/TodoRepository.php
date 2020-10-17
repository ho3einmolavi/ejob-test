<?php


namespace App\Repositories;


use App\Models\Todo;
use App\Models\User;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class TodoRepository extends BaseRepository implements TodoRepositoryInterface
{
    public function __construct(Todo $model)
    {
        parent::__construct($model);
    }

    public function checkUserTodo(Todo $todo, User $user)
    {
        if ($todo->user_id != $user->id) {
            return false;
        }
        return true;
    }

    public function userTodos(User $user , $sort)
    {
        return $user->todos()->orderBy('id' , $sort)->get();
    }

    public function search($title , $user_id = 0)
    {
        if ($user_id == 0)
        {
            return $this->model->query()->where('title' , 'LIKE' , '%'.$title.'%')->get();
        }
        return $this->model->query()->where('user_id' , $user_id)
            ->where('title' , 'LIKE' , '%'.$title.'%')->get();
    }
}
