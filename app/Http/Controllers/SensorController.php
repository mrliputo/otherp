<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sensors;
use App\SensorValues;

class SensorController extends Controller
{
    public function update(Request $req, $id) {
    	$sensor = Sensors::find($id);
    	$sensor->name = $req->input('name');
    	$sensor->unit = $req->input('unit');
    	$sensor->threshold = $req->input('threshold');
    	if($sensor->save()){
    		return redirect(route('node.view', $sensor->node_id))->with('success', 'Berhasil meng-update sensor');
    	}else{
    		return redirect(route('node.view', $sensor->node_id))->with('error', 'Gagal meng-update sensor');
    	}
    }

    public function post(Request $req) {
        $sensor = new Sensors;
        $sensor->name = $req->input('name');
        $sensor->unit = $req->input('unit');
        $sensor->threshold = $req->input('threshold');
        $sensor->node_id = $req->input('node_id');
        $sensor->save();
        return redirect(route('node.view',$req->input('node_id')))->with('success', 'Berhasil menambah sensor');
    }

    public function delete(Request $req) {
        $sid = $req->input('sensor-id');
        $nid = $req->input('node-id');

        $sv = SensorValues::where('sensor_id', $sid);
        $sv->delete();

        $sensor = Sensors::find($sid);
        $sensor->delete();
        return redirect(route('node.view', $nid))->with('success', 'Berhasil menghapus sensor');
    }
}
