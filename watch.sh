#!/bin/sh

# If a command fails then the deploy stops
set -e

rez-env hugo -- hugo server -w -v --debug --buildDrafts