<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function add(Request $request, $type)
    {
        $result = [];
        $path = $request->upload->store('file_'.$type);

        $result['ment'] = '성공';
        $result['path'] = $path;
        $result['result'] = true;

        return $result;
    }
}
