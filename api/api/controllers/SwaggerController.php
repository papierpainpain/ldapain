<?php

namespace Api\Controllers;

use \OpenApi\Annotations as OA;
use \OpenApi\Generator as OG;

/**
 * @OA\Info(title="LDAPain API REST", version="2.0.0")
 * 
 * @OA\Server(
 *      url="http://localhost:3000/api",
 *      description="API REST pour le LDAPain"
 * )
 * 
 * @OA\Schemes(format="http")
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      in="header",
 *      name="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 * )
 */
class SwaggerController
{

    /**
     * Returns the OpenAPI specification in YAML format.
     */
    public static function getSwagger()
    {
        $openapi = OG::scan(['./api']);

        header('Content-Type: application/x-yaml');
        http_response_code(200);
        echo $openapi->toYaml();
        exit();
    }
}
