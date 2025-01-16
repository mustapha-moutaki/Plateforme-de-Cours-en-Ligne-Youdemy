<?php

function convertToEmbedUrl($url) {
    $regex = '/(?:https?:\/\/(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/))([^"&?\/\s]{11})/';

    if (preg_match($regex, $url, $matches)) {
        $videoId = $matches[1];
        return "https://www.youtube.com/embed/" . $videoId;
    }

    return $url;
}
