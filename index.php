<?php
//config file
require_once('conf.php');

/*
 * GET parameters / functionality
 * source                              - get m3u8 playlist
 * source, feed_name, [preset]         - get m3u8 playlist (transcode)
 * source, feed_name, stream, [preset] - get transcode stream
 */

function l($line)
{
    $t = explode(' ', microtime());
    echo date('Y-m-d H:i:s') . substr($t[0], 1, 2) . ' - ' . $line . "\n";
}

function final_text_print($str)
{
    header('Content-Type: text/plain');
    echo $str;
    die;
}

if (isset($_GET['debug']))
    $debug = true; else
    $debug = false;

$cfg_source = false;

if (isset($_GET['source'])) {
    $GET_source = $_GET['source'];

    if (isset($source_playlist_file[$GET_source])) {
        $cfg_playlist_file = file_get_contents($source_playlist_file[$GET_source]);

        if ($cfg_playlist_file) {
            if ((isset($source_proxy_server_url[$GET_source])) && (isset($source_playlist_replace_string[$GET_source]))) {
                $cfg_proxy_server_url = $source_proxy_server_url[$GET_source];
                $cfg_replace_string = $source_playlist_replace_string[$GET_source];
                $cfg_source = true;
            }
        }
    } else {
        final_text_print('Source not found');
    }
}

if ($cfg_source) {
    if (isset($_GET['feed_name'])) {
        $GET_feed_name = $_GET['feed_name'];

        if (isset($_GET['preset']))
            $GET_preset = $_GET['preset']; else
            $GET_preset = false;

        if (isset($_GET['stream'])) {
            $GET_stream = $_GET['stream'];

            // get transcode stream
            if ($GET_preset === false)
                $GET_preset = 0;

            if (isset($preset_array[$GET_preset])) {
                $preset = $preset_array[$GET_preset];

                $stream_url = str_replace('feed_name', $GET_feed_name, $stream_url);
                $kill_feed_mask = str_replace('feed_name', $GET_feed_name, $kill_feed_mask);

                $restream_cmd = str_replace('PULL_URL ', $cfg_proxy_server_url, $restream_cmd);
                $restream_cmd = str_replace('STREAM', $GET_stream, $restream_cmd);
                $restream_cmd = str_replace('PRESET', $preset, $restream_cmd);
                $restream_cmd = str_replace('feed_name', $GET_feed_name, $restream_cmd);

                if ($debug) {
                    echo '<pre>';
                    l($restream_cmd);
                    l($stream_url);
                    l($kill_feed_mask);
                    flush();
                    $restream_cmd_add = ' > debug.txt 2>&1';
                } else {
                    $restream_cmd_add = ' > /dev/null 2>&1';
                }

                exec('pkill -f ' . $kill_feed_mask);
                exec('nohup ' . $restream_cmd . $restream_cmd_add . ' & echo $!', $out);

                if (isset($out)) {

                    usleep($poller_interval);

                    for ($i = 0; $i < $poller_retries; $i++) {
                        $headers = get_headers($stream_url);

                        if (isset($headers[0])) {
                            $status_line = $headers[0];
                            $status_line_array = split(' ', $status_line);

                            if ($status_line_array[1]) {
                                $status_code = $status_line_array[1];

                                if ($debug) {
                                    l($status_code . ' (' . ($i + 1) . '/' . $poller_retries . ')');
                                    flush();
                                }

                                if ($status_code == 200)
                                    break;
                                else
                                    usleep($poller_interval);

                            } else {
                                break;
                            }
                        } else {
                            break;
                        }
                    }

                    if ($status_code == 200) {
                        $redirect_header = 'Location: ' . $stream_url;

                        if ($debug)
                            l($redirect_header); else
                            header($redirect_header);
                    }

                    die();
                }
            } else {
                final_text_print('Preset not found');
            }
            // end
        } else {
            // get m3u8 playlist (transcode)
            if (getenv('HTTP_X_FORWARDED_PROTO') && getenv('HTTP_X_FORWARDED_HOST'))
                $replacement = getenv('HTTP_X_FORWARDED_PROTO') . '://' . getenv('HTTP_X_FORWARDED_HOST'); else
                $replacement = getenv('REQUEST_SCHEME') . '://' . getenv('HTTP_HOST');

            $replacement .= explode('?', getenv('REQUEST_URI'))[0];

            // make query string
            $q_str['source'] = $GET_source;
            $q_str['feed_name'] = $GET_feed_name;

            if ($GET_preset)
                $q_str['preset'] = $GET_preset;

            $q_str['stream'] = '';
            // end

            $replacement = $replacement . '?' . http_build_query($q_str);

            final_text_print(str_replace($cfg_replace_string, $replacement, $cfg_playlist_file));
            // end
        }
    } else {
        //get m3u8 playlist
        final_text_print(str_replace($cfg_replace_string, $cfg_proxy_server_url, $cfg_playlist_file));
        //end
    }
}
?>
