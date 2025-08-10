<?php

use function Pest\Laravel\get;

test('test admin routes requires auth', function(): void {
   get('/')->assertRedirect('/login');
});
