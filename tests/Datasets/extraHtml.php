<?php

dataset('append_if', [
    [true, '<aside>Bye!</aside>', '<ul></ul><aside>Bye!</aside>'],
    [false, '<aside>Bye!</aside>', '<ul></ul>'],
    [function () {
        return true;
    }, '<aside>Bye!</aside>', '<ul></ul><aside>Bye!</aside>'],
    [function () {
        return false;
    }, '<aside>Bye!</aside>', '<ul></ul>'],
    ['is_true', '<aside>Bye!</aside>', '<ul></ul><aside>Bye!</aside>'],
    ['is_false', '<aside>Bye!</aside>', '<ul></ul>'],
]);

dataset('prepend_if', [
    [true, '<h1>Hi!</h1>', '<h1>Hi!</h1><ul></ul>'],
    [false, '<h1>Hi!</h1>', '<ul></ul>'],
    [function () {
        return true;
    }, '<h1>Hi!</h1>', '<h1>Hi!</h1><ul></ul>'],
    [function () {
        return false;
    }, '<h1>Hi!</h1>', '<ul></ul>'],
    ['is_true', '<h1>Hi!</h1>', '<h1>Hi!</h1><ul></ul>'],
    ['is_false', '<h1>Hi!</h1>', '<ul></ul>'],
]);
