<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;;


class uploadPhoto
{
    public function __construct (private SluggerInterface $slugger){ }

    public function uploadPhoto(
        UploadedFile $photo,
        String $directoryFolder='uploads_directory'
    ): string
    {
        $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();
        try {
            $photo->move(
                $directoryFolder,
                $newFilename
            );
        } catch (FileException $e) {
            echo "l'upload ne fonctionne pas! essaiez une autre fois!";
        }
        return $newFilename;


    }

}