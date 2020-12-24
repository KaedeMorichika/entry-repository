<?php

function sanitize_get ($parameter) {
    return htmlspecialchars($parameter, ENT_QUOTES, mb_internal_encoding());
}