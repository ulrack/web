<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Web\Common\Output;

use GrizzIt\Enum\Enum;

/**
 * @method static StatusCodeEnum CODE_100()
 * @method static StatusCodeEnum CODE_101()
 * @method static StatusCodeEnum CODE_102()
 * @method static StatusCodeEnum CODE_103()
 * @method static StatusCodeEnum CODE_200()
 * @method static StatusCodeEnum CODE_201()
 * @method static StatusCodeEnum CODE_202()
 * @method static StatusCodeEnum CODE_203()
 * @method static StatusCodeEnum CODE_204()
 * @method static StatusCodeEnum CODE_205()
 * @method static StatusCodeEnum CODE_206()
 * @method static StatusCodeEnum CODE_207()
 * @method static StatusCodeEnum CODE_208()
 * @method static StatusCodeEnum CODE_209()
 *
 * @method static StatusCodeEnum CODE_300()
 * @method static StatusCodeEnum CODE_301()
 * @method static StatusCodeEnum CODE_302()
 * @method static StatusCodeEnum CODE_303()
 * @method static StatusCodeEnum CODE_304()
 * @method static StatusCodeEnum CODE_305()
 * @method static StatusCodeEnum CODE_306()
 * @method static StatusCodeEnum CODE_307()
 * @method static StatusCodeEnum CODE_308()
 *
 * @method static StatusCodeEnum CODE_400()
 * @method static StatusCodeEnum CODE_401()
 * @method static StatusCodeEnum CODE_402()
 * @method static StatusCodeEnum CODE_403()
 * @method static StatusCodeEnum CODE_404()
 * @method static StatusCodeEnum CODE_405()
 * @method static StatusCodeEnum CODE_406()
 * @method static StatusCodeEnum CODE_407()
 * @method static StatusCodeEnum CODE_408()
 * @method static StatusCodeEnum CODE_409()
 * @method static StatusCodeEnum CODE_410()
 * @method static StatusCodeEnum CODE_411()
 * @method static StatusCodeEnum CODE_412()
 * @method static StatusCodeEnum CODE_413()
 * @method static StatusCodeEnum CODE_414()
 * @method static StatusCodeEnum CODE_415()
 * @method static StatusCodeEnum CODE_416()
 * @method static StatusCodeEnum CODE_417()
 * @method static StatusCodeEnum CODE_418()
 * @method static StatusCodeEnum CODE_421()
 * @method static StatusCodeEnum CODE_422()
 * @method static StatusCodeEnum CODE_423()
 * @method static StatusCodeEnum CODE_424()
 * @method static StatusCodeEnum CODE_425()
 * @method static StatusCodeEnum CODE_426()
 * @method static StatusCodeEnum CODE_428()
 * @method static StatusCodeEnum CODE_429()
 * @method static StatusCodeEnum CODE_431()
 * @method static StatusCodeEnum CODE_451()
 *
 * @method static StatusCodeEnum CODE_500()
 * @method static StatusCodeEnum CODE_501()
 * @method static StatusCodeEnum CODE_502()
 * @method static StatusCodeEnum CODE_503()
 * @method static StatusCodeEnum CODE_504()
 * @method static StatusCodeEnum CODE_505()
 * @method static StatusCodeEnum CODE_506()
 * @method static StatusCodeEnum CODE_507()
 * @method static StatusCodeEnum CODE_508()
 * @method static StatusCodeEnum CODE_510()
 * @method static StatusCodeEnum CODE_511()
 */
class StatusCodeEnum extends Enum
{
    /**
     * 1xx ranged response codes.
     */
    public const CODE_100 = 'Continue';
    public const CODE_101 = 'Switching Protocols';
    public const CODE_102 = 'Processing';
    public const CODE_103 = 'Early Hints';

    /**
     * 2xx ranged response codes.
     */
    public const CODE_200 = 'OK';
    public const CODE_201 = 'Created';
    public const CODE_202 = 'Accepted';
    public const CODE_203 = 'Non-Authoritative Information';
    public const CODE_204 = 'No Content';
    public const CODE_205 = 'Reset Content';
    public const CODE_206 = 'Partial Content';
    public const CODE_207 = 'Multi-Status';
    public const CODE_208 = 'Already Reported';
    public const CODE_209 = 'IM Used';

    /**
     * 3xx ranged response codes.
     */
    public const CODE_300 = 'Multiple Choices';
    public const CODE_301 = 'Moved Permanently';
    public const CODE_302 = 'Found';
    public const CODE_303 = 'See Other';
    public const CODE_304 = 'Not Modified';
    public const CODE_305 = 'Use Proxy';
    public const CODE_306 = 'Switch Proxy';
    public const CODE_307 = 'Temporary Redirect';
    public const CODE_308 = 'Permanent Redirect';

    /**
     * 4xx ranged response codes.
     */
    public const CODE_400 = 'Bad Request';
    public const CODE_401 = 'Unauthorized';
    public const CODE_402 = 'Payment Required';
    public const CODE_403 = 'Forbidden';
    public const CODE_404 = 'Not Found';
    public const CODE_405 = 'Method Not Allowed';
    public const CODE_406 = 'Not Acceptable';
    public const CODE_407 = 'Proxy Authentication Required';
    public const CODE_408 = 'Request Timeout';
    public const CODE_409 = 'Conflict';
    public const CODE_410 = 'Gone';
    public const CODE_411 = 'Length Required';
    public const CODE_412 = 'Precondition Failed';
    public const CODE_413 = 'Payload Too Large';
    public const CODE_414 = 'URI Too Long';
    public const CODE_415 = 'Unsupported Media Type';
    public const CODE_416 = 'Range Not Satisfiable';
    public const CODE_417 = 'Expectation Failed';
    public const CODE_418 = 'I\'m a teapot';
    public const CODE_421 = 'Misdirected Request';
    public const CODE_422 = 'Unprocessable Entity';
    public const CODE_423 = 'Locked';
    public const CODE_424 = 'Failed Dependency';
    public const CODE_425 = 'Too Early';
    public const CODE_426 = 'Upgrade Required';
    public const CODE_428 = 'Precondition Required';
    public const CODE_429 = 'Too Many Requests';
    public const CODE_431 = 'Request Header Fields Too Large';
    public const CODE_451 = 'Unavailable For Legal Reasons';

    /**
     * 5xx ranged response codes.
     */
    public const CODE_500 = 'Internal Server Error';
    public const CODE_501 = 'Not Implemented';
    public const CODE_502 = 'Bad Gateway';
    public const CODE_503 = 'Service Unavailable';
    public const CODE_504 = 'Gateway Timeout';
    public const CODE_505 = 'HTTP Version Not Supported';
    public const CODE_506 = 'Variant Also Negotiates';
    public const CODE_507 = 'Insufficient Storage';
    public const CODE_508 = 'Loop Detected';
    public const CODE_510 = 'Not Extended';
    public const CODE_511 = 'Network Authentication Required';
}
