<?php

/**
 * Return carbon date using the localised format
 *
 * @param Carbon $object
 * @param string $format
 * @return mixed
 */
function carbonLocale(\Carbon\Carbon $object, $format = '%A %d %B %Y') {
    return $object->formatLocalized($format);
}