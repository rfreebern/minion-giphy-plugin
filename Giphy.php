<?php

namespace Minion\Plugins;

require 'vendor/autoload.php';

$Giphy = new \Minion\Plugin(
    'Giphy',
    'GIFs for minions.',
    'Ryan N. Freebern / ryan@freebern.org'
);

return $Giphy

->on('PRIVMSG', function ($data) use ($Giphy) {
    list ($command, $arguments) = $Giphy->simpleCommand($data);
    if ($command == 'gif') {
        $target = $data['arguments'][0];
        if ($target == $Giphy->Minion->State['Nickname']) {
                list ($target, $ident) = explode('!', $data['source']);
        }
        if (count($arguments)) {
            $giphy = new \rfreebern\Giphy();
            $result = $giphy->random(implode(' ', $arguments));
            if ($result) {
                $Giphy->Minion->msg($result->data->image_original_url, $target);
            } else {
                $Giphy->Minion->msg('Nothing found.', $target);
            }
        }
    }
});
