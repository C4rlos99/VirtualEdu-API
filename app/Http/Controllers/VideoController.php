<?php

namespace App\Http\Controllers;

use App\Http\Requests\EliminarVideo;
use App\Http\Requests\GuardarVideo;
use App\Http\Requests\ObtenerVideo;
use App\Http\Resources\VideoResource;
use App\Models\Escena;
use App\Models\Video;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

use function PHPSTORM_META\map;

class VideoController extends Controller
{
    public function guardarVideo(GuardarVideo $request)
    {
        $file = $request->file("video");

        $fileNombre = time() . "_" . $file->getClientOriginalName();

        $file->storeAs("", $fileNombre, "public");

        $video = Video::create([
            "nombre" => $file->getClientOriginalName(),
            "escenario_id" => $request->escenario_id,
            "localizacion" => "videos/" . $fileNombre,
        ]);

        return response()->json([
            "mensaje" => "Video guardado",
            "video" => new VideoResource($video),
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
                "mensaje" => "Oh! Algo no fue bien",
                "errores" => "El video no puede ser eliminado.\n
                    Modifique los campos de video para las siguientes escenas: " . $titulosEscenasVideo . ".",
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
