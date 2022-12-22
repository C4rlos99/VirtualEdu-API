<?php

namespace App\Http\Controllers;

use App\Http\Requests\EliminarVideo;
use App\Http\Requests\GuardarVideo;
use App\Http\Requests\ObtenerVideo;
use App\Http\Resources\EscenaResource;
use App\Http\Resources\VideoResource;
use App\Models\Video;
use Symfony\Component\HttpFoundation\Response;

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
        $video = Video::findOrFail($request->id);

        unlink($video->localizacion);

        $video->delete();

        return response()->json([
            "mensaje" => "Video eliminado",
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function tieneEscenas(ObtenerVideo $request)
    {
        $video = Video::findOrFail($request->id);

        $tieneEscenas = !($video->escenas()->get()->isEmpty() &&
            $video->escenasApoyo()->get()->isEmpty() &&
            $video->escenasRefuerzo()->get()->isEmpty());

        return response()->json([
            "tiene_escenas" => $tieneEscenas,
            "status" => Response::HTTP_OK
        ], Response::HTTP_OK);
    }
}
