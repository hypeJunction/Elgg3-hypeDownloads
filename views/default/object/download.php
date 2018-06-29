<?php

$vars['attachments'] = elgg_view('object/download/releases', $vars);
$vars['attachments'] .= elgg_view('object/download/changelog', $vars);

echo elgg_view('post/view', $vars);
