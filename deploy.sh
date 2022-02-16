#!/bin/sh
set -e

#npm build for production
npm run prod

git add .

git commit -m "Build for Prod"

git push

git checkout production
git merge main -m "Merged main into production"

git push origin production

git checkout main