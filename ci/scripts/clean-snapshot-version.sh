#!/bin/bash
set -x

# Authors : Steven GOURVES

#! USAGE:
#!   ./clean-snapshot-version.sh <package-id> <job-token>
#! MAIN:
#!   Clean snapshot versions

clean()
{
    PACKAGE_ID="$1"
    TOKEN="$2"
    VERSION="$3"
    FQDN="https://gitlab.papierpain.fr"
	RETURN=0

    # Get gitlab packages version list
    PACKAGES_LIST=$(curl --header "PRIVATE-TOKEN: $TOKEN" "$FQDN/api/v4/projects/$PACKAGE_ID/packages")
    
    # Get the versions number
    PACKAGES_TO_DELETE=$(echo $PACKAGES_LIST | jq ".[] | select(.version == \"$VERSION\") | .id" | sed 's/"//g')
    PACKAGES_ARRAY=($PACKAGES_TO_DELETE)

    # Delete the versions
    for id in ${PACKAGES_ARRAY[@]}; do
        curl --request DELETE --header "PRIVATE-TOKEN: $TOKEN" "$FQDN/api/v4/projects/$PACKAGE_ID/packages/$id"
    done

	return "$RETURN"
}

source ci/version.sh

clean "$1" "$2" "$VERSION"
RETURN=$?

exit $RETURN
