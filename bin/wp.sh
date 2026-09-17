#!/bin/zsh
# WP-CLI against the `fairport` Local site. Local's MySQL listens on a socket,
# not TCP, so point mysqli at it. Recreate the symlink if Local changes the
# site id: ln -sfn "~/Library/Application Support/Local/run/<id>/mysql/mysqld.sock" ~/.local-sockets/fairport.sock
php -d mysqli.default_socket="$HOME/.local-sockets/fairport.sock" -d error_reporting="E_ALL & ~E_DEPRECATED" /opt/homebrew/bin/wp --path="$HOME/Local Sites/fairport/app/public" "$@"
