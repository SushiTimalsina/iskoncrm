<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

class ImageController extends Controller
{
  /**
     * Display the specified image.
     *
     * @param  string  $imageName
     * @return \Illuminate\Http\Response
     */
    public function devoteephoto($imageName)
    {
        $path = storage_path("app/devoteephotos/{$imageName}");
        if (!Storage::exists("devoteephotos/{$imageName}")) {
            abort(404);
        }
        return response()->file($path);
    }
    public function devoteeid($imageName)
    {
        $path = storage_path("app/devoteeids/{$imageName}");
        if (!Storage::exists("devoteeids/{$imageName}")) {
            abort(404);
        }
        return response()->file($path);
    }
    public function coursephoto($imageName)
    {
        $path = storage_path("app/course/{$imageName}");
        if (!Storage::exists("course/{$imageName}")) {
            abort(404);
        }
        return response()->file($path);
    }
    public function certificate($imageName)
    {
        $path = storage_path("app/coursecertificates/{$imageName}");
        if (!Storage::exists("coursecertificates/{$imageName}")) {
            abort(404);
        }
        return response()->file($path);
    }
    public function devoteeimport($filename)
    {
        $path = storage_path("app/public/uploads/{$filename}");
        if (!Storage::exists("public/uploads/{$filename}")) {
            abort(404);
        }
        return response()->download($path);
    }
    public function initiationfile($imageName)
    {
        $path = storage_path("app/initiationfiles/{$imageName}");
        if (!Storage::exists("initiationfiles/{$imageName}")) {
            abort(404);
        }
        return response()->file($path);
    }
    public function yatrafile($imageName)
    {
        $path = storage_path("app/yatra/{$imageName}");
        if (!Storage::exists("yatra/{$imageName}")) {
            abort(404);
        }
        return response()->file($path);
    }
}
