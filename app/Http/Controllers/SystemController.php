<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Systems;
use Auth;

class SystemController extends Controller
{
    private function get_user_id(){
        $user = Auth::id();
      
        return response()->json($user);
    }

    public function list_all_sysytems(){
        $all_systems = Systems::paginate(3);
        return $all_systems;
    }

    public function list_specific_system(Request $request){

        $this->checkToken();

        $id = $request['id'];
        if(is_null($id)){
            return response()->json(['msg'=>'Data Not Found'],404);
        }

        $data = Systems::find($id);
        return response()->json($data,200);

    }
    public function update_system(Request $request){
        $this->checkToken();
        $id = $request['id'];
        if(is_null($id)){
            return response()->json(['msg'=>'Data Not Found'],404);
        }
        $data = Systems::find($id);
        $data->update($request->all());
        return response()->json(['msg'=>'Data Updated'],200);
    }
    public function delete_system(Request $request){
        $this->checkToken();
        $id = $request['id'];
        if(is_null($id)){
            return response()->json(['msg'=>'Data Not Found'],404);
        }
        $data = Systems::find($id);
        $data->delete();
        return response()->json(['msg'=>'Data Deleted'],200);

        
    }
    public function create_system(Request $request){
        
        $this->checkToken();
        $user_id = self::get_user_id();
        
        //Assume validated user input
        $entry_date = date_create($request['system_uptime']);
        $new_system = [
            'user_id'=>$user_id->original,
            'system_uptime'=>$entry_date,
            'total_ram'=>$request['total_ram'],
            'allocated_ram'=>$request['allocated_ram'],
            'total_disk'=>$request['total_disk'],
            'allocated_disk'=>$request['allocated_disk'],
            'pc_name'=>$request['pc_name']
        ];
        
        $is_saved = Systems::create($new_system);
        if(!$is_saved ){
            return response()->json(['msg'=>'Error Saving Data']);
        }

        return response()->json(['msg'=>'New system created']);
       

       
    }
}
