<?php
namespace TCG\Voyager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Facades\Voyager;

class VoyagerUserController extends Controller
{
    public function remove_avatar($id)
    {
    
        $user = Voyager::model('User')->findOrFail($id);

        if (isset($user->id)) {
            $user->avatar = '';
            $user->save();
        }

        return back()->with([
            'message'    => "Successfully removed image",
            'alert-type' => 'success',
        ]);
    }
}
?>