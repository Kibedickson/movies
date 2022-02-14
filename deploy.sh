#!/bin/sh
set -e

git push

git checkout production
git merge --no-ff main

#npm build for production
npm run prod

git add .

git commit -m "Build for Prod"

git push origin production

git checkout main