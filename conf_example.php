<?php
// Nimble streamer's mpeg.2ts link
$stream_uri = '/stream/feed_name';
$stream_url = 'http://' . explode(':', getenv('HTTP_HOST'))[0] . ':8081' . $stream_uri . '/mpeg.2ts';
// end

$kill_feed_mask = 'ffmpeg.*' . $stream_uri;
$push_url = 'rtmp://127.0.0.1:1935';
$restream_cmd = 'ffmpeg -i PULL_URL STREAM PRESET -f flv ' . $push_url . $stream_uri;
$poller_interval = 100000; //micro seconds
$poller_retries = 300;

/* 0  */ $preset_array[] = '-vcodec libx264 -b:v 256k  -preset faster -tune zerolatency -movflags +faststart -probesize 32 -analyzeduration 0 -flags:v +global_header -flags:a +global_header -c:a libfdk_aac -profile:a aac_he -b:a 32k -ac 1';
/* 1  */ $preset_array[] = '-vcodec libx264 -b:v 320k  -preset faster -tune zerolatency -movflags +faststart -probesize 32 -analyzeduration 0 -flags:v +global_header -flags:a +global_header -c:a libfdk_aac -profile:a aac_he -b:a 32k -ac 1';
/* 2  */ $preset_array[] = '-vcodec libx264 -b:v 384k  -preset faster -tune zerolatency -movflags +faststart -probesize 32 -analyzeduration 0 -flags:v +global_header -flags:a +global_header -c:a libfdk_aac -profile:a aac_he -b:a 32k -ac 1';
/* 3  */ $preset_array[] = '-vcodec libx264 -b:v 448k  -preset faster -tune zerolatency -movflags +faststart -probesize 32 -analyzeduration 0 -flags:v +global_header -flags:a +global_header -c:a libfdk_aac -profile:a aac_he -b:a 32k -ac 1';
/* 4  */ $preset_array[] = '-vcodec libx264 -b:v 512k  -preset faster -tune zerolatency -movflags +faststart -probesize 32 -analyzeduration 0 -flags:v +global_header -flags:a +global_header -c:a libfdk_aac -profile:a aac_he -b:a 32k -ac 1';
/* 5  */ $preset_array[] = '-vcodec libx264 -b:v 576k  -preset faster -tune zerolatency -movflags +faststart -probesize 32 -analyzeduration 0 -flags:v +global_header -flags:a +global_header -c:a libfdk_aac -profile:a aac_he -b:a 32k -ac 1';
/* 6  */ $preset_array[] = '-vcodec libx264 -b:v 640k  -preset faster -tune zerolatency -movflags +faststart -probesize 32 -analyzeduration 0 -flags:v +global_header -flags:a +global_header -c:a libfdk_aac -profile:a aac_he -b:a 32k -ac 1';
/* 7  */ $preset_array[] = '-vcodec libx264 -b:v 704k  -preset faster -tune zerolatency -movflags +faststart -probesize 32 -analyzeduration 0 -flags:v +global_header -flags:a +global_header -c:a libfdk_aac -profile:a aac_he -b:a 32k -ac 1';
/* 8  */ $preset_array[] = '-vcodec libx264 -b:v 768k  -preset faster -tune zerolatency -movflags +faststart -probesize 32 -analyzeduration 0 -flags:v +global_header -flags:a +global_header -c:a libfdk_aac -profile:a aac_he -b:a 32k -ac 1';
/* 9  */ $preset_array[] = '-vcodec libx264 -b:v 832k  -preset faster -tune zerolatency -movflags +faststart -probesize 32 -analyzeduration 0 -flags:v +global_header -flags:a +global_header -c:a libfdk_aac -profile:a aac_he -b:a 32k -ac 1';
/* 10 */ $preset_array[] = '-vcodec libx264 -b:v 896k  -preset faster -tune zerolatency -movflags +faststart -probesize 32 -analyzeduration 0 -flags:v +global_header -flags:a +global_header -c:a libfdk_aac -profile:a aac_he -b:a 32k -ac 1';
/* 11 */ $preset_array[] = '-vcodec libx264 -b:v 960k  -preset faster -tune zerolatency -movflags +faststart -probesize 32 -analyzeduration 0 -flags:v +global_header -flags:a +global_header -c:a libfdk_aac -profile:a aac_he -b:a 32k -ac 1';
/* 12 */ $preset_array[] = '-vcodec libx264 -b:v 1024k -preset faster -tune zerolatency -movflags +faststart -probesize 32 -analyzeduration 0 -flags:v +global_header -flags:a +global_header -c:a libfdk_aac -profile:a aac_he -b:a 32k -ac 1';
/* 13 */ $preset_array[] = '-vcodec libx264 -b:v 1088k -preset faster -tune zerolatency -movflags +faststart -probesize 32 -analyzeduration 0 -flags:v +global_header -flags:a +global_header -c:a libfdk_aac -profile:a aac_he -b:a 32k -ac 1';
/* 14 */ $preset_array[] = '-vcodec libx264 -b:v 1152k -preset faster -tune zerolatency -movflags +faststart -probesize 32 -analyzeduration 0 -flags:v +global_header -flags:a +global_header -c:a libfdk_aac -profile:a aac_he -b:a 32k -ac 1';
/* 15 */ $preset_array[] = '-vcodec libx264 -b:v 1216k -preset faster -tune zerolatency -movflags +faststart -probesize 32 -analyzeduration 0 -flags:v +global_header -flags:a +global_header -c:a libfdk_aac -profile:a aac_he -b:a 32k -ac 1';

//sources array
$source_playlist_file['be-tv']           = 'playlist/Saratov-Beeline-TV.m3u8';
$source_proxy_server_url['be-tv']        = 'http://1.2.3.4:4022/udp/';
$source_playlist_replace_string['be-tv'] = 'rtp://@';

$source_playlist_file['test']           = 'playlist/Your-test.m3u8';
$source_proxy_server_url['test']        = 'http://4.3.2.1:4022/udp/';
$source_playlist_replace_string['test'] = 'rtp://@';
//end
?>
