<?php

namespace App\Http\Controllers;

use App\Events\TodoCreated;
use App\Http\Requests\Todo\CreateRequest;
use App\Http\Requests\Todo\IndexRequest;
use App\Http\Requests\Todo\UpdateRequest;
use App\Http\Resources\Todo\TodoCollection;
use App\Http\Resources\Todo\TodoResource;
use App\Models\Todo;
use App\Repositories\TodoRepositoryInterface;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    private $repository;

    public function __construct(TodoRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function search(Request $request)
    {
        if ($user = $request->user('api'))
        {
            $search_results = $this->repository->search($request->get('query') , $user->id);
        }
        else
        {
            $search_results = $this->repository->search($request->get('query'));
        }

        return _response(new TodoCollection($search_results));
    }

    public function index(IndexRequest $request)
    {
        $sort = $request->get('sort') == 1 ? 'desc' : 'asc';
        if ($request->has('my_todos') && $request->get('my_todos') == 1) {
            if ($user = $request->user('api')) {
                return _response(new TodoCollection($this->repository->userTodos($user , $sort)));
            }
            return _response('', 401, 'Unauthorized');
        } else {
            return _response(new TodoCollection($this->repository->get('id' , $sort , ['user'])));
        }
    }

    public function create(CreateRequest $request)
    {
        $user = auth()->user();
        $data = array_merge($request->validated(), ['user_id' => $user->id]);
        $todo = $this->repository->create($data);
        event(new TodoCreated($todo , $user));
        return _response(new TodoResource($todo) , 201);
    }

    public function update(Todo $todo, UpdateRequest $request)
    {
        if ($this->repository->checkUserTodo($todo, $request->user())) {
            $this->repository->update($todo, $request->validated());
            return _response(new TodoResource($todo));
        }
        return _response('', 403, 'you are not allowed to do this action');
    }

    public function delete(Todo $todo)
    {
        if ($this->repository->checkUserTodo($todo, auth()->user())) {
            $this->repository->delete($todo);
            return _response($todo, 200, 'item is deleted');
        }
        return _response('', 403, 'you are not allowed to do this action');
    }
}
