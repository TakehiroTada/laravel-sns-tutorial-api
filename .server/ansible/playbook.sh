#!/bin/bash
set -eu

# HOST : 適宜書き換え
HOST=13.230.250.27,
PRIVATE_KEY=/home/take/develop/fusic/keys/tada-laravel-tutorial-keypair.pem

ansible-playbook playbook.yml -i "${HOST}" --user=ec2-user -K --private-key ${PRIVATE_KEY}
