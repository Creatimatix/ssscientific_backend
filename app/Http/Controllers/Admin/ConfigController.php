<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Config;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index(){
        $configs = Config::all();
        return view('admin.configs.index',[
            'configs' => $configs
        ]);
    }

    public function create(){
        return view('admin.configs.create');
    }

    public function store(Request $request){
        $name = $request->get('name');
        $value = $request->get('value');

        $validator = $request->validate([
            'name' => 'required|unique:configs,name',
            'value' => 'required',
            'status' => 'required',
        ]);

        $config = new Config();
        $config->name = $name;
        $config->value = $value;
        $config->status = $request->get('status');
        $config->save();
        return redirect()->route('configs')->with('configSuccessMsg','Config created successfully.');

    }

    public function edit(Request $request,Config $config){
        if($config){
            return view('admin.configs.edit',[
                'model' => $config
            ]);
        }
        return redirect()->route('configs')->with('configErrorMsg','Invalid request.');
    }

    public function update(Request $request){
        $id = $request->get('id');
        $name = $request->get('name');
        $value = $request->get('value');

        $validator = $request->validate([
            'name' => 'required|unique:configs,name,'.$id,
            'value' => 'required',
            'status' => 'required',
        ]);
        $config  = Config::where('id', $id)->get()->first();
        if($config){
            $config->name = $name;
            $config->value = $value;
            $config->status = $request->get('status');
            $config->save();
            return redirect()->route('configs')->with('configSuccessMsg','Config updated
             successfully.');
        }else{
            return redirect()->route('configs')->with('configErrorMsg','Invalid request.');
        }
    }


    public function destroy(Config $config){
        try{
            if($config){
                $config->delete();
                return redirect()->back()->with('configSuccessMsg',"Config deleted successfully.");
            }
        }catch(\Exception $e){
            return redirect()->back()->with('configErrorMsg',"Config not found.");
        }
    }
}
