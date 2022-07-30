#!/bin/bash
set -x

# Authors : Steven GOURVES

#!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
#! MAIN:
#!   Run swagger docker.
#!
#! USAGE:
#!   ./docker-swagger.sh
#!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

docker pull swaggerapi/swagger-ui
docker run -p 8081:8080 swaggerapi/swagger-ui
