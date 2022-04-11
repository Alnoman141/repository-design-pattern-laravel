<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    private $userService;

    /**
     * UserController constractor
     * @param $userService
    */

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // example of how find all params have to given
        // $this->userService->findAll(10, ['relation1, relation2'], ['column' => 'id', 'direction' => 'desc'])
        $users = $this->userService->findAll(10, null, ['column' => 'id', 'direction' => 'desc']);
        return view('welcome', compact('users', $users));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $response = $this->userService->store($request->all());
        Session::flash('message', $response->getContent());
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->userService->findOrFail($id);
        return view('edit', compact('user', $user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = $this->userService->updateUser($id, $request->all());
        Session::flash('message', 'User has been updated');
        return redirect()->route('user.list');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response =  $this->userService->destroy($id);
        Session::flash('message', $response->getContent());
        return redirect('/');
    }
}
