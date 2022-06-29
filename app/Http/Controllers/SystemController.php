<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Systems;
use Auth;
use Validator;
class SystemController extends Controller
{
    //Get Auth ID
    private function get_user_id(){
        $user = Auth::id();
      
        return response()->json($user);
    }

    //List All Systems System
    public function list_all_sysytems(){
        $all_systems = Systems::paginate(3);
        return $all_systems;
    }
    
    //List Specific System
    public function list_specific_system(Request $request){
        $validate = Validator::make($request->all(),
        ['id'=>'required|integer']);
        
        if($validate->fails()){
            return response()->json($validate->errors(),400);
        }
        $id = $request['id'];
        
        $data = Systems::find($id);
        if(is_null($data)){
            return response()->json(['msg'=>'Data Not Found'],404);
        }

        $data = Systems::find($id);
        return response()->json($data,200);

    }

    //Update System
    public function update_system(Request $request){
        $validate = Validator::make($request->all(),
           [ 'system_uptime'=> 'date',
            'total_ram'=> 'integer',
            'total_ram'=> 'integer',
            'allocated_ram'=> 'integer',
            'total_disk'=> 'integer',
            'pc_name'=> 'string|min:2',
                                        ]
          );
        if($validate->fails()){
            return response()->json($validate->errors());
        }
        $id = $request['id'];
        
        $data = Systems::find($id);
        if(is_null($data)){
            return response()->json(['msg'=>'Data Not Found'],404);
        }
        
        $data->update($request->all());
        return response()->json(['msg'=>'Data Updated'],200);
    }

    //Delete System
    public function delete_system(Request $request){
        $validate = Validator::make($request->all(),
            ['id'=>'required|integer']
          );
        if($validate->fails()){
            return response()->json($validate->errors(),400);
        }
        $id = $request['id'];
        
        $data = Systems::find($id);
        if(is_null($data)){
            return response()->json(['msg'=>'Data Not Found'],404);
        }
        $data->delete();
        return response()->json(['msg'=>'Data Deleted'],200);

        
    }

    //Create System
    public function create_system(Request $request){
        
       
        $user_id = self::get_user_id();
        
       $validate = Validator::make($request->all(),[
            'system_uptime'=> 'required|date',
            'total_ram'=> 'required|integer',
            'total_ram'=> 'required|integer',
            'allocated_ram'=> 'required|integer',
            'total_disk'=> 'required|integer',
            'pc_name'=> 'required|string|min:2',
       ]);

       if($validate->fails()){
         return response()->json($validator->errors(), 400);
       }
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
