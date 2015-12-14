<?php

class mp3DataTest extends PHPUnit_Framework_TestCase
{
    /** @var \Navarr\mp3Data */
    protected $mp3Data;

    protected function setUp()
    {
        $this->mp3Data = new \Navarr\mp3Data(__DIR__.'/TinyHarbour.mp3');
    }

    public function testGetInfo()
    {
        $this->assertTrue(is_array($this->mp3Data->getInfo()));
        $this->assertTrue(is_array($this->mp3Data->getRawInfo()));
    }

    public function testGetName()
    {
        $this->assertCount(1, $this->mp3Data->getNames());
        $this->assertEquals('Tiny Harbour', $this->mp3Data->getName());
    }

    public function testGetArtist()
    {
        $this->assertCount(1, $this->mp3Data->getArtists());
        $this->assertEquals('Marin Rukavina', $this->mp3Data->getArtist());
    }

    public function testGetAlbum()
    {
        $this->assertCount(1, $this->mp3Data->getAlbums());
        $this->assertEquals('A Sunny Trip South', $this->mp3Data->getAlbum());
    }

    public function testGetYear()
    {
        $this->assertCount(1, $this->mp3Data->getYears());
        $this->assertEquals(2005, $this->mp3Data->getYear());
    }

    public function testGetGenre()
    {
        $this->assertCount(1, $this->mp3Data->getGenres());
        $this->assertEquals('Other', $this->mp3Data->getGenre());
    }

    public function testGetTrack()
    {
        $this->assertCount(1, $this->mp3Data->getTracks());
        $this->assertEquals('2', $this->mp3Data->getTrack());
        $this->assertEquals('7', $this->mp3Data->getTotalTracks());
    }

    public function testGetComment()
    {
        $this->assertCount(1, $this->mp3Data->getComments());
        $this->assertEquals('Marin Rukavina best Rukavina', $this->mp3Data->getComment());
    }

    // TODO Lyrics

    public function testGetBand()
    {
        $this->assertCount(1, $this->mp3Data->getBands());
        $this->assertEquals('Marin Rukavina', $this->mp3Data->getBand());
    }

    // TODO Publisher

    public function testGetComposer()
    {
        $this->assertCount(1, $this->mp3Data->getComposers());
        $this->assertEquals('Marin Rukavina', $this->mp3Data->getComposer());
    }

    public function testGetArt()
    {
        $this->assertCount(1, $this->mp3Data->getArts());
        // TODO More
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testThrowsExceptionIfNotAnalyzed()
    {
        $mp3Data = new \Navarr\mp3Data();
        $mp3Data->getName();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testThrowsExceptionIfNoSuchFile()
    {
        $mp3Data = new \Navarr\mp3Data('NoSuchFile.mp3');
    }
}
