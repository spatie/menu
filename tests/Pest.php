<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
*/

function assertHtmlEquals(string $expected, string $actual, string $message = ''): void
{
    expect(sanitizeHtmlWhitespace($actual))->toEqual(sanitizeHtmlWhitespace($expected));
}

function sanitizeHtmlWhitespace(string $subject): string
{
    $find = ['/>\s+</', '/(^\s+)|(\s+$)/'];
    $replace = ['><', ''];

    return preg_replace($find, $replace, $subject);
}

function assertRenders(string $expected): void
{
    assertHtmlEquals($expected, test()->menu->render());
}
