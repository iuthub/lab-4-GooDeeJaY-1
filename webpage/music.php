<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <title>Music Viewer</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="viewer.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div id="header">

    <h1>190M Music Playlist Viewer</h1>
    <h2>Search Through Your Playlists and Music</h2>
</div>

<div id="listarea">
    <ul id="musiclist">
        <?php
        function listSongs($songs) {
            foreach ($songs as $filename) {
                if (!str_starts_with($filename, 'songs/')){
                    $filename = "songs/".$filename;
                }
                $size = filesize($filename);
                if ($size >= 0 and $size <= 1023){
                    $size = $size . ' b';
                } elseif ($size >= 1024 and $size <= 1048575){
                    $size = round($size/1024, 2) . ' kb';
                } else {
                    $size = round($size/1024/1024, 2) . ' mb';
                }

                print "<li class=\"mp3item\"> <a href=\"$filename\">".basename($filename)." ($size) </a></li>";
            }
        }

        if (isset($_GET['playlist'])) {
            $playlist =  file_get_contents('songs/'.$_GET['playlist']);
            listSongs(explode(PHP_EOL, $playlist));
        } else {
            listSongs(glob("songs/*.mp3"));
            foreach (glob("songs/*.txt") as $filename) {
                $filename = basename($filename);
                print '<li class="playlistitem"> <a href="music.php?playlist='.$filename."\"> $filename </a></li>";
            }
        }
        ?>
    </ul>
</div>
</body>
</html>
