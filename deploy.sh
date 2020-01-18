#!/bin/sh

# If a command fails then the deploy stops
set -e

printf "\033[0;32mDeploying updates to GitHub...\033[0m\n"

# Remove previous deploy
rm -rf public

# Fetch last deploy
mkdir public
git clone git@github.com:oktomus/oktomus.github.io.git public

# Build the project.
hugo --minify -v --debug 

# Go To Public folder
cd public

# Add changes to git.
git add .

# Commit changes.
msg="rebuilding site $(date)"
if [ -n "$*" ]; then
	msg="$*"
fi
git commit -m "$msg"

# Push source and build repos.
git push origin master
