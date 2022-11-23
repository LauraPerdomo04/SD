<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;

class UserRepository extends BaseRepository
{
    protected $modelBase;

    public function __construct(User $modelo)
    {
        $this->modelBase = new BaseRepository($modelo);
        parent::__construct($modelo);
    }

    public function login(Request $request)
    {
        return $this->model->where('email', $request->email)->orWhere('tel', $request->email)->first();
    }
}
