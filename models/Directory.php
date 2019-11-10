<?php

namespace app\models;

//use yii\helpers\FileHelper;

class Directory
{
    /**
     * Create a directory along the specified path
     *
     * @param $id integer name of directory in uploads folder
     * @return string Path for directory
     */
    public function createDirectory($id) {
        $path = 'uploads' . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR;

        if(!is_dir($path)) {
            //FileHelper::createDirectory($path);
            $oldmask = umask(0);
            mkdir($path, 0777);
            umask($oldmask);
        }

        return $path;
    }

    public function createDirectoryDocuments($id) {
        $path = 'documents' . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR;

        if(!is_dir($path)) {
            //FileHelper::createDirectory($path);
            $oldmask = umask(0);
            mkdir($path, 0777);
            umask($oldmask);
        }

        return $path;
    }

    /**
     * Delete directory along the specified path
     *
     * @param $id integer name of directory in uploads folder
     */
    public function deleteDirectory($id) {
        $path = 'uploads' . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR;
        if(is_dir($path)) {
            //FileHelper::removeDirectory($path,['recursive'=>TRUE]);
            $this->rmdir_recursive($path);
        }
    }

    /**
     * @param $dir string Path to directory
     */
    private function rmdir_recursive($dir) {
        foreach(scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) continue;
            if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
            else unlink("$dir/$file");
        }
        rmdir($dir);
    }
}