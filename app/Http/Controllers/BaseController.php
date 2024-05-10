<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected $title = "";
    protected $subTitle = "";
    protected $route = "";
    protected $icon = "flaticon2-user";
    protected $resources = "admin::users.";
    protected $success = ['status' => true];
    protected $error = ['status' => false];


    public function __construct()
    {
        if ($this->title) {
            $this->route = strtolower($this->title) . ".";
        }
    }


    function createResource()
    {
        return $this->resources . 'create';
    }

    function indexResource()
    {
        return $this->resources . 'index';
    }

    function editResource()
    {
        return $this->resources . 'edit';
    }

    function showResource()
    {
        return $this->resources . 'show';
    }


    function indexRoute()
    {
        return $this->route . 'index';
    }

    function gotoCrudIndex()
    {
        return redirect()->route($this->route . 'index');
    }


    function crudInfo()
    {
        $data['title'] = $this->title;
        $data['subTitle'] = $this->subTitle;
        $data['route'] = $this->route;
        $data['icon'] = $this->icon;
        $data['item'] = new BaseModel();
        return $data;
    }

    function returnSuccess($params = null)
    {
        $data = $this->success;
        if ($data) $data['data'] = $params;
        return response()->json($data);
    }

    function returnError($params = null)
    {
        $data = $this->error;
        if ($data) $data['data'] = $params;
        return response()->json($data);
    }
}
