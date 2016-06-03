# udpxy_transcoder

This project is for streaming IPTV to users with low-bandwidth
connection - for example GSM 3G/4G.

Requirements:
 - IPTV multicast traffic. Probably provided by your internet provider
 - working udpxy - http://www.udpxy.com/index-en.html
 - Hosting for this script

To implement transcoding this script get a stream from udpxy, convert
it via ffmpeg (different encoding profiles available) and stream a
result to a streaming server (tested with Nimble Streamer -
https://wmspanel.com/nimble).

Script automatically generates playlist from standard m3u8 files
(located at the "playlist" directory) changing them on request
depending on input parameters.

Examples:
http://host/udpxy_transcoder/?source=be-tv
    Playlist item example (stream directly from udpxy):
    #EXTINF:0,
    http://udpxy_host:4022/udp/233.33.210.86:5050

http://host/udpxy_transcoder/?source=be-tv&feed_name=tv1
    Playlist item example (stream from the script host via ffmpeg):
    #EXTINF:0,
    http://host/udpxy_transcoder/?source=be-tv&feed_name=tv1&stream=233.33.210.86:5050

http://host/udpxy_transcoder/?source=be-tv&feed_name=tv1&preset=5
    Playlist item example (stream from the script host via ffmpeg):
    #EXTINF:0,
    http://host/udpxy_transcoder/?source=be-tv&feed_name=tv1&preset=5&stream=233.33.210.86:5050

When your HTPC (tested on Kodi + IPTV Simple Client) trying to get the
above url, script runs ffmpeg - it takes stream from udpxy and then
encoded data goes to a streamer (Nimble Streamer).
Script has polling feature - it makes http requests to streamer server
(in example 10 times per 1 second).
If server returns "200" code, then the script makes redirect via
header "Location".

So, to feed you player (for example Kodi, VLC) you need provide a
playlist, for example:
http://host/udpxy_transcoder/?source=be-tv&feed_name=tv1&preset=5

Presets are in the conf_example.php file.
If preset doesn't provided, then default value is 0. It means -
low bitrate, ugly picture.
conf_example.php - it's just an example. Script uses conf.php
