<?php

namespace App\Http\Controllers;

use App\Http\Resources\SongResourceEedit;
use App\Http\Resources\SongResourceShow;
use App\Models\Category;
use App\Models\Singer;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use getID3;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $songs = Song::all();
        return response(SongResourceShow::collection($songs), 200);
    }
    public function getAll()
    {
        //
        $songs = Song::all();
        return view('songs.index', compact('songs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        $categories = Category::get(['id', 'name']);
        $singers = Singer::get(['id', 'name']);
        return response([
            'categories' => $categories,
            'singers' => $singers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'file' => 'required',
            'category' => 'required',
            'singer' => 'required',
        ]);
        $file = $request->file('file');
        $temporaryFilePath = $file->getRealPath();
        $getID3 = new getID3();
        $fileInfo = $getID3->analyze($temporaryFilePath);
        $durationInSeconds = $fileInfo['playtime_seconds'];
        $slug = strtolower($this->convert_name(preg_replace('!\s+!', ' ', trim($request->name))));
        $fileName = $slug . "-" . time() . '.' . $file->getClientOriginalExtension();

        $pathSong = $file->move(
            'uploads/filePaths',
            $fileName
        );
        $song = new Song;
        $song->name = preg_replace('!\s+!', ' ', $request->name);
        $song->file_path = $pathSong;
        $song->total_time = $durationInSeconds;
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = md5(time()) . '.' . $thumbnail->getClientOriginalExtension();
            $pathThumbnail = $thumbnail->move(
                'uploads/thumbnails',
                $thumbnailName
            );
            $song->thumbnail = $pathThumbnail;
        }
        if ($song->save()) {
            $song->categories()->attach($request->input('category'));
            $song->singers()->attach($request->input('singer'));
            $song->slug = $slug . '.' . $song->id;
            $song->save();
            // return response(['message' => 'add success'], 201);
            return back()->withErrors([
                'erro' => 'Thêm bài hát thành công.',
            ]);
        } else {
            // return response(['message' => 'add fail'], 203);
            return back()->withErrors([
                'erro' => 'Thêm bài hát thất bại.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {

        $song = Song::where('slug', $slug)->firstOrFail();
        if (!$song)
            return response(['message' => 'Song not found'], 404);

        if ($song->packet != "vip") {
            $song->listens += 1;
            $song->save();
            return response(new SongResourceShow($song));
        } else {
            if (Auth::check() && Auth::user()->role != 'user') {
                $song->listens += 1;
                $song->save();
                return response(new SongResourceShow($song));
            } else {
                return Response(['message' => 'vip only'], 403);
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        //
        $song = Song::where('slug', $slug)->firstOrFail();
        if (!$song)
            return response(['message' => 'Song not found'], 404);
        return response(new SongResourceEedit($song));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'singer' => 'required',
        ]);
        $song = Song::find($id);
        if (!$song)
            return response(['message' => 'Song not found'], 404);
        $song->name = preg_replace('!\s+!', ' ', $request->name);
        $slug = strtolower($this->convert_name(preg_replace('!\s+!', ' ', trim($request->name))));
        $song->slug = $slug . '.' . $song->id;
        if ($request->hasFile('file')) {
            $destinationPath = 'uploads/filePaths';
            if (File::exists($destinationPath . "/" . $song->file)) {
                File::delete($destinationPath . "/" . $song->file);
            }
            $file = $request->file('file');
            $fileName = $slug . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->move(
                "uploads/filePaths",
                $fileName
            );

            $song->file_path = $filePath;
        }
        if ($request->hasFile('thumbnail')) {
            $destinationPath = 'uploads/thumbnails';
            if (File::exists($destinationPath . "/" . $song->thumbnail)) {
                File::delete($destinationPath . "/" . $song->thumbnail);
            }
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = md5(time()) . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnailPath = $thumbnail->move(
                "uploads/thumbnails",
                $thumbnailName
            );

            $song->thumbnail = $thumbnailPath;
        }
        if ($song->save()) {
            $song->categories()->sync($request->input('category'));
            $song->singers()->sync($request->input('singer'));

            // return response(['message' => 'update success'], 200);
            return back()->withErrors([
                'erro' => 'edit thành công.',
            ]);
        } else {
            // return response(['message' => 'update fail'], 203);
            return back()->withErrors([
                'erro' => 'edit thất bại.',
            ]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $song = Song::find($id);
        if (!$song)
            return response(['message' => 'Song not found'], 404);
        $song->categories()->detach();
        $song->singers()->detach();
        $song->comments()->delete();
        if (File::exists("uploads/filePaths" . "/" . $song->file)) {
            File::delete("uploads/filePaths" . "/" . $song->file);
        }
        if (File::exists("uploads/thumbnails" . "/" . $song->thumbnail)) {
            File::delete("uploads/thumbnails" . "/" . $song->thumbnail);
        }
        Song::destroy($song->id);
        return response(['message' => 'Delete success'], 200);
    }
    public function streamSong($fileName)
    {
        $filePath = 'uploads/filePaths' . $fileName;
        $stream = Storage::disk('local')->readStream($filePath);

        $headers = [
            'Content-Type' => ['audio/mpeg3', 'audio/x-mpeg-3', 'video/mpeg', 'video/x-mpeg'],
            'Content-Length' => Storage::size($filePath),
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
        ];
        return response()->stream(function () use ($stream) {
            fpassthru($stream);
        }, Response::HTTP_OK, $headers);
    }

    public function search($q = "")
    {
        if ($q == "")
            return Response([]);
        $songs = Song::query()->where('name', 'LIKE', '%' . $q . '%')->get();
        return Response(SongResourceShow::collection($songs));
    }

    public function getNextSong()
    {
        $song = Song::inRandomOrder()->first();
        return new Response(new SongResourceShow($song));
    }

    function convert_name($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
        $str = preg_replace("/(đ)/", "d", $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
        $str = preg_replace("/(Đ)/", "D", $str);
        $str = preg_replace("/(  )/", " ", $str);
        $str = preg_replace("/( )/", "-", $str);
        return $str;
    }
}
