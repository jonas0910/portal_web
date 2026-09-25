<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImagenMiniaturaService
{
    /** Ancho máximo de la miniatura en píxeles */
    public const ANCHO_MAX = 400;

    /**
     * Genera una miniatura a partir de la imagen principal y la guarda en el disco.
     * @param string $pathPrincipal Ruta relativa en storage (ej: noticias/abc.jpg)
     * @param string $directorioDestino Directorio donde guardar (ej: noticias/miniaturas)
     * @return string|null Ruta relativa de la miniatura o null si falla
     */
    public static function generarDesdePrincipal(string $pathPrincipal, string $directorioDestino = 'noticias/miniaturas'): ?string
    {
        if (!extension_loaded('gd')) {
            return null;
        }

        $fullPath = Storage::disk('public')->path($pathPrincipal);
        if (!is_file($fullPath)) {
            return null;
        }

        $info = @getimagesize($fullPath);
        if ($info === false) {
            return null;
        }

        $ancho = $info[0];
        $alto = $info[1];
        $mime = $info['mime'] ?? '';

        $origen = match ($mime) {
            'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($fullPath),
            'image/png' => @imagecreatefrompng($fullPath),
            'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($fullPath) : null,
            default => null,
        };

        if ($origen === false || $origen === null) {
            return null;
        }

        if ($ancho <= self::ANCHO_MAX) {
            $nuevoAncho = $ancho;
            $nuevoAlto = $alto;
        } else {
            $nuevoAncho = self::ANCHO_MAX;
            $nuevoAlto = (int) round($alto * (self::ANCHO_MAX / $ancho));
        }

        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
        if ($destino === false) {
            imagedestroy($origen);
            return null;
        }

        imagecopyresampled($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
        imagedestroy($origen);

        $extension = pathinfo($pathPrincipal, PATHINFO_EXTENSION);
        $nombreBase = pathinfo($pathPrincipal, PATHINFO_FILENAME);
        $nombreMiniatura = $nombreBase . '_thumb.' . ($extension ?: 'jpg');

        Storage::disk('public')->makeDirectory($directorioDestino);
        $pathDestino = Storage::disk('public')->path($directorioDestino . '/' . $nombreMiniatura);

        $guardado = false;
        switch (strtolower($extension)) {
            case 'png':
                $guardado = imagepng($destino, $pathDestino, 8);
                break;
            case 'webp':
                $guardado = function_exists('imagewebp') ? imagewebp($destino, $pathDestino, 85) : imagejpeg($destino, $pathDestino, 85);
                break;
            default:
                $guardado = imagejpeg($destino, $pathDestino, 85);
                break;
        }
        imagedestroy($destino);

        if (!$guardado) {
            return null;
        }

        return str_replace('\\', '/', $directorioDestino . '/' . $nombreMiniatura);
    }
}
