<?php
/**
 * Container for module's constants (hardcoded configuration).
 *
 * Authors: Alex Gusev <alex@flancer64.com>
 * Since: 2020
 */

namespace Flancer32\Csp;

class Config
{
    /** @var array https://www.w3.org/TR/CSP3/#iana-registry */
    const CSP_DIRECTIVES = [
        'base-uri',
        'child-src',
        'connect-src',
        'default-src',
        'font-src',
        'form-action',
        'frame-ancestors',
        'frame-src',
        'img-src',
        'manifest-src',
        'media-src',
        'object-src',
        'plugin-types',
        'report-uri',
        'report-to',
        'sandbox',
        'script-src',
        'script-src-attr',
        'script-src-elem',
        'style-src',
        'style-src-attr',
        'style-src-elem',
        'worker-src'
    ];

    const HTTP_HEAD_CSP = 'Content-Security-Policy';
    const HTTP_HEAD_CSP_REPORT_ONLY = 'Content-Security-Policy-Report-Only';

    /** This module name. */
    const MODULE = self::MODULE_VENDOR . '_' . self::MODULE_PACKAGE;
    const MODULE_PACKAGE = 'Csp';
    const MODULE_VENDOR = 'Flancer32';

    const ROUTE_BASE = 'fl32csp';
    const ROUTE_REPORT = self::ROUTE_BASE . '/report';
}
