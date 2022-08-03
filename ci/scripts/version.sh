#!/bin/bash
set -x

# Authors : Steven GOURVES

#! USAGE:
#!   ./version.sh
#! MAIN:
#!   get LDAPain version

version()
{
    # Get LDAPain version from package.json
	export VERSION=$(cat package.json | jq -r '.version')
    echo "VERSION=${VERSION}" > build.env
}

version
