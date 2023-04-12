<?php

namespace HCGCloud\Pterodactyl\Managers\Server;

use HCGCloud\Pterodactyl\Managers\Manager;
use HCGCloud\Pterodactyl\Resources\Collection;
use HCGCloud\Pterodactyl\Resources\ServerDatabase;

class ServerFileManager extends Manager
{
    /**
     * Get a paginated collection of server databases.
     *
     * @param mixed $serverId
     * @param string $path
     * @param array $query
     *
     * @return Collection
     */
    public function get($serverId, $path = '', array $query = [])
    {
        if ($path !== null) {
            $path = '?directory=' . urlencode($path);
        }

        return $this->http->get("servers/$serverId/files/list" . $path, $query);
    }

    /**
     * Get a paginated collection of server databases.
     *
     * @param mixed $serverId
     * @param string $fileWithPath
     * @param array $query
     *
     * @return Collection
     */
    public function getContent($serverId, string $fileWithPath, array $query = [])
    {
        $path = '?file=' . urlencode($fileWithPath);

        return $this->http->get("servers/$serverId/files/contents" . $path, $query);
    }

    /**
     * Get a paginated collection of server databases.
     *
     * @param mixed $serverId
     * @param string $fileWithPath
     * @param array $query
     *
     * @return Collection
     */
    public function download($serverId, string $fileWithPath, array $query = [])
    {
        $path = '?file=' . urlencode($fileWithPath);

        return $this->http->get("servers/$serverId/files/download" . $path, $query);
    }

    /**
     * Get a paginated collection of server databases.
     *
     * @param mixed $serverId
     * @param string $fileWithPath
     * @param string $newName
     * @param array $query
     *
     * @return Collection
     */
    public function rename($serverId, string $fileWithPath, string $newName, array $query = [])
    {

        $oldName = basename($fileWithPath);

        return $this->http->put("servers/$serverId/files/download", $query, array_merge([
            'root' => $fileWithPath,
            'files' => [
                'from' => $oldName,
                'to' => $newName
            ]
        ]));
    }

    /**
     * Get a paginated collection of server databases.
     *
     * @param mixed $serverId
     * @param string $fileWithPath
     * @param string $newLocation
     * @param array $query
     *
     * @return Collection
     */
    public function copy($serverId, string $fileWithPath, string $newLocation, array $query = [])
    {
        return $this->http->post("servers/$serverId/files/copy", $query, array_merge([
            'root' => $fileWithPath,
            "location" => $newLocation
        ]));
    }

    /**
     * Get a paginated collection of server databases.
     *
     * @param mixed $serverId
     * @param string $fileWithPath
     * @param string $newLocation
     * @param array $query
     *
     * @return Collection
     */
    public function write($serverId, string $fileWithPath, string $newContent, array $query = [])
    {
        $path = '?file=' . urlencode($fileWithPath);

        return $this->http->post("servers/$serverId/files/write" . $path, $query, array_merge([$newContent]));
    }

    /**
     * Get a paginated collection of server databases.
     *
     * @param mixed $serverId
     * @param string $path
     * @param array $files
     * @param array $query
     *
     * @return Collection
     */
    public function compress($serverId, string $path, array $files, array $query = [])
    {
        $path = urlencode($path);

        return $this->http->post("servers/$serverId/files/compress" . $path, $query, array_merge([
            'root' => $path,
            'files' => $files
        ]));
    }

    /**
     * Get a paginated collection of server databases.
     *
     * @param mixed $serverId
     * @param string $path
     * @param string $compressedFile
     * @param array $query
     *
     * @return Collection
     */
    public function decompress($serverId, string $path, string $compressedFile, array $query = [])
    {
        $path = urlencode($path);

        return $this->http->post("servers/$serverId/files/decompress" . $path, $query, array_merge([
            'root' => $path,
            'file' => $compressedFile
        ]));
    }

    /**
     * Get a paginated collection of server databases.
     *
     * @param mixed $serverId
     * @param string $path
     * @param array $files
     * @param array $query
     *
     * @return Collection
     */
    public function delete($serverId, string $path, array $files, array $query = [])
    {
        $path = urlencode($path);

        return $this->http->post("servers/$serverId/files/delete" . $path, $query, array_merge([
                'root' => $path,
                "files" => $files
            ]
        ));
    }

    /**
     * Get a paginated collection of server databases.
     *
     * @param mixed $serverId
     * @param string $path
     * @param string $folderName
     * @param array $query
     *
     * @return Collection
     */
    public function createFolder($serverId, string $path, string $folderName, array $query = [])
    {
        $path = urlencode($path);

        return $this->http->post("servers/$serverId/files/create-folder" . $path, $query, array_merge([
            'root' => $path,
            'name' => $folderName
        ]));
    }

    /**
     * Get a paginated collection of server databases.
     *
     * @param mixed $serverId
     * @param string $path
     * @param array $query
     *
     * @return Collection
     */
    public function uploadFile($serverId, string $path, array $query = [])
    {
        $path = urlencode($path);

        return $this->http->post("servers/$serverId/files/upload" . $path, $query, array_merge([
            'root' => $path,
        ]));
    }

}
