<?php

namespace App\Http\Controllers;

use App\Http\Requests\EliminarVideo;
use App\Http\Requests\GuardarVideo;
use App\Http\Resources\VideoResource;
use App\Models\Escena;
use App\Models\Video;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class VideoController extends Controller
{
    public function guardarVideos(GuardarVideo $request)
    {
        $videosCollection = [];

        foreach ($request->videos as $file) {
            $fileNombre = time() . "_" . $file->getClientOriginalName();

            $file->storeAs("", $fileNombre, "public");

            $video = Video::create([
                "nombre" => $file->getClientOriginalName(),
                "escenario_id" => $request->escenario_id,
                "localizacion" => "videos/" . $fileNombre,
            ]);

            $videosCollection[] = $video;
        }

        return response()->json([
            "mensaje" => "Videos guardados",
            "videos" => VideoResource::collection($videosCollection),
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function eliminarVideo(EliminarVideo $request)
    {
        $titulosEscenasVideo = Escena::select("titulo")->where("video_id", $request->id)->orWhere("video_apoyo_id", $request->id)->orWhere("video_refuerzo_id", $request->id)->get();
        $titulosEscenasVideo = $titulosEscenasVideo->map(function ($item) {
            return $item->titulo;
        })->join(", ");

        if ($titulosEscenasVideo)
            throw new HttpResponseException(response()->json([
                "mensaje" => "El video no puede ser eliminado\nPara ello modifique los campos de video para las siguientes escenas:\n\n" . $titulosEscenasVideo,
                "status" => Response::HTTP_UNPROCESSABLE_ENTITY,
            ], Response::HTTP_UNPROCESSABLE_ENTITY));

        $video = Video::findOrFail($request->id);

        unlink($video->localizacion);

        $video->delete();

        return response()->json([
            "mensaje" => "Video eliminado",
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }
}
