<?php

namespace Isneezy\Timoneiro\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Isneezy\Timoneiro\Facades\Timoneiro;
use League\Flysystem\Plugin\ListWith;

class TimoneiroMediaController extends Controller
{
    protected $directory = '';
    private $filesystem;

    public function __construct()
    {
        $this->filesystem = 'public';
    }

    public function index()
    {
        // todo check permission
        // $this->authorize('browse_media');

        return Timoneiro::view('timoneiro::media.index');
    }

    public function files(Request $request)
    {
        // todo check permission
        // $this->authorize('browse_media');

        $folder = $request->get('folder', '/');
        if ($folder === '/') {
            $folder = '';
        }

        $dir = $this->directory.$folder;
        $storage = Storage::disk($this->filesystem)->addPlugin(new ListWith());
        $files = collect($storage->listWith(['mimetype'], $dir))
            ->map(function ($item) use ($storage) {
                $file = [];
                $file['name'] = $item['basename'];
                $file['type'] = $item['type'] == 'dir' ? 'folder' : $item['mimetype'] ?? 'file';
                $file['path'] = Storage::disk($this->filesystem)->url($item['path']);
                $file['relative_path'] = $item['path'];
                if ($item['type'] == 'dir') {
                    $file['items'] = '';
                } else {
                    $file['size'] = $item['size'];
                    $file['thumbnails'] = [];
                }
                $file['last_modified'] = Carbon::createFromTimestamp($item['timestamp']);

                return $file;
            })
            ->all();

        return response()->json($files);
    }

    public function newFolder(Request $request)
    {
        // todo check permission
        // $this->authorize('browse_media');
        $success = false;
        $error = '';

        $newFolder = $request->get('new_folder');
        $newFolder = str_replace('//', '', $newFolder);

        if (Storage::disk($this->filesystem)->exists($newFolder)) {
            $error = 'Folder already exists';
        } elseif (Storage::disk($this->filesystem)->makeDirectory($newFolder)) {
            $success = true;
        } else {
            $error = 'Error creating directory';
        }

        return response()->json(compact('success', 'error'));
    }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request) {
        $path = str_replace('//', '/', Str::finish($request->path, '/'));

        try {
            collect($request->allFiles())->each(function (UploadedFile $file) use ($path) {
                $extension = $file->getClientOriginalExtension();
                $name = Str::replaceLast('.' . $extension, '', $file->getClientOriginalName());
                $file_name = $name . '.' . $extension;
                $conflicts = 0;
                while (Storage::disk($this->filesystem)->exists($path . $file_name)) {
                    $conflicts++;
                    $file_name = $name . '_' . str_pad($conflicts, 2, '0', STR_PAD_LEFT) . '.' . $extension;
                }

                $file->storeAs($path, $file_name, $this->filesystem);
            });
            $success = true;
            $message = '';
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json(compact('success', 'message'));
    }
}
