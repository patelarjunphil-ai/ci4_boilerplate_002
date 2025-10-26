<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'users' => $this->userModel->findAll(),
        ];

        return view('admin/users/index', $data);
    }

    public function new()
    {
        return view('admin/users/new');
    }

    public function create()
    {
        if ($this->userModel->save($this->request->getPost())) {
            return redirect()->to('/admin/users')->with('message', 'User created successfully.');
        }

        return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
    }

    public function edit($id)
    {
        $data = [
            'user' => $this->userModel->find($id),
        ];

        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        if ($this->userModel->update($id, $this->request->getPost())) {
            return redirect()->to('/admin/users')->with('message', 'User updated successfully.');
        }

        return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
    }

    public function delete($id)
    {
        if ($this->userModel->delete($id)) {
            return redirect()->to('/admin/users')->with('message', 'User deleted successfully.');
        }

        return redirect()->back()->with('error', 'Error deleting user.');
    }
}
