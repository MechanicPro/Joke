<?php

namespace App\Controller;


use Symfony\Component\Filesystem\Filesystem;

class File
{
    private $fileSystem;
    const FILE_NAME = 'Joke.txt';

    public function __construct()
    {
        $this->fileSystem = new Filesystem();
    }

    public function write($categories = null, $content = null)
    {
        $text_format = date("Y-m-d H:i:s") . ' : ' . $categories.' / '. $content . "\n";
        if ($this->fileSystem->exists(self::FILE_NAME)) {
            $this->fileSystem->appendToFile(self::FILE_NAME, $text_format);
        } else {
            $this->fileSystem->dumpFile(self::FILE_NAME, $text_format);
        }
    }
}