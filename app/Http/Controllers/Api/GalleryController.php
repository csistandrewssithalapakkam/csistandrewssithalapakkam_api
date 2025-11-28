<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ImageGallery;
use App\Models\ImageFolder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Get all image folders
     *
     * @OA\Get(
     *     path="/api/gallery/folders",
     *     summary="Get all image folders",
     *     tags={"Gallery"},
     *     @OA\Response(
     *         response=200,
     *         description="List of image folders",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="if_id", type="integer"),
     *             @OA\Property(property="if_name", type="string"),
     *             @OA\Property(property="if_status", type="string")
     *         ))
     *     )
     * )
     */
    public function folders(): JsonResponse
    {
        $folders = ImageFolder::where('if_status', '1')
            ->with('images')
            ->get();

        return response()->json($folders);
    }

    /**
     * Get all images
     *
     * @OA\Get(
     *     path="/api/gallery/images",
     *     summary="Get all gallery images",
     *     tags={"Gallery"},
     *     @OA\Parameter(
     *         name="folder_id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of gallery images",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="ig_id", type="integer"),
     *             @OA\Property(property="ig_folder_id", type="integer"),
     *             @OA\Property(property="ig_text", type="string"),
     *             @OA\Property(property="ig_image_url", type="string"),
     *             @OA\Property(property="ig_show_flag", type="string"),
     *             @OA\Property(property="ig_image_status", type="string")
     *         ))
     *     )
     * )
     */
    public function images(Request $request): JsonResponse
    {
        $query = ImageGallery::where('ig_image_status', '1')
            ->where('ig_show_flag', '1');

        if ($request->has('folder_id')) {
            $query->where('ig_folder_id', $request->folder_id);
        }

        $images = $query->with('folder')->get();

        return response()->json($images);
    }

    /**
     * Get images by folder
     *
     * @OA\Get(
     *     path="/api/gallery/folder/{folder_id}",
     *     summary="Get images by folder ID",
     *     tags={"Gallery"},
     *     @OA\Parameter(name="folder_id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(
     *         response=200,
     *         description="Images in the folder"
     *     ),
     *     @OA\Response(response=404, description="Folder not found")
     * )
     */
    public function folderImages($folderId): JsonResponse
    {
        $folder = ImageFolder::find($folderId);

        if (!$folder) {
            return response()->json(['message' => 'Folder not found'], 404);
        }

        $images = ImageGallery::where('ig_folder_id', $folderId)
            ->where('ig_image_status', '1')
            ->where('ig_show_flag', '1')
            ->get();

        return response()->json([
            'folder' => $folder,
            'images' => $images,
        ]);
    }
}
