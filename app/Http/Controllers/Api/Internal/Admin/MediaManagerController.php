<?php

namespace App\Http\Controllers\Api\Internal\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use TalvBansal\MediaManager\Http\Requests\UploadFileRequest;
use TalvBansal\MediaManager\Http\Requests\UploadNewFolderRequest;
use TalvBansal\MediaManager\Http\UploadedFiles;
use TalvBansal\MediaManager\Services\MediaManager;

/**
 * Class FileManagerController.
 */
class MediaManagerController extends Controller
{
    /**
     * @var MediaManager
     */
    private $mediaManager;

    /**
     * FileManagerController constructor.
     *
     * @param MediaManager $mediaManager
     */
    public function __construct(MediaManager $mediaManager)
    {
        $this->mediaManager = $mediaManager;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ls()
    {
        $path = request('path');

        return $this->mediaManager->folderInfo($path);
    }

    /**
     * @param UploadNewFolderRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createFolder(UploadNewFolderRequest $request)
    {
        $new_folder = str_slug($request->get('new_folder'));
        $folder = $request->get('folder').'/'.$new_folder;

        try {
            $result = $this->mediaManager->createDirectory($folder);

            if ($result !== true) {
                $error = $this->mediaManager->errors() ?: trans('media-manager::messages.create_error', ['entity' => 'directory']);

                return $this->errorResponse($error);
            }

            return ['success' => trans('media-manager::messages.create_success', ['entity' => 'folder'])];
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Delete a folder.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFolder(Request $request)
    {
        $folder = $request->get('path');

        try {
            $result = $this->mediaManager->deleteDirectory($folder);
            if ($result !== true) {
                $error = $this->mediaManager->errors() ?: trans('media-manager::messages.delete_error', ['entity' => 'folder']);

                return $this->errorResponse($error);
            }

            return ['success' => trans('media-manager::messages.delete_success', ['entity' => 'folder'])];
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFile()
    {
        $path = request('path');

        try {
            $result = $this->mediaManager->deleteFile($path);

            if ($result !== true) {
                $error = $this->mediaManager->errors() ?: trans('media-manager::messages.delete_error', ['entity' => 'File']);

                return $this->errorResponse($error);
            }

            return ['success' => trans('media-manager::messages.delete_success', ['entity' => 'File'])];
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * Upload new file.
     *
     * @param UploadFileRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadFiles(UploadFileRequest $request)
    {
        $files = $request->file('files');

        foreach ($files as $file) {
            $fileName = $this->checkOriginalName(
                str_slug(substr( $file->getClientOriginalName(), 0, strrpos( $file->getClientOriginalName(), '.' ))) . '.' . $file->getClientOriginalExtension(),
                $request->folder);

            $file->move("uploads/{$request->folder}" , $fileName);
        }

        return json_encode('success');
    }

    private function checkOriginalName($fileName, $folder, $i = 0) {
        if (file_exists("uploads/{$folder}/{$fileName}")) {
            $i++;
            $newFileName = substr($fileName, 0, strrpos($fileName, '.')) . "-{$i}" . substr($fileName, strrpos($fileName, '.'));
            return $this->checkOriginalName($newFileName, $folder, $i);
        }
        return $fileName;
    }

    /**
     * @param Request $request
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function rename(Request $request)
    {
        $path = $request->get('path');
        $original = $request->get('original');
        $newName = str_slug(substr($request->get('new_name'), 0, strrpos($request->get('new_name'), '.'))) . substr($request->get('new_name'), strrpos($request->get('new_name'), '.'));
        $type = $request->get('type');

        try {
            $result = $this->mediaManager->rename($path, $original, $newName);

            if ($result !== true) {
                $error = $this->mediaManager->errors() ?: trans('media-manager::messages.rename_error', ['entity' => $type]);

                return $this->errorResponse($error);
            }

            return ['success' => trans('media-manager::messages.rename_success', ['entity' => $type])];
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    /**
     * @param Request $request
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function move(Request $request)
    {
        $path = $request->get('path');
        $currentFileName = $request->get('current_item');
        $newPath = $request->get('new_path');
        $type = $request->get('type');

        $currentFile = str_finish($path, DIRECTORY_SEPARATOR).$currentFileName;
        $newFile = str_finish($newPath, DIRECTORY_SEPARATOR).$currentFileName;

        try {
            if ($type == 'Folder') {
                $result = $this->mediaManager->moveFolder($currentFile, $newFile);
            } else {
                $result = $this->mediaManager->moveFile($currentFile, $newFile);
            }

            if ($result !== true) {
                $error = $this->mediaManager->errors() ?: trans('media-manager::messages.move_error', ['entity' => $type]);

                return $this->errorResponse($error);
            }

            return ['success' => trans('media-manager::messages.move_success', ['entity' => $type])];
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function allDirectories()
    {
        return $this->mediaManager->allDirectories();
    }

    /**
     * Upload multiple files.
     *
     * @param       $error
     * @param array $notices
     * @param int   $errorCode
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function errorResponse($error, $notices = [], $errorCode = 400)
    {
        if (is_array($error)) {
            json_encode($error);
        }
        $payload = ['error' => $error];
        if (!empty($notices)) {
            $payload['notices'] = $notices;
        }

        return \Response::json($payload, $errorCode);
    }
}
