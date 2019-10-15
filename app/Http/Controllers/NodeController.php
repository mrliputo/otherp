<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Nodes;
use App\Sensors;
use App\SensorValues;

class NodeController extends Controller
{
    public function view($id)
    {
    	$nodes = Nodes::where('user_id', auth()->user()->id)->orderByDesc('created_at')->get();
        $thisNode = Nodes::find($id);
        return view('view')->with('nodes', $nodes)->with('thisNode', $thisNode);
    }

    public function monitor($id)
    {
        $nodes = Nodes::where('user_id', auth()->user()->id)->orderByDesc('created_at')->get();
        $thisNode = Nodes::find($id);
        return view('monitor')->with('nodes', $nodes)->with('thisNode', $thisNode);
    }

    public function post(Request $req) {
    	$node = new Nodes;
    	$node->name = $req->input('name');
    	$node->description = $req->input('description');
    	$node->access_type = $req->input('access_type');
    	$node->user_id = auth()->user()->id;
        $node->api_key = md5(microtime().rand());
        if($node->save()){
          return redirect(route('dashboard'))->with('success', 'Berhasil membuat node');
      }else{
          return redirect(route('dashboard'))->with('error', 'Gagal membuat node');
      }
  }

  public function update(Request $req, $id) {
    $node = Nodes::find($id);
    $node->name = $req->input('name');
    $node->description = $req->input('description');
    $node->access_type = $req->input('access_type');
    if($node->save()){
        return redirect(route('node.view', $id))->with('success', 'Berhasil mengubah node');
    }else{
        return redirect(route('node.view', $id))->with('error', 'Gagal mengubah node');
    }
}

public function clear($id) {
    $sensors = Sensors::where('node_id', $id);
    $sensors->delete();
    return redirect(route('node.view', $id))->with('success', 'Berhasil menghapus data sensor');
}

public function delete($id) {
    $node = Nodes::find($id);
    $node->delete();
    return redirect(route('dashboard'))->with('success', 'Berhasil menghapus node');
}

public function write(Request $req) {
    $node = Nodes::where('api_key', $req->input('api_key'))->where('user_id', auth()->user()->id)->get()->toArray();
    if(count($node) > 0) {
        $nid = $node[0]['id'];
        $sensorsForThisNode = Sensors::select('id')->where('node_id', $nid)->get()->toArray();
        $allowedSensors = array_column($sensorsForThisNode, 'id');

        foreach($_GET as $k => $v) {
            if($k != 'api_key') {
                if(in_array($k, $allowedSensors)) {
                    $sv = new SensorValues;
                    $sv->sensor_id = $k;
                    $sv->value = $v;
                    $sv->save();
                    echo 'OK: sensor #' . $k . ' => ' . $v . "<br>";
                }else{
                    echo 'Error: sensor #' . $k . ' => ' . $v . "<br>";
                }
            }
        }
    }else{
        return 'Not found';
    }
}
}
