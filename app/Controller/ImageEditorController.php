<?php

namespace App\Controller;

class ImageEditorController
{
    public function index($image_url)
    {
        $image_url = base64_decode($image_url);

        $view = \View::make("common.image-editor.index", compact('image_url'))->render();

        return \Response::create($view)->send();
    }

    public function save()
    {
        $image_url = \Request::input('image_url');
        $image_data = \Request::input('image_data'); // base64

        list($type, $image_data) = explode(';', $image_data);
        list(, $image_data) = explode(',', $image_data);
        $image_data = base64_decode($image_data);

        $image = \Image::make($image_data);
        $image->save(\Str::replaceFirst(base_path(), '', $image_url));

        return;
    }
}