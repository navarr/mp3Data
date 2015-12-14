<?php

namespace Navarr;

use getID3;
use getid3_lib;

class mp3Data
{
    protected $getid3;
    protected $analyzed = false;
    public $info;
    protected $error;

    public function __construct($filename = null)
    {
        $this->getid3 = new getID3();
        $this->getid3->encoding = 'UTF-8';
        $this->error = [];
        if ($filename !== null) {
            $this->analyze($filename);
        }
    }

    public function analyze($filename)
    {
        if (!file_exists($filename)) {
            throw new \RuntimeException('File does not exist');
        }
        if ($this->getid3->Analyze($filename)) {
            getid3_lib::CopyTagsToComments($this->getid3->info);
        }
        $this->analyzed = true;
        $this->info = $this->getid3->info['comments'];

        return true;
    }

    public function getArt($id = 0)
    {
        $this->throwErrorIfNotAnalyzed();

        if (!isset($this->getid3->info['id3v2']['APIC'][$id]['data'])) {
            return;
        }
        $img = imagecreatefromstring($this->getid3->info['id3v2']['APIC'][$id]['data']);

        return $img;
    }

    public function getArts()
    {
        $this->throwErrorIfNotAnalyzed();
        if (!isset($this->getid3->info['id3v2']['APIC'])) {
            return [];
        }
        $ra = [];
        foreach ($this->getid3->info['id3v2']['APIC'] as $v) {
            $ra[] = imagecreatefromstring($v['data']);
        }

        return $ra;
    }

    public function getInfo()
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info;
    }

    public function getRawInfo()
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->getid3->info;
    }

    public function getName($id = 0)
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['title'][$id];
    }

    public function getNames()
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['title'];
    }

    public function getArtist($id = 0)
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['artist'][$id];
    }

    public function getArtists()
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['artist'];
    }

    public function getAlbum($id = 0)
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['album'][$id];
    }

    public function getAlbums()
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['album'];
    }

    public function getYear($id = 0)
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['year'][$id];
    }

    public function getYears()
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['year'];
    }

    public function getGenre($id = 0)
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['genre'][$id];
    }

    public function getGenres()
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['genre'];
    }

    public function getTrack($id = 0)
    {
        $this->throwErrorIfNotAnalyzed();

        $info = explode('/', $this->info['track_number'][$id]);

        return $info[0];
    }

    public function getTotalTracks($id = 0)
    {
        $this->throwErrorIfNotAnalyzed();

        $info = explode('/', $this->info['track_number'][$id]);
        $return = isset($info[1]) ? $info[1] : null;

        return $return;
    }

    public function getTracks()
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['track_number'];
    }

    public function getComment($id = 0)
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['comment'][$id];
    }

    public function getComments()
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['comment'];
    }

    public function getLyric($id = 0)
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['unsynchronised_lyric'][$id];
    }

    public function getLyrics()
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['unsynchronised_lyric'];
    }

    public function getBand($id = 0)
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['band'][$id];
    }

    public function getBands()
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['band'];
    }

    public function getPublisher($id = 0)
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['publisher'][$id];
    }

    public function getPublishers()
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['publisher'];
    }

    public function getComposer($id = 0)
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['composer'][$id];
    }

    public function getComposers()
    {
        $this->throwErrorIfNotAnalyzed();

        return $this->info['composer'];
    }

    private function throwErrorIfNotAnalyzed()
    {
        if ($this->analyzed) {
            return;
        }
        throw new \RuntimeException('File must be analyzed before attempting to read from it.');
    }
}
