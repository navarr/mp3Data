<?php
if (!class_exists("getID3") && file_exists(dirname( __FILE__ )."/getid3/getid3.php"))
{
	require_once (dirname( __FILE__ )."/getid3/getid3.php");
}
if (!class_exists("getID3"))
{
	die ("Missing Required library, getid3");
}
// Requires getid3 - http://getid3.sourceforge.net/
// Allows retrieval of MP3 ID3 information, including Album Artwork via this simple interface.
// Sorry its not documented.
// @version 0.2
class mp3Data
{
	protected $getid3;
	protected $analyzed = FALSE;
	public $info;
	protected $error;
	public function __construct($filename = NULL)
	{
		$this->getid3 = new getID3;
		$this->getid3->encoding = 'UTF-8';
		$this->error = array ();
		if ($filename !== NULL)
		{
			$this->analyze($filename);
		}
	}
	public function analyze($filename)
	{
		if (!file_exists($filename))
		{
			$this->setError("File Doesn't Exist!");
			return FALSE;
		}
		if ($this->getid3->Analyze($filename))
		{
			getid3_lib::CopyTagsToComments($this->getid3->info);
		}
		$this->analyzed = TRUE;
		$this->info = $this->getid3->info["comments"];
		return TRUE;
	}
	public function getArt($id = 0)
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		if (! isset ($this->getid3->info["id3v2"]["APIC"][$id]["data"]))
		{
			$this->setError("No Attached Picture with ID $id");
			return FALSE;
		}
		$img = imagecreatefromstring($this->getid3->info["id3v2"]["APIC"][$id]["data"]);
		return $img;
	}
	public function getArts()
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		if (! isset ($this->getid3->info["id3v2"]["APIC"]))
		{
			$this->setError("No Attached Pictures");
			return FALSE;
		}
		$ra = array ();
		foreach ($this->getid3->info["id3v2"]["APIC"] as $v)
		{
			$ra[] = imagecreatefromstring($v["data"]);
		}
		return $ra;
	}
	public function getInfo()
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info;
	}
	public function getRawInfo()
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->getid3->info;
	}
	public function getName($id = 0)
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["title"][$id];
	}
	public function getNames()
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["title"];
	}
	public function getArtist($id = 0)
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["artist"][$id];
	}
	public function getArtists()
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["artist"];
	}
	public function getAlbum($id = 0)
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["album"][$id];
	}
	public function getAlbums()
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["album"];
	}
	public function getYear($id = 0)
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["year"][$id];
	}
	public function getYears($id = 0)
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["year"];
	}
	public function getGenre($id = 0)
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["genre"][$id];
	}
	public function getGenres()
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["genre"];
	}
	public function getTrack($id = 0)
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["track"][$id];
	}
	public function getTracks()
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["track"];
	}
	public function getComment($id = 0)
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["comments"][$id];
	}
	public function getComments()
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["comments"];
	}
	public function getLyric($id = 0)
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["unsynchronised_lyric"][$id];
	}
	public function getLyrics()
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["unsynchronised_lyric"];
	}
	public function getBand($id = 0)
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["band"][$id];
	}
	public function getBands()
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["band"];
	}
	public function getPublisher($id = 0)
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["publisher"][$id];
	}
	public function getPublishers()
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["publisher"];
	}
	public function getComposer($id = 0)
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["composer"][$id];
	}
	public function getComposers()
	{
		if (!$this->analyzed)
		{
			return $this->notAnalyzed();
		}
		return $this->info["composer"];
	}

	private function notAnalyzed()
	{
		$this->setError("Not Analyzed");
		return FALSE;
	}
	protected function setError($string)
	{
		$this->error[] = $string;
	}
	public function getError()
	{
		if (!count($this->error))
		{
			return FALSE;
		}
		return $this->error[count($this->error)-1];
	}
	public function getErrors()
	{
		if (!count($this->error))
		{
			return FALSE;
		}
		return $this->error;
	}
}